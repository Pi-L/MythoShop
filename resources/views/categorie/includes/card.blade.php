
<article class="card">
    <a href={{ route('categorie.show', $categorie->id ) }}>
      <figure>
          <img
          src="{{asset(Storage::url('img/categorie_'.$categorie->id.'_'.$categorie->image))}}"
          alt="Image de {{ $categorie->name }}"
          />

          <figcaption>

          <h3>{{ $categorie->name }}</h3>
          <p>{{ $categorie->description }}</p>
          </figcaption>

      </figure>
    </a>
</article>
