<a x-data="{
        disabled: @js($disabled),
        label: @js($label),
        label_not_in_stock: @js($labelNotInStock),
    }" 
    :href="'{{ route('product.generate_checkout_link', ['id' => $model->id]) }}?qty='+qty" target="_blank" 
    class="w-full btn"
    :class="{'btn-ghost pointer-events-none opacity-60': disabled, 'btn-primary': !disabled}"
    x-text="disabled ? label_not_in_stock : label">
</a>