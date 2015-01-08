<ul id="menu-{{ $menu->name() }}" class="menu children">
    @foreach ($menu->children() as $child)
        @include('shift::partials.menu.item', ['item' => $child])
    @endforeach
</ul>
