<?php

return [
    /**
     *================================================================================
     * Store URL eg: http://example.com
     *================================================================================.
     */
    /* TODO: Make this come from app settings/integrations */
    'store_url'         => env('WOOCOMMERCE_STORE_URL', '#'),

    /**
     *================================================================================
     * Consumer Key
     *================================================================================.
     */
    /* MotherK */
    // 'consumer_key'      => env('WOOCOMMERCE_CONSUMER_KEY', ''),

    /* Debesunamai */
    'consumer_key'      => env('WOOCOMMERCE_CONSUMER_KEY', ''),

    /**
     * Consumer Secret.
     */
    /* MotherK */
    // 'consumer_secret'   => env('WOOCOMMERCE_CONSUMER_SECRET', ''),

    /* Debesunamai */
    'consumer_secret'   => env('WOOCOMMERCE_CONSUMER_SECRET', ''),

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
