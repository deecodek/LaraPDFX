<?php

/**
 * Invoice Generation Example
 * 
 * Complete example showing how to generate a professional invoice PDF
 */

use Deecodek\LaraPDFX\Facades\PDF;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function download($id)
    {
        // Get invoice data
        $invoice = Invoice::with(['customer', 'items'])->findOrFail($id);
        
        // Generate and download PDF
        return PDF::view('invoices.template', [
                'invoice' => $invoice
            ])
            ->format('A4')
            ->margins(15)
            ->footerWithPageNumbers()
            ->title('Invoice #' . $invoice->number)
            ->author('Your Company Name')
            ->subject('Invoice')
            ->download('invoice-' . $invoice->number . '.pdf');
    }
    
    public function email($id)
    {
        $invoice = Invoice::with(['customer', 'items'])->findOrFail($id);
        
        // Generate PDF and save temporarily
        $path = storage_path('app/temp/invoice-' . $invoice->number . '.pdf');
        
        PDF::view('invoices.template', ['invoice' => $invoice])
            ->format('A4')
            ->save($path);
        
        // Send email with attachment
        Mail::to($invoice->customer->email)
            ->send(new InvoiceMail($invoice, $path));
        
        // Clean up
        unlink($path);
        
        return back()->with('success', 'Invoice sent successfully!');
    }
    
    public function preview($id)
    {
        $invoice = Invoice::with(['customer', 'items'])->findOrFail($id);
        
        // Stream in browser for preview
        return PDF::view('invoices.template', ['invoice' => $invoice])
            ->format('A4')
            ->stream('invoice-' . $invoice->number . '.pdf');
    }
}

// Blade Template Example: resources/views/invoices/template.blade.php
/*
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3490dc;
        }
        
        .company-info h1 {
            margin: 0;
            color: #3490dc;
            font-size: 28px;
        }
        
        .invoice-info {
            text-align: right;
        }
        
        .invoice-number {
            font-size: 24px;
            font-weight: bold;
            color: #3490dc;
        }
        
        .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .party-box {
            background: #f7fafc;
            padding: 15px;
            border-radius: 5px;
        }
        
        .party-box h3 {
            margin-top: 0;
            color: #2d3748;
        }
        
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .invoice-table th {
            background: #3490dc;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        .invoice-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .invoice-table tr:nth-child(even) {
            background: #f7fafc;
        }
        
        .text-right {
            text-align: right;
        }
        
        .totals {
            margin-left: auto;
            width: 300px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        
        .total-row.grand-total {
            border-top: 2px solid #3490dc;
            font-size: 18px;
            font-weight: bold;
            color: #3490dc;
            margin-top: 10px;
            padding-top: 10px;
        }
        
        .notes {
            margin-top: 30px;
            padding: 15px;
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 12px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <h1>Your Company</h1>
            <p>
                123 Business St<br>
                City, State 12345<br>
                Phone: (555) 123-4567<br>
                Email: info@company.com
            </p>
        </div>
        <div class="invoice-info">
            <div class="invoice-number">INVOICE #{{ $invoice->number }}</div>
            <p>
                <strong>Date:</strong> {{ $invoice->date->format('M d, Y') }}<br>
                <strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}
            </p>
        </div>
    </div>
    
    <div class="parties">
        <div class="party-box">
            <h3>Bill To:</h3>
            <strong>{{ $invoice->customer->name }}</strong><br>
            {{ $invoice->customer->address }}<br>
            {{ $invoice->customer->city }}, {{ $invoice->customer->state }} {{ $invoice->customer->zip }}<br>
            Email: {{ $invoice->customer->email }}
        </div>
        <div class="party-box">
            <h3>Ship To:</h3>
            <strong>{{ $invoice->shipping_name ?? $invoice->customer->name }}</strong><br>
            {{ $invoice->shipping_address ?? $invoice->customer->address }}<br>
            {{ $invoice->shipping_city ?? $invoice->customer->city }}, 
            {{ $invoice->shipping_state ?? $invoice->customer->state }} 
            {{ $invoice->shipping_zip ?? $invoice->customer->zip }}
        </div>
    </div>
    
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>
                    <strong>{{ $item->name }}</strong>
                    @if($item->description)
                        <br><small style="color: #718096;">{{ $item->description }}</small>
                    @endif
                </td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">${{ number_format($item->price, 2) }}</td>
                <td class="text-right">${{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>${{ number_format($invoice->subtotal, 2) }}</span>
        </div>
        @if($invoice->discount > 0)
        <div class="total-row">
            <span>Discount:</span>
            <span>-${{ number_format($invoice->discount, 2) }}</span>
        </div>
        @endif
        <div class="total-row">
            <span>Tax ({{ $invoice->tax_rate }}%):</span>
            <span>${{ number_format($invoice->tax, 2) }}</span>
        </div>
        <div class="total-row grand-total">
            <span>Total:</span>
            <span>${{ number_format($invoice->total, 2) }}</span>
        </div>
    </div>
    
    @if($invoice->notes)
    <div class="notes">
        <strong>Notes:</strong><br>
        {{ $invoice->notes }}
    </div>
    @endif
    
    <div class="footer">
        <p>
            Thank you for your business!<br>
            Payment Terms: {{ $invoice->payment_terms }}<br>
            For questions, contact us at info@company.com
        </p>
    </div>
</body>
</html>
*/
