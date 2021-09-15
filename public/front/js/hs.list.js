/**
 * List JS wrapper.
 *
 * @author Htmlstream
 * @version 1.0
 *
 */
;(function ($) {
  'use strict';

  $.HSCore.components.HSList = {
    defaults: {
      searchMenu: false,
      searchMenuDelay: 300,
      searchMenuOutsideClose: true,
      searchMenuInsideClose: true,
      clearSearchInput: true,
      keyboard: false,
      empty: false
    },

    init: function (el, options) {
      if (!$(el).length) return;

      var context = this,
        $el = $(el),
        defaults = Object.assign({}, context.defaults),
        dataSettings = $el.attr('data-hs-list-options') ? JSON.parse($el.attr('data-hs-list-options')) : {},
        settings = {};
      settings = $.extend(true, defaults, settings, dataSettings, options);

      /* Start : Init */

      var newList = new List($el.attr('id'), settings, settings.values);

      /* End : Init */

      /* Start : custom functionality after init */

      /* Hide Menu */
      if (settings.searchMenu) {
        $(newList.list).fadeOut(0);
      }

      /* End : custom functionality after init */

      /* Start : custom functionality implementation */

      newList.on('searchComplete', function () {
        if (settings.searchMenu) {
          context.searchMenu($el, settings, newList);
          context.searchMenuHide($el, settings, newList);
        }

        if (!settings.searchMenu && settings.empty){
          context.emptyBlock($el, settings, newList);
        }
      });

      if (settings.searchMenu && settings.keyboard) {
        context.initializeHover($el, settings, newList);
      }

      /* End : custom functionality implementation */

      return newList;
    },

    // ----- Start : Custom functionality -----

    initializeHover: function (el, params, list) {
      var settings = params,
        newList = list,
        newListItem = $(newList.list).find('.list-group-item'),
        searchFiled = el.find('.' + newList.searchClass),
        selected;

      /* Start : Keboard Support */
      $(searchFiled).keydown(function (e) {
        if (e.which === 40) {
          e.preventDefault();

          if ($(newList.list).children('.active').length == 0) {
            selected = $(newList.list).children().first().addClass('active')
          } else {
            if ($(newList.list).children('.active').next().length) {
              var newActive = $(newList.list).children('.active').next().addClass('active');
              $(selected).removeClass('active')
              selected = newActive;

              if ($(newList.list).height() < $(newList.list).children('.active').position().top) {
                $(newList.list).scrollTop($(newList.list).children('.active').position().top + $(newList.list).scrollTop());
              }
            }
          }
        } else if (e.which === 38) {
          e.preventDefault();

          if ($(newList.list).children('.active').length == 0) {
            selected = $(newList.list).children().first().parent().addClass('active')
          } else {
            if ($(newList.list).children('.active').prev().length) {
              var newActive = $(newList.list).children('.active').prev().addClass('active');
              $(selected).removeClass('active')
              selected = newActive;

              if (0 > $(newList.list).children('.active').position().top) {
                $(newList.list).scrollTop($(newList.list).children('.active').position().top + $(newList.list).scrollTop());
              }
            }
          }
        } else if (e.which == 13 && searchFiled.val().length > 0) {
          e.preventDefault();
          window.location.replace($(selected).find('a').first().attr('href'));
        }
      });
      /* End : Keboard Support */
    },

    searchMenu: function (el, params, list) {
      var settings = params,
        newList = list;

      if (el.find('.' + newList.searchClass).val().length === 0 || newList.visibleItems.length === 0 && !settings.empty) {
        $(settings.empty).fadeOut(0);
        $(newList.list).fadeOut(settings.searchMenuDelay);
      } else {
        $(newList.list).fadeIn(settings.searchMenuDelay)

        if (!newList.visibleItems.length) {
          var empty = $(settings.empty).clone();
          $(newList.list).html(empty)
          $(empty).fadeIn(0);
        }
      }
    },

    searchMenuHide: function (el, params, list) {
      var settings = params,
        newList = list,
        searchFiled = el.find('.' + newList.searchClass);

      if (settings.searchMenuOutsideClose) {
        $(window).click(function () {
          $(newList.list).fadeOut(settings.searchMenuDelay);

          if (settings.clearSearchInput) {
            searchFiled.val('')
          }
        });
      }

      if (!settings.searchMenuInsideClose) {
        $(newList.list).click(function (event) {
          event.stopPropagation();

          if (settings.clearSearchInput) {
            searchFiled.val('')
          }
        });
      }
    },

    emptyBlock: function (el, params, list) {
      var settings = params,
        newList = list;

      if (el.find('.' + newList.searchClass).val().length === 0 || newList.visibleItems.length === 0 && !settings.empty) {
        $(settings.empty).fadeOut(0);
      } else {
        $(newList.list).fadeIn(settings.searchMenuDelay)

        if (!newList.visibleItems.length) {
          var empty = $(settings.empty).clone();
          $(newList.list).html(empty)
          $(empty).fadeIn(0);
        }
      }
    }

    // ----- End : Custom functionality -----
  }
})(jQuery);
