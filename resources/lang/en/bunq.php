<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Bunq
    |--------------------------------------------------------------------------
    |
    */

    // General
    'bunq'                                     => 'bunq',
    'bunq_connected'                           => 'bunq connected!',
    'authorize_bunq'                           => 'Authorize bunq',
    'disconnect_bunq'                          => 'Disconnect bunq',

    // Errors
    'no_code_set'                              => 'No code set',

    // Monetary accounts
    'monetary_accounts'                        => 'Monetary accounts',
    'no_monetary_accounts_found'               => 'No monetary accounts found',
    'monetary_account'                         => 'Monetary account',

    // Payments
    'payments'                                 => 'Payments',
    'filter_payments'                          => 'Filter payments',
    'filter'                                   => 'Filter',
    'show_all_payments'                        => 'Show all payments',
    'no_payments_found'                        => 'No payments found',
    'sync'                                     => 'Sync payments',
    'payments_currently_syncing'               => 'Payments currently syncing',

    // Flash messages
    'flash_oauth_error'                        => 'Could not connect to bunq, error that occurred was: :error',
    'flash_state_does_not_match'               => 'State does not match, could not connect!',
    'flash_successfully_connected'             => 'Successfully connected to bunq!',
    'flash_successfully_disconnected'          => 'Successfully disconnected from bunq!',
    'flash_could_not_connect'                  => 'Could not connect to bunq!',
    'flash_api_context_exception_disconnected' => 'Could not restore api context, please login to bunq again.',
];
