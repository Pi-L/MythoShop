@if (Session::has('flashError'))
    <aside class="flashError">
        @foreach(Session::get('flashError') as $message)
            <p>{{ $message }}</p>
        @endforeach
    </aside>
@endif
