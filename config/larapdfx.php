<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Paper Format
    |--------------------------------------------------------------------------
    |
    | The default paper format for PDF generation.
    | Options: A4, A3, A5, Letter, Legal, Tabloid, Ledger
    |
    */

    'paper' => [
        'format' => env('LARAPDFX_PAPER_FORMAT', 'A4'),

        'margins' => [
            'top' => env('LARAPDFX_MARGIN_TOP', 10),
            'right' => env('LARAPDFX_MARGIN_RIGHT', 10),
            'bottom' => env('LARAPDFX_MARGIN_BOTTOM', 10),
            'left' => env('LARAPDFX_MARGIN_LEFT', 10),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Chrome/Chromium Path
    |--------------------------------------------------------------------------
    |
    | Path to Chrome or Chromium executable. Leave null for auto-detection.
    |
    | Linux: /usr/bin/google-chrome or /usr/bin/chromium-browser
    | macOS: /Applications/Google Chrome.app/Contents/MacOS/Google Chrome
    | Windows: C:\Program Files\Google\Chrome\Application\chrome.exe
    |
    */

    'chrome_path' => env('LARAPDFX_CHROME_PATH', null),

    /*
    |--------------------------------------------------------------------------
    | Node.js Binary Path
    |--------------------------------------------------------------------------
    |
    | Path to Node.js binary. Leave null for auto-detection.
    |
    */

    'node_binary' => env('LARAPDFX_NODE_BINARY', null),

    /*
    |--------------------------------------------------------------------------
    | NPM Binary Path
    |--------------------------------------------------------------------------
    |
    | Path to NPM binary. Leave null for auto-detection.
    |
    */

    'npm_binary' => env('LARAPDFX_NPM_BINARY', null),

    /*
    |--------------------------------------------------------------------------
    | Timeout (seconds)
    |--------------------------------------------------------------------------
    |
    | Maximum time (in seconds) to wait for PDF generation.
    |
    */

    'timeout' => env('LARAPDFX_TIMEOUT', 60),

    /*
    |--------------------------------------------------------------------------
    | Print Background
    |--------------------------------------------------------------------------
    |
    | Whether to print background graphics.
    |
    */

    'print_background' => env('LARAPDFX_PRINT_BACKGROUND', true),

    /*
    |--------------------------------------------------------------------------
    | Default Output Directory
    |--------------------------------------------------------------------------
    |
    | Default directory for saving PDFs (relative to storage path).
    |
    */

    'output_directory' => env('LARAPDFX_OUTPUT_DIR', 'pdfs'),

    /*
    |--------------------------------------------------------------------------
    | Queue Settings
    |--------------------------------------------------------------------------
    |
    | Configure queue settings for async PDF generation.
    |
    */

    'queue' => [
        'enabled' => env('LARAPDFX_QUEUE_ENABLED', false),
        'connection' => env('LARAPDFX_QUEUE_CONNECTION', null),
        'queue' => env('LARAPDFX_QUEUE_NAME', 'default'),
    ],

];
