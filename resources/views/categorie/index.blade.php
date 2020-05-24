@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/product.css') }}" rel="stylesheet">
@endpush

@section('content')

    <h2>Categories</h2>

    <section class="categorie--presentation products--presentation">
        @foreach ($navCategories as $categorie)
            @include('categorie.includes.card', $categorie)
        @endforeach
    </section>



@endsection
