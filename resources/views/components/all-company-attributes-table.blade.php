 @foreach ($seller->attributes as $attribute_relationship)
     <dl class="row font-size-1">
         <dt class="col-sm-12 text-dark">
             {{ translate('Company') . ' ' . $attribute_relationship->attributes->name }}
         </dt>
         {{-- TODO: make this info dynamic from company attributes --}}
         <dd class="col-sm-12 text-body">
             {{ $attribute_relationship->attribute_value->values }}</dd>
     </dl>
 @endforeach
