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
      theme: "snow",
      attach: false
		},

		init: function (el, options) {
      if (!$(el).length) return;

			var context = this,
        $el = $(el),
				defaults = Object.assign({}, context.defaults),
				dataSettings = $el.attr('data-hs-quill-options') ? JSON.parse($el.attr('data-hs-quill-options')) : {},
				settings = {};
			settings = Object.assign({}, defaults, settings, dataSettings, options);

			/* Start : Init */

			var newQuill = new Quill(el, settings);

			/* End : Init */

      context.toolbarBottom(newQuill, settings);

			return newQuill;
		},

    toolbarBottom: function (newQuill, settings) {
      if (settings.toolbarBottom) {
        let container = $(newQuill.container),
          toolbar = $(newQuill.container).prev(".ql-toolbar"),
          parent = container.parent();

        parent.addClass("ql-toolbar-bottom");

        if (settings.attach) {
          $(settings.attach).on('shown.bs.modal', function (e) {
            container.css({
              paddingBottom: toolbar.innerHeight()
            })
          })
        } else {
          container.css({
            paddingBottom: toolbar.innerHeight()
          })
        }

        toolbar.css({
          position: "absolute",
          width: "100%",
          bottom: 0
        })
      }
    }
	};

})(jQuery);
