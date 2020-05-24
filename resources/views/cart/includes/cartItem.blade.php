<article class="cart--item">
    <div class="remove--link__container">
        <img src="
            {{asset(Storage::url('img/product_'.$item->id.'_'.$item->associatedModel->image))}}
        " alt="">

        <a href={{ route('cart.remove', $item->id ) }}
            class="remove">Supprimer</a>
    </div>

    <div class="description">
        <h3>
            <a href={{ route('product.show', $item->id ) }}>
            {{ $item->associatedModel->name }}
            </a>
        </h3>
        <p>{{ $item->associatedModel->excerpt }}</p>
    </div>

    <div class="actions">
        <p class="price">Prix unitaire : {{ $item->price }}€</p>

        <div class="quantity">
            <div class="legend">
                <p>Qté <span class="warning">( max: {{ $item->associatedModel->quantity }} )</span> : </p>
            </div>

            {!! Form::open(['route' => 'cart.update',
                                'method' => 'POST',
                                'class' => 'cart__updateProduct',
                                'id' => 'update'.$item->id ]) !!}

                <input name="productId" type="text"
                    value={{ $item->id }}
                    form="update{{ $item->id }}"
                    hidden />

                {!! Form::submit('update', [
                    'name' => 'update',
                    'id' => 'updateItem'.$item->id,
                    'form'=> 'update'.$item->id
                    ]) !!}

                <label for="updateItem{{ $item->id }}" class="saveIcon"></label>

                <input name="quantity" type="number"
                    min="0"
                    max={{ $item->associatedModel->quantity }}
                    value={{ $item->quantity }}
                    form="update{{ $item->id }}"
                    />

            {!! Form::close() !!}

            {!! Form::open(['route' => 'cart.updaterelative',
                                'method' => 'POST',
                                'class' => 'cart__updateProduct--Relative',
                                'id' => 'updaterelative'.$item->id
                                ]) !!}

                <input name="productId" type="text"
                    value={{ $item->id }}
                    form="updaterelative{{ $item->id }}"
                    hidden />

                {!! Form::submit('+1', [
                        'name' => 'quantity',
                        'id' => 'updatePlusItem'.$item->id,
                        'form'=> 'updaterelative'.$item->id
                        ]) !!}

                <label for="updatePlusItem{{ $item->id }}" class="plusIcon"></label>


                {!! Form::submit('-1', [
                        'name' => 'quantity',
                        'id' => 'updateMinusItem'.$item->id,
                        'form'=> 'updaterelative'.$item->id
                        ]) !!}

                <label for="updateMinusItem{{ $item->id }}" class="minusIcon"></label>

            {!! Form::close() !!}

        </div>
        <p class="full-price">Total : {{ round($item->price * $item->quantity , 2) }}€</p>
    </div>
</article>
 {{--  <button type="submit" form="form1" value="Submit">Submit</button>  --}}
