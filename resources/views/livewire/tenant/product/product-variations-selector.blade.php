<div class="c-product-variations-selector pb-3 {{ $class }}"
     x-data="{
        current: @entangle('current').defer,
        variations: @entangle('variations').defer,
        all_combinations: @entangle('all_combinations').defer,
        available_variants: @entangle('available_variants').defer,
        missing_variants: @entangle('missing_variants').defer,
        refresh() {
            this.current.variant.forEach((att_val_pair) => {
                // Get missing variants of each attribute

                let $missing = _.filter(this.missing_variants, function(missing_variant) {
                    return _.filter(missing_variant, function(missing_variant_combos) {
                        return missing_variant_combos.attribute_id === att_val_pair.attribute_id &&
                               missing_variant_combos.attribute_value_id === att_val_pair.attribute_value_id;
                    }).length > 0;
                });

                // Detect which attribute/value pair to disable - loop through $missing variants for current att_val_pair, and disable them
                _.filter($missing, function(missing_variant) {
                    $to_disable = _.head(_.filter(missing_variant, function(missing_att_val_pair) {
                        return missing_att_val_pair.attribute_value_id !== att_val_pair.attribute_value_id &&
                               missing_att_val_pair.attribute_id !== att_val_pair.attribute_id;
                    }));

                    if($to_disable.attribute_id !== undefined && $to_disable.attribute_value_id !== undefined) {
                        $($refs['c-product-variations-selector-'+$to_disable.attribute_id+'-'+$to_disable.attribute_value_id]).addClass('disabled opacity-4');
                    }
                });
            });
        },
     }"
     x-init="refresh()"
     @variation-changed.window="refresh()"
     @select-variation-end.window="refresh()"
>
    @if(!empty($attributes_for_variations))
        @foreach($attributes_for_variations as $attribute)
            <div class="full-width pb-2">
                <strong>{{ $attribute['name'] }}</strong>
                <ul class="d-flex list-group-horizontal align-items-center mb-1 mt-2 pl-0">
                    @foreach ($attribute['attribute_values'] as $value)
                        @php
                            $active = collect($this->current->variant)->filter(function($item, $key) use($value, $attribute) {
                                return $item['attribute_value_id'] === $value['id'] && $item['attribute_id'] === $attribute['id'];
                            })->isNotEmpty();
                        @endphp
                        <li class="list-group-item px-3 py-2 border rounded mr-2 pointer {{ $active ? 'active':'' }}"
                            x-ref="c-product-variations-selector-{{ $attribute['id'] }}-{{ $value['id'] }}"
                            @click="$wire.selectVariation({{ $attribute['id'] }}, {{ $value['id'] }})">
                            {{ $value['values'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif
</div>
