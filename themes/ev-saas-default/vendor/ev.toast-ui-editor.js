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
                });

                /*let newQuill = new Quill(element, settings);

                const value = $input.val();
                const delta = newQuill.clipboard.convert(value)

                newQuill.setContents(delta, 'silent');*/
                /* End : Init */

                /*  add initial content if there is any */
                // Set content from livewire, if any
                /*if(typeof Livewire !== 'undefined') {
                    let content = Livewire.find($(element).closest('.lw-form').attr('wire:id')).get($input.attr('name')); // get tags property from livewire form component instance
                    newQuill.root.innerHTML = content;
                } else {
                    let content = $input.val();
                    newQuill.root.innerHTML = content;
                }*/

                /* On change, populate hidden element */
                /*newQuill.on('text-change', function (delta, oldDelta, source) {
                    $input.val(newQuill.root.innerHTML); // change value
                });*/
            });
        }
    };
})(jQuery);
