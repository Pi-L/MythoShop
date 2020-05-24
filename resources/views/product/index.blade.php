@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/product.css') }}" rel="stylesheet">
@endpush

@section('content')

    <h2>{{ $categorieName }}</h2>

    <section class="products--presentation">
        @foreach ($products as $product)
            @include('product.includes.card', $product)
        @endforeach
    </section>

@endsection
