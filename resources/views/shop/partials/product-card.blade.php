<div class="col-6 col-md-4 col-xl-3">
    <article class="pcard">
        <a class="pcard__img" href="{{ route('shop.product.show', $product->id) }}" 
           style="position: relative; overflow: hidden; display: flex; align-items: center; 
           justify-content: center; width: 100%; aspect-ratio: 4 / 3; background-color: var(--paper);">
            
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}" 
                     style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
            @else
                <i class="bi bi-journal-text" style="font-size: 3rem; color: var(--ink);"></i>
            @endif

            @if($product->old_price)
                <span class="tag-sale" style="position: absolute; top: .6rem; left: .6rem; z-index: 10;">
                    -{{ round((1 - $product->price / $product->old_price) * 100) }}%
                </span>
            @endif
        </a>

        <div class="pcard__body">
            <p class="pcard__cat">{{ $product->category->name }}</p>
            <h3 class="pcard__name"><a href="{{ route('shop.product.show', $product->id) }}">{{ $product->name }}</a></h3>
            <p class="pcard__price">
                <span class="price">{{ number_format($product->price) }} ₫</span>
                @if($product->old_price)
                    <span class="price-old">{{ number_format($product->old_price) }} ₫</span>
                @endif
            </p>
            <div class="pcard__actions">
                @if($product->stock > 0)
                    <div class="d-flex gap-2 w-100">
                        <form method="post" action="{{ route('shop.cart.add', $product->id) }}" class="flex-fill" data-ajax-cart>
                            @csrf
                            <button class="btn btn-outline-primary btn-sm w-100 text-nowrap" type="submit">
                                <i class="bi bi-cart-plus"></i> Thêm
                            </button>
                        </form>
                        <form method="post" action="{{ route('shop.cart.add', $product->id) }}" class="flex-fill">
                            @csrf
                            <input type="hidden" name="buy_now" value="1">
                            <button class="btn btn-primary btn-sm w-100 text-nowrap" type="submit">Mua ngay</button>
                        </form>
                    </div>
                @else 
                    <button class="btn btn-secondary btn-sm w-100" disabled>Hết hàng</button>
                @endif
            </div>
        </div>
    </article>
</div>