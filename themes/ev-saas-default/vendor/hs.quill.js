/**
 * HSQuill wrapper.
 *
 * @author Htmlstream
 * @version 2.0
 *
 */
;(function ($) {
	'use strict';

	$.HSCore.components.HSQuill = {
		__proto__: $.fn.quill,

		defaults: {
            theme: "snow"
		},

		init: function (el, options) {
            if (!$(el).length) {
              return;
            }

            var context = this;

            $(el).each(function(index, element) {
                let $el = $(element),
                    defaults = Object.assign({}, context.defaults),
                    dataSettings = $el.attr('data-hs-quill-options') ? JSON.parse($el.attr('data-hs-quill-options')) : {},
                    settings = {},
                    $input = $(element).closest('.quill-custom').find('> input');

                settings = Object.assign({}, defaults, settings, dataSettings, options);

                /* Start : Init */
                let newQuill = new Quill(element, settings);
                /* End : Init */

                 // Set content from livewire, if any
                 if(typeof Livewire !== 'undefined') {
                    let content = Livewire.find($(element).closest('.lw-form').attr('wire:id')).get($input.attr('name')); // get tags property from livewire form component instance
                    newQuill.root.innerHTML = content;
                 } else {
                    let content = $input.val();
                    console.log($input);
                    console.log("set content");
                    newQuill.root.innerHTML = content;
                 }

                /* On change, populate hidden element */
                newQuill.on('text-change', function(delta, oldDelta, source) {
                    $input.val(newQuill.root.innerHTML); // change value
                });
            });
        }
	};

})(jQuery);
