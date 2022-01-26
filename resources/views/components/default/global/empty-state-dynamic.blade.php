<div {{ $attributes }} class="row justify-content-sm-center text-center py-3">
    <div class="col-sm-7 col-md-5">
      <img class="img-fluid mb-5" src="/assets/svg/illustrations/choice.svg" alt="Nothing found ilustration" style="height: 200px; max-width: 100%;">

      <h3 class="h3">{{ $title }}</h1>
      <p>
        {{ $description }}
      </p>

      <a class="btn btn-primary" href="{{ $cta['url'] }}" target="{{ $cta['target'] }}">
          {{ $cta['text'] }}
        </a>

        {{-- TODO: when this is clicked invoke filters panel --}}
        <a href="#" class="ml-3 text-center">
         {{ translate('Adjust filters') }}
        </a>
    </div>
  </div>
