/**
 * HSQuill wrapper.
 *
 * @author Htmlstream
 * @version 2.0
 *
 */
;(function ($) {
	'use strict';

	$.HSCore.components.HSTyped = {
		__proto__: $.fn.typed,

		defaults: {

		},

		init: function (el, options) {
      if (!$(el).length) return;

			var context = this,
        $el = $(el),
				defaults = Object.assign({}, context.defaults),
				dataSettings = $el.attr('data-hs-typed-options') ? JSON.parse($el.attr('data-hs-typed-options')) : {},
				settings = {};
			settings = Object.assign({}, defaults, settings, dataSettings, options);

			/* Start : Init */

			var newTyped = new Typed(el, settings);

			/* End : Init */

			return newTyped;
		}
	};

})(jQuery);
