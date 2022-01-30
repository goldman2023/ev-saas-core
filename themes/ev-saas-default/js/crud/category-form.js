window.initCategoryForm = function(event) {
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

}

$(window).on('load', window.initCategoryForm);
$(window).on('initCategoryForm', window.initCategoryForm);
