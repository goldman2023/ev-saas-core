window.EV.form.radio = {
    /**
     * This is fired when Radio Attribute value changes
     */
    setOnAttributeValueChange: function(selector = 'input[name^="attributes."][type="radio"]') {
        $(selector).off().on('change', function(e, data) {
            let component = Livewire.find($(this).closest('.lw-form').attr('wire:id'));
            let $att_id = $(this).data('attribute-id');
            let $att_name = $(this).attr('name');

            $('input[name="'+$att_name+'"]').each(function(index, radio) {
                let key = $(radio).data('key');

                if($(radio).is(':checked')) {
                    component.set('attributes.'+$att_id+'.attribute_values.'+key+'.selected', true);
                } else {
                    component.set('attributes.'+$att_id+'.attribute_values.'+key+'.selected', false);
                }
            });
        });
    }
};
