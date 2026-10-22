<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        $featured = Product::with('category')->where('is_active', true)->where('is_featured', true)->latest()->take(6)->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->withCount(['products' => fn ($q) => $q->where('is_active', true)])->get();
        $testimonials = Review::with(['user', 'product'])->where('is_approved', true)->latest()->take(3)->get();

        return view('shop.home', compact('featured', 'categories', 'testimonials'));
    }

    public function catalog(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category)->where('is_active', true));
        }
        if ($request->filled('q')) {
            $q = trim((string) $request->q);
            $query->where(fn ($where) => $where->where('name', 'like', '%'.$q.'%')->orWhere('description', 'like', '%'.$q.'%')->orWhere('sku', 'like', '%'.$q.'%'));
        }
        if ($request->filled('min')) {
            $query->where('price', '>=', max(0, (float) $request->min));
        }
        if ($request->filled('max')) {
            $query->where('price', '<=', max(0, (float) $request->max));
        }
        $query = match ($request->input('sort')) {
            'price_asc' => $query->orderBy('price'), 'price_desc' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'), 'oldest' => $query->oldest(), default => $query->latest()
        };
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('shop.catalog', compact('products', 'categories'));
    }

    public function category(Category $category)
    {
        abort_unless($category->is_active, 404);

        return redirect()->route('shop', ['category' => $category->slug]);
    }

    public function product(Product $product)
    {
        abort_unless($product->is_active, 404);
        $product->load(['category', 'approvedReviews.user']);
        $related = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->where('is_active', true)->take(4)->get();
        $rating = round((float) $product->approvedReviews->avg('rating'), 1);
        $canReview = auth()->check() && OrderItem::where('product_id', $product->id)->whereHas('order', fn ($q) => $q->where('user_id', auth()->id())->where('status', 'delivered'))->exists();

        return view('shop.product', compact('product', 'related', 'rating', 'canReview'));
    }

    public function newsletter(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email', 'max:190']]);
        NewsletterSubscriber::firstOrCreate(['email' => strtolower($data['email'])]);

        return back()->with('success', 'You are subscribed. Thank you!');
    }

    public function contact()
    {
        return view('shop.contact');
    }

    public function contactSubmit(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'email' => ['required', 'email', 'max:190'], 'subject' => ['required', 'string', 'max:190'], 'message' => ['required', 'string', 'max:4000']]);
        ContactMessage::create($data);

        return back()->with('success', 'Your message has been received.');
    }

    public function about()
    {
        return view('shop.about');
    }

    public function review(Request $request, Product $product)
    {
        abort_unless($product->is_active, 404);
        $verified = OrderItem::where('product_id', $product->id)->whereHas('order', fn ($q) => $q->where('user_id', auth()->id())->where('status', 'delivered'))->exists();
        abort_unless($verified, 403, 'Reviews require a delivered purchase.');
        $data = $request->validate(['rating' => ['required', 'integer', 'min:1', 'max:5'], 'comment' => ['required', 'string', 'min:10', 'max:1500']]);
        Review::updateOrCreate(['product_id' => $product->id, 'user_id' => auth()->id()],$data + ['is_approved' => false]);

        return back()->with('success','Thank you. Your review is awaiting moderation.');
    }
}
