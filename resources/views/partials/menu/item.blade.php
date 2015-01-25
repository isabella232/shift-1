<?php
$classes = [];

if ($item->isParent()) $classes[] = 'parent';
if ($item->isActive()) $classes[] = 'active';
?>
<li @if ($classes) class="{{ implode(' ', $classes) }}"@endif>
    @if ($item->isParent())
        <span>{{ $item->text }}</span>
        {!! HTML::menu($item->name) !!}
    @else
        <a href="{{ $item->link }}"@if ($item->isActive()) class="active"@endif>{{ $item->text }}</a>
    @endif
</li>