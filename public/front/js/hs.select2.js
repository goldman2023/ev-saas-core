/*
* HSSelect2 Plugin
* @version: 2.0.0 (Thu, 02 Apr 2020)
* @requires: jQuery v3.4.1 or later, jQuery Migrate v3.1.0 or later, Select2 v4.0.13
* @author: HtmlStream
* @event-namespace: .HSSelect2
* @license: Htmlstream Libraries (https://htmlstream.com/)
* Copyright 2020 Htmlstream
*/

;(function ($) {
	'use strict';
	
	$.HSCore.components.HSSelect2 = {
		defaults: {
			data: [],
			width: '100%',
			customClass: 'custom-select',
			searchInputPlaceholder: false,
      singleMultiple: false,
			singleMultipleActiveClass: 'active',
			singleMultiplePostfix: ' item(s) selected',
			singleMultiplePrefix: null
		},
		
		init: function (el, options) {
			if (!el.length) return;
			
			var context = this,
				defaults = Object.assign({}, context.defaults),
				dataSettings = el.attr('data-hs-select2-options') ? JSON.parse(el.attr('data-hs-select2-options')) : {},
				settings = {
					templateResult: context.formatData,
					templateSelection: context.formatData,
					escapeMarkup: function (markup) {
						return markup;
					}
				};
			settings = $.extend(true, defaults, settings, dataSettings, options);
			
			/* Start : Init */
			
			var newSelect2 = el.select2(settings);
			
			/* End : Init */
			
			el.siblings('.select2').find('.select2-selection').removeClass('select2-selection--single').addClass(settings.customClass);

			if (settings.singleMultiple) {
			  context.singleMultiple(el, settings)

        newSelect2.on("select2:select", function (e) {
          context.singleMultiple(el, settings)
        });

        newSelect2.on("select2:unselect", function (e) {
          context.singleMultiple(el, settings)
        });
      }

			context.safariAutoWidth(newSelect2, settings)

			context.leftOffset(newSelect2, settings)

      context.dropdownWidth(newSelect2, settings)

			if (settings.searchInputPlaceholder) {
				context.searchPlaceholder(newSelect2, settings)
			}
			
			return newSelect2;
		},

    dropdownWidth: function(newSelect2, params) {
      var settings = params;

      newSelect2.on('select2:open', function() {
        let menu = $('.select2-container--open').last()

        menu.css({
          width: settings.dropdownWidth
        });
      })
    },

		safariAutoWidth: function(newSelect2, params) {
      var settings = params;

			newSelect2.on('select2:open', function () {
				$('.select2-container--open').css({
					top: 0
				});
			})
    },

    singleMultiple: function(newSelect2, params) {
      var settings = params;

      let selection = $(newSelect2).next('.select2').find('.select2-selection'),
				placeholder = newSelect2.find(':selected').length > 0 ? settings.singleMultiplePrefix + newSelect2.find(':selected').length + settings.singleMultiplePostfix : settings.placeholder;

      selection.removeClass('select2-selection--multiple')

			if (newSelect2.find(':selected').length > 0) {
				selection.addClass(settings.singleMultipleActiveClass)
			} else {
				selection.removeClass(settings.singleMultipleActiveClass)
			}

      selection.find('.select2-selection__rendered').replaceWith(
          '<span class="select2-selection__rendered" role="textbox" aria-readonly="true">' +
            '<span class="select2-selection__placeholder">' + placeholder + '</span></span>' +
            '<span class="select2-selection__arrow" role="presentation">' +
            '<b role="presentation"></b>' +
          '</span>')
    },
		
		formatData: function (params) {
			var settings = params,
				result;
			
			if (!settings.element) {
				return settings.text;
			}
			
			result = settings.element.dataset.optionTemplate ? settings.element.dataset.optionTemplate : '<span>' + settings.text + '</span>';
			
			return $.parseHTML(result);
		},

		leftOffset: function(newSelect2, params) {
			var settings = params;

			newSelect2.on('select2:open', function() {
				if (settings.leftOffset) {
					let menu = $('.select2-container--open').last()

					menu.css({
						opacity: 0
					})

					setTimeout(function() {
						menu.css({
							left: parseInt(menu.position().left) + settings.leftOffset,
							opacity: 1
						})
					}, 1)
				}
			})
		},

		searchPlaceholder: function(newSelect2, params) {
			var settings = params;

			newSelect2.on('select2:open', function() {
				var input = $('.select2-container--open .select2-search__field').last();

				input.attr('placeholder', settings.searchInputPlaceholder)
			})
		}
	};
	
})(jQuery);
