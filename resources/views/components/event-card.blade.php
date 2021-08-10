<div class="col-4 mb-4">
    <!-- Card -->
    <div class="card card-bordered card-hover-shadow h-100">
      <div class="card-body">
        <h3 class="mb-3">
          <a class="text-dark" href="{{ route('event.visit', $event->slug) }}">{{$event->title}}</a>
        </h3>

        <p class="d-block font-size-1 text-body mb-1">
          @if (strlen($event->getTranslation('description'))>100)
              {{substr($event->getTranslation('description'), 0, 98)."..."}}
          @else
              {{$event->getTranslation('description')}}
          @endif
      </div>

      <div class="card-footer">
        <ul class="list-inline list-separator small text-body">
          @foreach ($items as $attribute)
            @if(count($event->attributes->where('attribute_id', $attribute->id))>0)
              @php
                if($attribute->type == "date") $date =$event->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values;
              @endphp
                  <li class="list-inline-item">
                      @if ($attribute->type == "country")
                          @php
                              $country = App\Models\Country::where('code', $event->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values)->first();
                          @endphp
                          {{$country->name}}
                      @else
                          {{$event->attributes->where('attribute_id', $attribute->id)->first()->attribute_value->values}}
                      @endif
                  </li>
            @endif
          @endforeach
        </ul>
      </div>
    </div>
    <!-- End Card -->
</div>
