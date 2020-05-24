@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/main.css') }}" rel="stylesheet">
@endpush

@section('content')

{{-- todo: responsive   --}}

<h2>Bienvenue chez MythoShop !</h2>

<p class='home__intro'>Le premier magasin en ligne à proposer une grande variété de créature mythologiques.</p>
<p class='home__intro'>Nous livrons chez vous en 24h chrono, même en periode de confinement !!</p>



@if(!empty($product1))
    <section class="home__section--presentation">
        <p>Zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro. De carne lumbering animata corpora quaeritis. Summus brains sit​​, morbo vel maleficia? De apocalypsi gorger omero undead survivor dictum mauris. Hi mindless mortuis soulless creaturas, imo evil stalking monstra adventus resi dentevil vultus comedat cerebella viventium. Qui animated corpse, cricket bat max brucks terribilem incessu zomby.</p>
        @include('product.includes.card', ['product' => $product1])
    </section>
@endif

@if(!empty($product2))
    <section class="home__section--presentation">
        <p>De carne lumbering animata corpora quaeritis. Summus brains sit​​, morbo vel maleficia? De apocalypsi gorger omero undead survivor dictum mauris. Hi mindless mortuis soulless creaturas, imo evil stalking monstra adventus resi dentevil vultus comedat cerebella viventium. Qui animated corpse, cricket bat max brucks terribilem incessu zomby. The voodoo sacerdos flesh eater, suscitat mortuos comedere carnem virus. Zonbi tattered for solum oculi eorum defunctis go lum cerebro.</p>
        @include('product.includes.card', ['product' => $product2])
    </section>
@endif



@endsection
