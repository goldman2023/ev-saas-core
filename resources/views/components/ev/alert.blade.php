<div @if($id) id="{{ $id }}" @endif class="alert alert-{{ $type }} {{ $class }}" role="alert">
    @if($title) <h3 class="alert-heading">{{ $title }}</h3> @endif
    <p class="text-inherit">{{ $slot }}</p>
    @if($footer)
        <hr />
        <p class="text-inherit mb-0">{{ $footer }}</p>
    @endif
</div>
