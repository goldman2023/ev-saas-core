window.initCheckoutForm = function(event) {
    // INITIALIZATION OF UNFOLD
    // =======================================================
    var unfold = new HSUnfold('.js-hs-unfold-invoker').init();

    // INITIALIZATION OF DATATABLES
    // =======================================================
    //var datatable = $.HSCore.components.HSDatatables.init($('#serialNumbersDatatable'));

    // INITIALIZATION OF SELECT2
    // =======================================================
    $('.custom-select').each(function () {
        var select2 = $.HSCore.components.HSSelect2.init($(this));
    });

    // INITIALIZATION OF TOGGLE SWITCH
    // =======================================================
    $('.js-toggle-switch').each(function () {
        var toggleSwitch = new HSToggleSwitch($(this)).init();
    });

    // INITIALIZATION OF QUANTITY COUNTER
    // =======================================================
    $('.js-quantity-counter').each(function () {
        var quantityCounter = (new window.EV.form.HSQuantityCounter()).init($(this));
    });


    // INITIALIZATION OF ADD INPUT FILED
    // =======================================================
    $('.js-add-field').each(function () {
        $(this).off();

        new HSAddField($(this), {
            addedField: function() {

            },
            deletedField: function() {
                // Hide save btn if there are no fields!
            }
        }).init();

    });


    // INITIALIZATION OF GO TO
    // =======================================================
    $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
    });

}


$(window).on('load', window.initCheckoutForm);
$(window).on('initCheckoutForm', window.initCheckoutForm);


document.addEventListener('save-new-serial-numbers', async function (event) {
    let component = event.detail.component;
    let target = event.detail.target;

    // let new_serial_numbers = [];
    //
    // $(target+' #addSerialNumberContainer > div').each(function(index, element) {
    //     let serial_number_input = $(element).find('input[name="serial_number"]');
    //     let serial_number_status_input = $(element).find('select[name="serial_number_status"]');
    //
    //     new_serial_numbers.push({
    //         'serial_number': serial_number_input.val(),
    //         'status': serial_number_status_input.val()
    //     });
    // });
    //
    // if(new_serial_numbers.length > 0) {
    //     component.set('new_serial_numbers', new_serial_numbers); // set livewire
    //     component.insertSerialNumbers();
    // }

});
