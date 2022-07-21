window.FX = {
    fx_data: null,
    getFXData: function() {
        try {
            if(window.FX.fx_data != null) {
                return window.FX.fx_data;
            }
            window.FX.fx_data = JSON.parse(document.getElementById('fx-data-json').textContent);
            return window.FX.fx_data;
        } catch(error) {
            console.log(error);
            return {};
        }
    },
    getCurrency: function() {
        return _.get(window.FX.getFXData(), 'currency', {});
    },
    getDefaultCurrency: function() {
        return _.get(window.FX.getFXData(), 'default_currency', {});
    },
    getNumberOfDecimals: function() {
        return Number(_.get(window.FX.getFXData(), 'number_of_decimals', 0));
    },
    getDecimalSeparator: function() {
        return Number(_.get(window.FX.getFXData(), 'decimal_separator', 1));
    },
    getSymbolFormat: function() {
        return Number(_.get(window.FX.getFXData(), 'symbol_format', 1));
    },
    convertPrice: function($price, $base_currency = null) {
        if ($base_currency === window.FX.getCurrency().code || $base_currency == null) {
            return Number($price);
        }

        // TODO: Create proper Currency Converter that will store FX rates in CENTRAL app and in non-tenant-related Cache
        $price = Number($price) / Number(window.FX.getDefaultCurrency().exchange_rate);

        return Number($price * Number(window.FX.getCurrency().exchange_rate));
    },
    formatPrice: function($price, $decimals = null, $base_currency = null, $convert = true) {
        let price = Number($price);

        if ($convert) {
            price = window.FX.convertPrice($price, $base_currency);
        }

        /* Get Default Decimals number */
        let displayedDecimals = window.FX.getNumberOfDecimals();

        /* Check if decimals are overided in a function call */
        if($decimals) {
            displayedDecimals = $decimals;
        } 

        let formatted_price = new Intl.NumberFormat(undefined, { 
            style: 'currency', 
            currency: window.FX.getCurrency().code,
            useGrouping: true,
            minimumFractionDigits: displayedDecimals,
        }).format(price);

        return formatted_price;
    }
};
