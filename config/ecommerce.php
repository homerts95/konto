<?php

return [

    // Stripe Key
    'currency' => env('CURRENCY', 'EUR'),
    'enable_stripe' => (bool)env('STRIPE_SECRET_KEY', false),
    'enable_whatsapp' => (bool)env('WHATSAPP_NUMBER', false),
    'whatsapp_number' => env('WHATSAPP_NUMBER', ''),
];
