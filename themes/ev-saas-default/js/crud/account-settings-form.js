window.initAccountSettingsFormInit = function(event) {
    // INITIALIZATION OF SELECT2
    // =======================================================
    $('.custom-select').each(function () {
        var select2 = $.HSCore.components.HSSelect2.init($(this));
    });


    // INITIALIZATION OF MASKED INPUT
    // =======================================================
    $('.js-masked-input').each(function () {
        var mask = $.HSCore.components.HSMask.init($(this));
    });

    // INITIALIZATION OF TOGGLE SWITCH
    // =======================================================
    $('.js-toggle-switch').each(function () {
        var toggleSwitch = new HSToggleSwitch($(this)).init();
    });

    $('.js-pwstrength').each(function () {
        var pwstrength = $.HSCore.components.HSPWStrength.init($(this));
    });


    // INITIALIZATION OF ADD INPUT FILED
    // =======================================================
    /*$('.js-add-field').each(function () {
        new HSAddField($(this), {
            addedField: function() {

            }
        }).init();
    });*/

    // INITIALIZATION OF TOASTUI EDITOR
    // =======================================================
    $.HSCore.components.EVToastUIEditor.init('.js-toast-ui-editor');


    /* Init file managers */
    $('.custom-file-manager[data-toggle="aizuploader"]').each(function(index, element) {
        let selected_files = $.map($(element).find(".selected-files").val().split(','), function(value){
            let id = parseInt(value, 10);
            if(id) {
                return id;
            }
        });

        window.AIZ.uploader.inputSelectPreviewGenerate($(element), selected_files, true);
    });

    // INITIALIZATION OF SORTABLE
    // =======================================================
    $('.js-sortable').each(function () {
        var sortable = $.HSCore.components.HSSortable.init($(this));
    });


    // INITIALIZATION OF FLATPICKR
    // =======================================================
    $('.js-flatpickr').each(function () {
        $.HSCore.components.HSFlatpickr.init($(this));
    });


}

$(window).on('load', window.initAccountSettingsFormInit);
$(window).on('initAccountSettingsFormInit', window.initAccountSettingsFormInit);

// document.addEventListener('toastIt', async function (event) {
//     let content = event.detail.content;
//     let id = event.detail.id;
//
//     $(id).find('.toast-body').text(content);
//
//     $(id).toast({
//         delay: 3000
//     });
//
//     $(id).toast('show');
// });
