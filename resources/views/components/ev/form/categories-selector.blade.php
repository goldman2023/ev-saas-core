<div class="form-group categories-selector-wrapper {{ $class }}">
    @if (!empty(trim($label)))
        <label class="input-label">{{ $label }} {!! $required ? '<span class="text-danger">*</span>':'' !!}</label>
    @endif

        <select
            name="selected_categories"
            class="categories-selector js-select2-custom custom-select @error($errorBagName) is-invalid @enderror"
            data-hs-select2-options='{!! $options !!}'
            size="1" style="opacity: 0;"
            data-level="0"
            @if($multiple) multiple @endif
            {{ $attributes }}>
            @foreach($items as $item)
                <option value="{{ $item['slug_path'] }}" @if(in_array($item['slug_path'], $selectedCategories[0] ?? [])) selected @endif>
                    {{ $item['name'] }}
                </option>
            @endforeach
        </select>

        @if($selectedCategories)
            @foreach($selectedCategories as $level => $selected)
                @if($level === 0) @continue @endif
                <select
                    name="selected_categories"
                    class="categories-selector js-select2-custom custom-select @error($errorBagName) is-invalid @enderror"
                    data-hs-select2-options='{!! $options !!}'
                    size="1" style="opacity: 0;"
                    data-level="{{ $level }}"
                    @if($multiple) multiple @endif>

                    @if($selectedCategories[$level-1] ?? null)
                        @foreach($selectedCategories[$level-1] as $parent_slug)
                            @php
                                $children = \Illuminate\Support\Collection::wrap([$items->toArray()])->pluck(Str::replace(App\Models\Category::PATH_SEPARATOR, '.children.', $parent_slug))->first();
                            @endphp
                            @if(count($children['children'] ?? []) > 0)
                                <optgroup id="group-{{ $parent_slug }}" label="{{ str_replace('.', ' / ', $parent_slug) }}">
                                    @foreach($children['children'] as $key => $child)
                                        <option value="{{ $child['slug_path'] }}" @if(in_array($child['slug_path'], $selectedCategories[$level])) selected @endif>
                                            {{ $child['name'] }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    @endif
                </select>
            @endforeach
        @endif

    @error($errorBagName)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>