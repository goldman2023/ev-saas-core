/*
* HSFullcalendar Plugin
* @version: 2.0.0 (Thu, 02 Apr 2020)
* @requires: jQuery v3.4.1 or later, jQuery Migrate v3.1.0 or later, FullCalendar Core Package v4.4.0, FullCalendar Day Grid Plugin v4.4.0
* @author: HtmlStream
* @event-namespace: .HSFullcalendar
* @license: Htmlstream Libraries (https://htmlstream.com/)
* Copyright 2020 Htmlstream
*/

;(function ($) {
	'use strict';
	
	$.HSCore.components.HSFullcalendar = {
		defaults: {
			contentHeight:"auto",
			dayMaxEventRows: 2
		},
		
		init: function (el, options) {
			if (!el.length) return;
			
			var context = this,
				defaults = Object.assign({}, context.defaults),
				dataSettings = el.attr('data-hs-fullcalendar-options') ? JSON.parse(el.attr('data-hs-fullcalendar-options')) : {},
				settings = {};
			settings = $.extend(true, defaults, settings, dataSettings, options);
			
			/* Start : Init */
			
			var newFullcalendar = new FullCalendar.Calendar(el[0], settings);
			
			newFullcalendar.render();
			
			/* End : Init */

			return newFullcalendar;
		}
	};
	
})(jQuery);
