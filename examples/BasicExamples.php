<?php

/**
 * Basic PDF Generation Examples
 *
 * This file contains simple examples to get started with LaraPDFX
 */

use Deecodek\LaraPDFX\Facades\PDF;

// Example 1: Simple HTML to PDF
function example1_simple()
{
    $html = '<h1>Hello World!</h1><p>This is a simple PDF.</p>';

    return PDF::html($html)->download('simple.pdf');
}

// Example 2: Generate from Blade View
function example2_blade_view()
{
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'date' => now()->format('Y-m-d'),
    ];

    return PDF::view('welcome', $data)->download('welcome.pdf');
}

// Example 3: Custom Page Settings
function example3_page_settings()
{
    return PDF::html('<h1>Custom Settings</h1>')
        ->format('A4')
        ->landscape()
        ->margins(20, 15, 20, 15)
        ->download('custom.pdf');
}

// Example 4: Save to Storage
function example4_save_to_storage()
{
    PDF::html('<h1>Saved PDF</h1>')
        ->save(storage_path('app/pdfs/saved.pdf'));

    return response()->json(['message' => 'PDF saved successfully']);
}

// Example 5: Stream in Browser
function example5_stream()
{
    return PDF::html('<h1>Stream PDF</h1>')
        ->stream('document.pdf');
}

// Example 6: Base64 Encoding
function example6_base64()
{
    $base64 = PDF::html('<h1>Base64 PDF</h1>')->base64();

    return response()->json([
        'pdf' => $base64,
    ]);
}

// Example 7: With Header and Footer
function example7_header_footer()
{
    return PDF::html('<h1>Document with Header/Footer</h1>')
        ->header('<div style="text-align:center;">Company Name</div>')
        ->footerWithPageNumbers()
        ->download('document.pdf');
}

// Example 8: With Watermark
function example8_watermark()
{
    return PDF::html('<h1>Confidential Document</h1>')
        ->watermark('CONFIDENTIAL', [
            'opacity' => 0.3,
            'fontSize' => '60px',
            'color' => '#ff0000',
        ])
        ->download('confidential.pdf');
}

// Example 9: With Metadata
function example9_metadata()
{
    return PDF::html('<h1>Report 2025</h1>')
        ->title('Annual Report 2025')
        ->author('John Doe')
        ->subject('Financial Report')
        ->keywords(['finance', 'annual', 'report'])
        ->download('report.pdf');
}

// Example 10: Multiple Format Shortcuts
function example10_shortcuts()
{
    // A4 Portrait
    PDF::html('<h1>A4</h1>')->a4()->download('a4.pdf');

    // Letter Landscape
    PDF::html('<h1>Letter</h1>')->letter()->landscape()->download('letter.pdf');

    // Legal
    PDF::html('<h1>Legal</h1>')->legal()->download('legal.pdf');
}
