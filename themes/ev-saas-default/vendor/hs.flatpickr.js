/*
* Flatpickr wrapper
* @version: 2.0.0 (Mon, 25 Nov 2019)
* @requires: jQuery v3.0 or later, flatpickr v4.6.2
* @author: HtmlStream
* @event-namespace: .HSCore.components.HSFlatpickr
* @license: Htmlstream Libraries (https://htmlstream.com/licenses)
* Copyright 2020 Htmlstream
*/

;(function ($) {
	'use strict';

	$.HSCore.components.HSFlatpickr = {
		defaults: {
			mode: 'single',
			dateFormat: 'd M Y',
			maxDate: false,
			locale: {
				firstDayOfWeek: 1,
				weekdays: {
					shorthand: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
				},
				rangeSeparator: ' - '
			}
		},

		init: function (el, options) {
			if (!el.length) return;

			var context = this,
				defaults = Object.assign({}, context.defaults),
				dataSettings = el.attr('data-hs-flatpickr-options') ? JSON.parse(el.attr('data-hs-flatpickr-options')) : {},
				settings = {};
			settings = $.extend(true, defaults, settings, dataSettings, {
				appendTo: dataSettings ? $(dataSettings.appendTo)[0] : context
			}, options);

			/* Start : Init */
            /*let input = $(el).find('input[data-type="date"]').length > 0 ? $(el).find('input[data-type="date"]') : $(el);
            if(input.data('type') === 'date') {
                settings.onClose = function(selectedDates, dateStr, instance) {
                    try {
                        let component = Livewire.find($(input).closest('.lw-form').attr('wire:id'));
                        component.set(input.attr('name'), input.val());
                    } catch(error) {console.log(error);}
                }
            }*/
			var newFlatpickr = window.flatpickr(el, settings);

			/* End : Init */

			/* Start : custom functionality implementation */

			el.css({
				width: el.val().length * 7.5
			});

			/* End : custom functionality implementation */

			return newFlatpickr;
		}

	};

})(jQuery);
