@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/product.css') }}" rel="stylesheet">
@endpush

@section('content')
    <h2>{{ $product->name }}</h2>

    <section class="product">
        <div class="product__presentation">

            <p class="name">Nom : {{ $product->name }}</p>
            <p class="origin">Origine :
                <a href={{ route('categorie.show', $product->categorie()->first()->id ) }}>
                    {{ $product->categorie()->first()->name }}</a>
            </p>
            <p class="description_label">Description : </p>
            <p class="description">{{ $product->description }}</p>

        </div>

        <div class="product__toCart">
            <img
                src="{{asset(Storage::url('img/product_'.$product->id.'_'.$product->image))}}"
                alt="Image de {{ $product->name }}" />

            <p class="price">Prix : {{ $product->price }}€ (HT)</p>

            {!! Form::open(['route' => 'cart.updaterelative',
                                'method' => 'POST',
                                'class' => 'cart__update--product']) !!}

                <input name="productId" type="text" value={{ $product->id }} hidden />

                <div class="quantity">

                    <label class="">Qté: </label>
                    <input name="quantity" type="number"
                        min="1"
                        max="{{ $product->quantity - ( \Cart::get($product->id) ? \Cart::get($product->id)->quantity : 0 ) }}"
                        value="0" />
                    {!! $errors->first('quantity', '<small class="help-block">:message</small>') !!}

                </div>

                {!!
                    Form::submit('Ajouter', ['name' => 'update', 'id' => 'updateItem'])
                !!}
                <label for="updateItem" class="button cartPlusIcon"></label>

            {!! Form::close() !!}

            <p class="maxQuantity">Quantité restante :
            {{
                $product->quantity -
                ( \Cart::get($product->id) ? \Cart::get($product->id)->quantity : 0 )
            }}
            </p>

        </div>
    </section>
@endsection

