<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Setting;
use App\Services\CartService;
class AppServiceProvider extends ServiceProvider {
 public function register(): void { $this->app->singleton(CartService::class, fn() => new CartService()); }
 public function boot(): void {
   View::composer('layouts.store', function ($view) {
     $categories = rescue(fn() => Category::where('is_active', true)->orderBy('sort_order')->get(), collect(), report:false);
     $settings = rescue(fn() => Setting::pluck('value','key')->all(), [], report:false);
     $cartCount = collect(session('cart', []))->sum(fn($qty) => (int)$qty);
     $view->with(compact('categories','settings','cartCount'));
   });
 }
}
