window.EVStockManagementFormInit = function(event) {
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
                // if added field is select2, initiate it!
                $('.js-add-field .js-custom-select-dynamic').each(function () {
                    var select2Dynamic = $.HSCore.components.HSSelect2.init($(this));
                });

                // Set values if any (after save and after form reinitialization from livewire)
                let newSerialNumbers = $('#newSerialNumbersJSON').length > 0 ? JSON.parse($('#newSerialNumbersJSON').html()) : [];
                let newSerialNumbersErrors = $('#stockManagementFormErrors').length > 0 ? JSON.parse($('#stockManagementFormErrors').html())[0] : [];

                let element = $(this.container).find('> div:last-of-type');
                let index = $(this.container).find('> div').length -1;

                let serialNumberInput = $(element).find('input[name="serial_number"]');
                let serialNumberStatusInput = $(element).find('input[name="serial_number_status"]');

                if(newSerialNumbers[index] !== undefined) {
                    try {
                        serialNumberInput.val(newSerialNumbers[index]['serial_number']);
                        serialNumberStatusInput.val(newSerialNumbers[index]['status']).trigger('change');
                    } catch(error) {
                        console.log(error);
                    }
                }

                // Append errors if any
                if(Object.keys(newSerialNumbersErrors).indexOf('new_serial_numbers.'+index+'.serial_number') !== -1) {
                    $('<small class="text-danger">'+newSerialNumbersErrors['new_serial_numbers.'+index+'.serial_number']+'</small>').insertAfter(serialNumberInput);
                }

                if(Object.keys(newSerialNumbersErrors).indexOf('new_serial_numbers.'+index+'.status') !== -1) {
                    $('<small class="text-danger">'+newSerialNumbersErrors['new_serial_numbers.'+index+'.status']+'</small>').insertAfter(serialNumberStatusInput);
                }
                //

                // Display Save btn
                $(this.container).closest('.js-add-field').find('.save-btn').removeClass('d-none').addClass('d-inline-flex');
            },
            deletedField: function() {
                // Hide save btn if there are no fields!

                if($(this.container).find('> div').length <= 0) {
                    $(this.container).closest('.js-add-field').find('.save-btn').removeClass('d-inline-flex').addClass('d-none');
                }

            }
        }).init();
    });


    // INITIALIZATION OF GO TO
    // =======================================================
    $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
    });

}


$(window).on('load', window.EVStockManagementFormInit);
$(window).on('initStockManagementForm', window.EVStockManagementFormInit);

/* Save new serial numbers */
document.addEventListener('save-new-serial-numbers', async function (event) {
    let component = event.detail.component;
    let target = event.detail.target;

    let new_serial_numbers = [];

    $(target+' #addSerialNumberContainer > div').each(function(index, element) {
        let serial_number_input = $(element).find('input[name="serial_number"]');
        let serial_number_status_input = $(element).find('select[name="serial_number_status"]');

        new_serial_numbers.push({
            'serial_number': serial_number_input.val(),
            'status': serial_number_status_input.val()
        });
    });

    if(new_serial_numbers.length > 0) {
        component.set('new_serial_numbers', new_serial_numbers); // set livewire
        component.insertSerialNumbers();
    }

});
