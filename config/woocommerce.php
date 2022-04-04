<?php

return [
    /**
     *================================================================================
     * Store URL eg: http://example.com
     *================================================================================.
     */
    'store_url'         => env('WOOCOMMERCE_STORE_URL', 'https://debesunamai.lt'),

    /**
     *================================================================================
     * Consumer Key
     *================================================================================.
     */
    /* MotherK */
    // 'consumer_key'      => env('WOOCOMMERCE_CONSUMER_KEY', 'ck_1f2fba2fffcd4019411441dcfb87c4ff449b14a7'),

    /* Debesunamai */
    'consumer_key'      => env('WOOCOMMERCE_CONSUMER_KEY', 'ck_04e306e3ea1a38af323fc51ce7f6eea7ca27c338'),

    /**
     * Consumer Secret.
     */
    /* MotherK */
    // 'consumer_secret'   => env('WOOCOMMERCE_CONSUMER_SECRET', 'cs_e2ef6104cdd1d5ddf5fca8a16826fff2db115b27'),

    /* Debesunamai */
    'consumer_secret'   => env('WOOCOMMERCE_CONSUMER_SECRET', 'cs_720b148c3e8545d7ea87015c04ba256561c3bf82'),

    /**
     *================================================================================
     * SSL support
     *================================================================================.
     */
    'verify_ssl'        => env('WOOCOMMERCE_VERIFY_SSL', true),

    /**
     *================================================================================
     * Woocommerce API version
     *================================================================================.
     */
    'api_version'       => env('WOOCOMMERCE_API_VERSION', 'v2'),

    /**
     *================================================================================
     * Enable WP API Integration
     *================================================================================.
     */
    'wp_api'            => env('WP_API_INTEGRATION', true),

    /**
     *================================================================================
     * Force Basic Authentication as query string
     *================================================================================.
     */
    'query_string_auth' => env('WOOCOMMERCE_WP_QUERY_STRING_AUTH', true),

    /**
     *================================================================================
     * Default WP timeout
     *================================================================================.
     */
    'timeout'           => env('WOOCOMMERCE_WP_TIMEOUT', 90),

    /**
     *================================================================================
     * Total results header
     * Default value X-WP-Total
     *================================================================================.
     */
    'header_total'           => env('WOOCOMMERCE_WP_HEADER_TOTAL', '-1'),

    /**
     *================================================================================
     * Total pages header
     * Default value X-WP-TotalPages
     *================================================================================.
     */
    'header_total_pages'           => env('WOOCOMMERCE_WP_HEADER_TOTAL_PAGES', '-1'),
];
