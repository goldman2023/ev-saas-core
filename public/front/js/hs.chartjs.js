/*
* Chart.js wrapper
* @version: 2.0.0 (Mon, 25 Nov 2019)
* @requires: jQuery v3.0 or later, Chart.js v2.8.0
* @author: HtmlStream
* @event-namespace: .HSCore.components.HSValidation
* @license: Htmlstream Libraries (https://htmlstream.com/licenses)
* Copyright 2020 Htmlstream
*/
;(function ($) {
  'use strict';

  $.HSCore.components.HSChartJS = {
    defaults: {
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        tooltips: {
          enabled: false,
          mode: 'nearest',
          prefix: '',
          postfix: '',
          hasIndicator: false,
          indicatorWidth: '8px',
          indicatorHeight: '8px',
          transition: '0.2s',
          lineWithLineColor: null,
          yearStamp: true
        },
        gradientPosition: {
          x0: 0,
          y0: 0,
          x1: 0,
          y1: 0,
        }
      }
    },

    init: function (el, options) {
      if (!el.length) return;

      var context = this,
        defaults = Object.assign({}, context.defaults),
        dataSettings = el.attr('data-hs-chartjs-options') ? JSON.parse(el.attr('data-hs-chartjs-options')) : {},
        settings = {};
      settings = $.extend(true, dataSettings.type, defaults, (dataSettings.type === 'line') ? ({
        options: {
          scales: {
            yAxes: [{
              ticks: {
                callback: function (value, index, values) {
									var metric = settings.options.scales.yAxes[0].ticks.metric,
										prefix = settings.options.scales.yAxes[0].ticks.prefix,
										postfix = settings.options.scales.yAxes[0].ticks.postfix;

                  if (metric && value > 100) {
                    if (value < 1000000) {
                      value = value / 1000 + 'k';
                    } else {
                      value = value / 1000000 + 'kk';
                    }
                  }

                  if (prefix && postfix) {
                    return prefix + value + postfix;
                  } else if (prefix) {
                    return prefix + value;
                  } else if (postfix) {
                    return value + postfix;
                  } else {
                    return value;
                  }
                }
              }
            }]
          },
          elements: {
            line: {
              borderWidth: 3
            },
            point: {
              pointStyle: 'circle',
              radius: 5,
              hoverRadius: 7,
              borderWidth: 3,
              hoverBorderWidth: 3,
              backgroundColor: '#ffffff',
              hoverBackgroundColor: '#ffffff'
            }
          }
        }
      }) : ((dataSettings.type === 'bar') ? ({
        options: {
          scales: {
            yAxes: [{
              ticks: {
                callback: function (value, index, values) {
									var metric = settings.options.scales.yAxes[0].ticks.metric,
										prefix = settings.options.scales.yAxes[0].ticks.prefix,
										postfix = settings.options.scales.yAxes[0].ticks.postfix;

									if (metric && value > 100) {
										if (value < 1000000) {
											value = value / 1000 + 'k';
										} else {
											value = value / 1000000 + 'kk';
										}
									}

                  if (prefix && postfix) {
                    return prefix + value + postfix;
                  } else if (prefix) {
										return prefix + value;
									} else if (postfix) {
										return value + postfix;
									} else {
										return value;
									}
                }
              }
            }]
          }
        }
      }) : ({})));
      settings = $.extend(true, settings, {
        options: {
          tooltips: {
            custom: function (tooltipModel) {
              // Tooltip Element
              var tooltipEl = document.getElementById('chartjsTooltip');

              // Create element on first render
              if (!tooltipEl) {
                tooltipEl = document.createElement('div');
                tooltipEl.id = 'chartjsTooltip';
                tooltipEl.style.opacity = 0;
                tooltipEl.classList.add('hs-chartjs-tooltip-wrap');
                tooltipEl.innerHTML = '<div class="hs-chartjs-tooltip"></div>';
                if (settings.options.tooltips.lineMode) {
                  el.parent('.chartjs-custom').append(tooltipEl)
                } else {
                  document.body.appendChild(tooltipEl);
                }
              }

              // Hide if no tooltip
              if (tooltipModel.opacity === 0) {
                tooltipEl.style.opacity = 0;

                tooltipEl.parentNode.removeChild(tooltipEl)

                return;
              }

              // Set caret Position
              tooltipEl.classList.remove('above', 'below', 'no-transform');
              if (tooltipModel.yAlign) {
                tooltipEl.classList.add(tooltipModel.yAlign);
              } else {
                tooltipEl.classList.add('no-transform');
              }

              function getBody(bodyItem) {
                return bodyItem.lines;
              }

              // Set Text
              if (tooltipModel.body) {
                var titleLines = tooltipModel.title || [],
                  bodyLines = tooltipModel.body.map(getBody),
                  today = new Date();

                var innerHtml = '<header class="hs-chartjs-tooltip-header">';

                titleLines.forEach(function (title) {
                  innerHtml += settings.options.tooltips.yearStamp ? title +  ', ' + today.getFullYear() : title;
                });

                innerHtml += '</header><div class="hs-chartjs-tooltip-body">';

                bodyLines.forEach(function (body, i) {
                  innerHtml += '<div>'

                  var oldBody = body[0],
                    newBody = oldBody,
                    color = tooltipModel.labelColors[i].backgroundColor instanceof Object ? tooltipModel.labelColors[i].borderColor : tooltipModel.labelColors[i].backgroundColor;

                  innerHtml += (settings.options.tooltips.hasIndicator ? '<span class="d-inline-block rounded-circle mr-1" style="width: ' + settings.options.tooltips.indicatorWidth + '; height: ' + settings.options.tooltips.indicatorHeight + '; background-color: ' + color + '"></span>' : '') + settings.options.tooltips.prefix + (oldBody.length > 3 ? newBody : body) + settings.options.tooltips.postfix;

                  innerHtml += '</div>'
                });

                innerHtml += '</div>';

                var tooltipRoot = tooltipEl.querySelector('.hs-chartjs-tooltip');
                tooltipRoot.innerHTML = innerHtml;
              }

              // `this` will be the overall tooltip
              var position = this._chart.canvas.getBoundingClientRect();

              // Display, position, and set styles for font
              tooltipEl.style.opacity = 1;
              if (settings.options.tooltips.lineMode) {
                tooltipEl.style.left = tooltipModel.caretX + 'px';
              } else {
                tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX - (tooltipEl.offsetWidth / 2) - 3 + 'px';
              }
              tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY - tooltipEl.offsetHeight - 25 + 'px';
              tooltipEl.style.pointerEvents = 'none';
              tooltipEl.style.transition = settings.options.tooltips.transition;
            }
          }
        }
      }, dataSettings, settings, options);

      if (settings.type === 'line') {
        settings.data.datasets.forEach(function(data) {

          /* Linear Gradient */
          if (Array.isArray(data.backgroundColor)) {
            var ctx = el[0].getContext("2d"),
              gradientStroke = ctx.createLinearGradient(settings.options.gradientPosition.x0, settings.options.gradientPosition.y0, settings.options.gradientPosition.x1, settings.options.gradientPosition.y1);

            for (let i = 0; i < data.backgroundColor.length; i++) {
              gradientStroke.addColorStop(i, data.backgroundColor[i]);
            }

            data.backgroundColor = gradientStroke;
          }
          /* End Linear Gradient */
        });
      }

      /* Start : Init */

      var newChartJS = new Chart(el, settings);

      /* End : Init */

      // Extend Chart
      if (settings.type === 'line' && settings.options.tooltips.lineMode) {
        var originalLineDraw = newChartJS.draw;
        newChartJS.draw = function(ease) {
          originalLineDraw.call(this, ease);

          if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
            var activePoint = this.chart.tooltip._active[0],
              el = $(this.chart.canvas),
              tooltipWrap = $('.hs-chartjs-tooltip-wrap'),
              lineTooltip = $("#chartjsTooltipLine"),
              offsetTop = settings.options.tooltips.lineWithLineTopOffset >= 0 ? settings.options.tooltips.lineWithLineTopOffset : 7,
              offsetBottom = settings.options.tooltips.lineWithLineBottomOffset >= 0 ? settings.options.tooltips.lineWithLineBottomOffset : 43;

            if (!$("#chartjsTooltip #chartjsTooltipLine").length) {
              $("#chartjsTooltip").append('<div id="chartjsTooltipLine"></div>')
            }

            tooltipWrap.css({
              top: el.height() / 2 - tooltipWrap.height()
            })

            lineTooltip.css({
              top: -(tooltipWrap.offset().top - el.offset().top) + offsetTop,
            })

            if (tooltipWrap.offset().left + tooltipWrap.width() > (el.offset().left + el.width()) - 100) {
              $('.hs-chartjs-tooltip').removeClass('hs-chartjs-tooltip-right').addClass('hs-chartjs-tooltip-left');
            } else {
              $('.hs-chartjs-tooltip').addClass('hs-chartjs-tooltip-right').removeClass('hs-chartjs-tooltip-left');
            }

            if (lineTooltip.length) {
              lineTooltip.css({
                position: "absolute",
                width: "2px",
                height: el.height() - offsetBottom,
                backgroundColor: settings.options.tooltips.lineWithLineColor,
                left: 0,
                transform: "translateX(-50%)",
                zIndex: 0,
                transition: "100ms"
              })
            }
          }
        };

        el.on('mouseleave', function() {
          $('#lineTooltipChartJSStyles').attr('media', 'max-width: 1px')
        })

        el.on('mouseenter', function() {
          $('#lineTooltipChartJSStyles').removeAttr('media')
        })

        el.on('mousemove', function(evt) {
          if (evt.pageY - el.offset().top > $('.hs-chartjs-tooltip-wrap').height() / 2 && (evt.pageY - el.offset().top) + ($('.hs-chartjs-tooltip-wrap').outerHeight() / 2) < el.height()) {
            $('.hs-chartjs-tooltip').css({
              top: ((evt.pageY + $('.hs-chartjs-tooltip-wrap').height() / 2) - (el.offset().top + el.height() / 2))
            });
          }
        })
      }

      return newChartJS;
    }
  };

})(jQuery);
