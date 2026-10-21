<article class="group min-w-0">
 <div class="relative overflow-hidden bg-[#f6f4ef]"><a href="{{ route('products.show',$product) }}" aria-label="View {{ $product->name }}"><img class="product-photo transition duration-500 group-hover:scale-105" loading="lazy" src="{{ $product->image_url }}" alt="{{ $product->name }}"></a>
  @if($product->compare_at_price && $product->compare_at_price > $product->price)<span class="absolute left-3 top-3 bg-white px-2.5 py-1 text-[10px] font-bold text-olive">SALE</span>@endif
 </div>
 <div class="pt-3"><a href="{{ route('products.show',$product) }}" class="line-clamp-1 text-[13px] font-semibold hover:text-olive">{{ $product->name }}</a>
 <div class="mt-1 flex items-center justify-between gap-2"><span class="text-sm font-bold">${{ number_format($product->price,2) }}</span><form method="POST" action="{{ route('cart.add',$product) }}">@csrf<input type="hidden" name="quantity" value="1"><button type="submit" {{ $product->stock<1?'disabled':'' }} title="Add {{ $product->name }} to cart" aria-label="Add {{ $product->name }} to cart" class="flex h-8 w-8 items-center justify-center border border-stone-300 transition hover:bg-ink hover:text-white disabled:cursor-not-allowed disabled:opacity-30"><svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 4h2l2.5 12h11.3L21 7H6"/><path d="M12 9v5m-2.5-2.5h5"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg></button></form></div>
 <div class="mt-1 flex items-center gap-2 text-[11px]"><span class="tracking-widest text-[#b59c51]">★★★★★</span><span class="text-stone-400">{{ $product->stock ? 'In stock':'Sold out' }}</span></div>
 </div>
</article>
