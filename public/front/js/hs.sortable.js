/*
* HSSortable Plugin
* @version: 2.0.0 (Thu, 02 Apr 2020)
* @requires: jQuery v3.4.1 or later, jQuery Migrate v3.1.0 or later, Sortable v1.10.1
* @author: HtmlStream
* @event-namespace: .HSSortable
* @license: Htmlstream Libraries (https://htmlstream.com/)
* Copyright 2020 Htmlstream
*/

;(function ($) {
	'use strict';
	
	$.HSCore.components.HSSortable = {
		defaults: {},
		
		init: function (el, options) {
			if (!el.length) return;
			
			var context = this,
				defaults = Object.assign({}, context.defaults),
				dataSettings = el.attr('data-hs-sortable-options') ? JSON.parse(el.attr('data-hs-sortable-options')) : {},
				settings = {};
			settings = $.extend(true, defaults, settings, dataSettings, options);
			
			/* Start : Init */
			
			var newSortable = new Sortable(el[0], settings);
			
			/* End : Init */

			return newSortable;
		}
	};
	
})(jQuery);
