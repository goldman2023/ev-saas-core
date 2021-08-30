/*
* HSJVectorMap Plugin
* @version: 2.0.0 (Thu, 02 Apr 2020)
* @requires: jQuery v3.4.1 or later, jQuery Migrate v3.1.0 or later, jVectorMap v2.0.4
* @author: HtmlStream
* @event-namespace: .HSJVectorMap
* @license: Htmlstream Libraries (https://htmlstream.com/)
* Copyright 2020 Htmlstream
*/

;(function ($) {
	'use strict';

	$.HSCore.components.HSJVectorMap = {
		defaults: {
			map: 'world_mill_en',
			zoomOnScroll: false
		},

		init: function (el, options) {
			if (!el.length) return;

			var context = this,
				defaults = Object.assign({}, context.defaults),
				dataSettings = el.attr('data-hs-jvector-map-options') ? JSON.parse(el.attr('data-hs-jvector-map-options')) : {},
				settings = {};
			settings = $.extend(true, defaults, dataSettings, settings, options);

      settings.container = el;

			/* Start : Init */

			var newJVectorMap = new jvm.Map(settings)

			/* End : Init */

      if (settings.tipCentered) {
        context.tipCentered(newJVectorMap.tip)
      } else {
        context.fixTipPosition(newJVectorMap.tip)
      }

			return newJVectorMap;
		},

    tipCentered: function (tooltip) {
      $('.jvectormap-container').mousemove(function(e) {
          var top = tooltip.offset().top - 7,
          left = e.clientX - (tooltip.width() / 2);

        tooltip.addClass('jvectormap-tip-cntered');

        tooltip.css({
          top: top,
          left: left
        });
      });
    },

    fixTipPosition: function(tooltip) {
      $('.jvectormap-container').mousemove(function(e) {
          var left = tooltip.offset().left;

        tooltip.css({
          left: left
        });
      });
    }
	};

})(jQuery);
