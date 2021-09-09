/**
 * This is fired when Select2 "Attribute Value" changes
 */
window.EV.form.select.setOnAttributeValueChange = function(selector = 'select[name^="attributes."]') {
    $(selector).off().on('change', function(e, data) {
        if(data && data.init)
            return;

        let component = Livewire.find($(this).closest('.lw-form').attr('wire:id'));

        let $att_id = $(this).data('attribute-id');
        let $att_values_idx = Array.isArray($(this).val()) ? $(this).val().map(x => parseInt(x, 10)) : $(this).val();
        let $att_values = component.get('attributes.'+$att_id+'.attribute_values');

        // TODO: Check if new custom value is added and add it to the DB
        for (const index in $att_values) {
            if($att_values_idx.indexOf($att_values[index].id) === -1) {
                component.set('attributes.'+$att_id+'.attribute_values.'+index+'.selected', false);
            } else {
                component.set('attributes.'+$att_id+'.attribute_values.'+index+'.selected', true);
            }
        }
    });
}

/**
 * This is fired when Select2 "Selected Attributes" change
 */
window.EV.form.select.setOnAttributeChange = function(selector = 'select[name="attributes"]') {
    $(selector).off().on('change', function(e, data) {
        if(data && data.init) return;

        let component = Livewire.find($(this).closest('.lw-form').attr('wire:id'));

        let $att_idx = $(this).val().map(x => parseInt(x, 10));
        let $atts = component.get('attributes');

        for (const index in $atts) {
            if($att_idx.indexOf($atts[index].id) === -1) {
                component.set('attributes.'+$atts[index].id+'.selected', false);
            } else {
                component.set('attributes.'+$atts[index].id+'.selected', true);
            }
        }
    });
}
