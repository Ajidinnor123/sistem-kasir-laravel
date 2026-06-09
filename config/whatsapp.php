return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Business API Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk integrasi WhatsApp Business API dari Meta
    |
    */

    'account_id' => env('WHATSAPP_BUSINESS_ACCOUNT_ID'),
    'phone_number_id' => env('WHATSAPP_BUSINESS_PHONE_NUMBER_ID'),
    'access_token' => env('WHATSAPP_BUSINESS_ACCESS_TOKEN'),
    'api_url' => env('WHATSAPP_BUSINESS_API_URL', 'https://graph.instagram.com/v18.0'),
    'webhook_verify_token' => env('WHATSAPP_WEBHOOK_VERIFY_TOKEN', 'your_verify_token'),

    /*
    |--------------------------------------------------------------------------
    | Message Templates
    |--------------------------------------------------------------------------
    */

    'templates' => [
        'receipt' => 'receipt_message',  // Template untuk struk
        'payment_confirmation' => 'payment_confirmation',
        'order_status' => 'order_status',
    ],

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    */

    'retry' => [
        'max_attempts' => 3,
        'delay_seconds' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Message Format
    |--------------------------------------------------------------------------
    */

    'format' => [
        'include_transaction_number' => true,
        'include_product_list' => true,
        'include_payment_method' => true,
        'include_whatsapp_link' => false,
    ],
];
