<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::withCount('products')->orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new Category]);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    private function data(Request $request, ?Category $category = null): array
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100'], 'description' => ['nullable', 'string', 'max:1000'], 'image' => ['nullable', 'url:http,https', 'max:2000'], 'sort_order' => ['required', 'integer', 'min:0', 'max:9999'], 'is_active' => ['nullable', 'boolean']]);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->data($request);
        $data['slug'] = Str::slug($data['name']).'-'.strtolower(Str::random(4));
        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->data($request, $category));

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->withErrors(['category' => 'Move or delete products before deleting the category.']);
        }$category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
