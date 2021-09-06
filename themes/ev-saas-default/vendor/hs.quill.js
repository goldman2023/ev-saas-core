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



                /* On change, populate hidden element */
                newQuill.on('text-change', function(delta, oldDelta, source) {
                    $input.val(newQuill.root.innerHTML); // change value
                });
            });
        }
	};

})(jQuery);
