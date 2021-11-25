window.EV.form.HSQuantityCounter = function() {
    return {
        elem: null,
        settings: null,
        defaults: {
            classMap: {
                plus: '.js-plus',
                minus: '.js-minus',
                result: '.js-result'
            },
        },

        constructor(elem, settings) {
            this.elem = elem;
            this.settings = settings;
        },

        init(elem, settings = {}) {
            this.constructor(elem, settings);

            const context = this,
                $el = context.elem,
                dataSettings = $el.attr('data-hs-quantity-counter-options') ? JSON.parse($el.attr('data-hs-quantity-counter-options')) : {};
            let options = $.extend(true, context.defaults, dataSettings, context.settings);

            // Plus Click Events
            $el.find(options.classMap.plus).off('click').on('click', function () {
                context._plusClickEvents($el, options);
            });

            // Minus Click Events
            $el.find(options.classMap.minus).off('click').on('click', function () {
                context._minusClickEvents($el, options);
            });
        },

        _plusClickEvents(el, options) {
            let $result = parseInt(el.find(options.classMap.result).val()) + 1;

            el.find(options.classMap.result).val($result).get(0).dispatchEvent(new Event('input'));

        },

        _minusClickEvents(el, options) {
            let $result = parseInt(el.find(options.classMap.result).val());

            if ($result >= 1) {
                $result = $result - 1;
                el.find(options.classMap.result).val($result).get(0).dispatchEvent(new Event('input'));
            } else {
                return false;
            }
        }
    }
}
