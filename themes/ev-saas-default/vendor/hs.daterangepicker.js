/**
 * Flatpickr wrapper.
 *
 * @author Htmlstream
 * @version 2.0
 *
 */
;(function ($) {
	'use strict';

	$.HSCore.components.HSDaterangepicker = {
		defaults: {
      nextArrow: '<i class="tio-chevron-right daterangepicker-custom-arrow"></i>',
      prevArrow: '<i class="tio-chevron-left daterangepicker-custom-arrow"></i>',
    },

		init: function (el, options, cb) {
			if (!el.length) return;

			var context = this,
				defaults = Object.assign({}, context.defaults),
				dataSettings = el.attr('data-hs-daterangepicker-options') ? JSON.parse(el.attr('data-hs-daterangepicker-options')) : {},
				settings = {};
			settings = $.extend(true, defaults, dataSettings, settings, options, cb);

			if (settings.disablePrevDates) {
				settings.minDate = moment().format('MM/DD/YYYY')
			}

			/* Start : Init */

			var newDaterangepicker = el.daterangepicker(settings, cb);

			/* End : Init */

      newDaterangepicker.on('showCalendar.daterangepicker', function (el) {
        customArrows()
      })

      function customArrows() {
        if (settings.prevArrow || settings.nextArrow) {
          $('.daterangepicker .prev').html(settings.prevArrow)
          $('.daterangepicker .next').html(settings.nextArrow)
        }
      }

			return newDaterangepicker;
		}
	};

})(jQuery);
