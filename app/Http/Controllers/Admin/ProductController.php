<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', '%'.$request->q.'%')->orWhere('sku', 'like', '%'.$request->q.'%')))
            ->when($request->filled('stock') && $request->stock === 'low', fn ($q) => $q->whereColumn('stock', '<=', 'low_stock_threshold'))->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', compact('product') + ['categories' => Category::orderBy('name')->get()]);
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:180'], 'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:80', Rule::unique('products', 'sku')->ignore($product?->id)],
            'description' => ['nullable', 'string', 'max:5000'], 'price' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'stock' => $product ? ['prohibited'] : ['required', 'integer', 'min:0', 'max:1000000'],
            'low_stock_threshold' => ['required', 'integer', 'min:0', 'max:1000000'],
            'image' => ['nullable', 'url:http,https', 'max:2000'], 'image_file' => ['nullable', 'image', 'max:3072'],
            'material' => ['nullable', 'string', 'max:120'], 'dimensions' => ['nullable', 'string', 'max:120'],
            'is_active' => ['nullable', 'boolean'], 'is_featured' => ['nullable', 'boolean'],
        ]);
    }

    private function image(Request $request, array &$data, ?Product $old = null): void
    {
        if ($request->hasFile('image_file')) {
            $new = $request->file('image_file')->store('products', 'public');
            if ($old && $old->image && ! str_starts_with($old->image, 'http')) {
                Storage::disk('public')->delete($old->image);
            }
            $data['image'] = $new;
        } elseif (! filled($data['image'] ?? null) && $old) {
            unset($data['image']);
        }
        unset($data['image_file']);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $slug = Str::slug($data['name']);
        $data['slug'] = $slug.'-'.strtolower(Str::random(5));
        $this->image($request, $data);
        DB::transaction(function () use ($data) {
            $p = Product::create($data);
            if ($p->stock > 0) {
                InventoryMovement::create(['product_id' => $p->id, 'user_id' => auth()->id(), 'change' => $p->stock, 'stock_after' => $p->stock, 'reason' => 'opening_stock']);
            }
        });

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request, $product);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $this->image($request, $data, $product);
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->stock > 0 || $product->movements()->exists()) {
            return back()->withErrors(['product' => 'Products with stock or stock history cannot be deleted. Disable visibility instead to preserve audit records.']);
        }
        if ($product->image && ! str_starts_with($product->image, 'http')) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return back()->with('success','Product deleted.');
    }
}
