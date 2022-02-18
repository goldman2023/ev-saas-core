/**
 * EV ToastUI Editor wrapper.
 *
 * @author EVSaaS
 * @version 2.0
 *
 */
; (function ($) {
    'use strict';

    $.HSCore.components.EVToastUIEditor = {
        //__proto__: $.fn.toastui_editor,

        defaults: {
            el: document.querySelector('.js-toast-ui-editor'),
            height: '400px',
            minHeight: '200px',
            initialEditType: 'wysiwyg',
            previewStyle: 'vertical',
            hideModeSwitch: true,
        },

        init: function (el, options) {
            if (!$(el).length) {
                return;
            }

            let context = this;

            $(el).each(function (index, element) {
                let $el = $(element),
                    defaults = Object.assign({}, context.defaults),
                    dataSettings = $el.attr('data-ev-toastui-editor-options') ? JSON.parse($el.attr('data-ev-toastui-editor-options')) : {},
                    settings = {},
                    $input = $(element).closest('.toast-ui-editor-custom').find('> input[data-textarea]');

                settings = Object.assign({}, defaults, settings, dataSettings, options);

                /* Start : Init */
                settings['initialValue'] = $input.val();

                let editor = new toastui.Editor(settings);
                editor.on('change', function() {
                    $input.val(editor.getHTML());
                    //$input.get(0).dispatchEvent(new Event('input'));
                });
            });
        }
    };
})(jQuery);
