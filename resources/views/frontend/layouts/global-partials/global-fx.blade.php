<script id="fx-data-json" type="application/json">
@php
echo json_encode([
	'currency' => \FX::getCurrency(),
	'number_of_decimals' => get_tenant_setting('no_of_decimals'),
	'decimal_separator' => get_tenant_setting('decimal_separator'),
	'symbol_format' => get_tenant_setting('decimal_separator'),
	'default_currency' => \FX::getDefaultCurrency(),
]);
@endphp
</script>