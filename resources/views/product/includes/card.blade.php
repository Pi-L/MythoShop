
<article class="card">
    <figure>
        <div class="card__price-tag">
            <p>{{ $product->price }}€</p>
        </div>
        <img
        src="{{asset(Storage::url('img/product_'.$product->id.'_'.$product->image))}}"
        alt="Image de {{ $product->name }}"
        />
        <figcaption>
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->excerpt }}</p>
        <ul>
            <li>
            <a
                href={{ route('product.show', $product->id ) }}
                class="button eyeIcon"
                ></a
            >
            </li>
            <li>
            <a
                href={{ route('cart.add', $product->id ) }}
                class="button cartPlusIcon"
                ></a
            >
            </li>
        </ul>
        </figcaption>
    </figure>
</article>
