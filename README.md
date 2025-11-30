# LaraPDFX

<p align="center">
<img src="https://img.shields.io/packagist/v/deecodek/larapdfx.svg?style=flat-square" alt="Latest Version">
<img src="https://img.shields.io/packagist/dt/deecodek/larapdfx.svg?style=flat-square" alt="Total Downloads">
<img src="https://img.shields.io/packagist/l/deecodek/larapdfx.svg?style=flat-square" alt="License">
<img src="https://img.shields.io/packagist/php-v/deecodek/larapdfx.svg?style=flat-square" alt="PHP Version">
</p>

**Modern, production-ready PDF generation for Laravel with full CSS3 support, perfect rendering, and advanced features.**

LaraPDFX solves all the pain points of existing PDF libraries by using Chrome headless rendering engine, giving you pixel-perfect PDFs with modern CSS support including Flexbox, Grid, and all CSS3 features.

---

## 🎯 Why LaraPDFX?

### Problems with Existing Solutions (DomPDF, TCPDF, etc.):
❌ Only CSS 2.1 support - no modern CSS  
❌ Slow performance & memory issues  
❌ Poor font rendering & RTL language support  
❌ Image handling problems  
❌ No Flexbox or Grid support  
❌ Bootstrap/Tailwind CSS incompatible  
❌ Complex table layouts break  

### ✨ LaraPDFX Advantages:
✅ **Full CSS3 support** - Flexbox, Grid, modern properties  
✅ **Perfect rendering** - Chrome engine ensures pixel-perfect output  
✅ **Fast & efficient** - Optimized memory usage  
✅ **Modern frameworks** - Works with Bootstrap, Tailwind, any CSS  
✅ **RTL languages** - Perfect Arabic, Hebrew, Persian support  
✅ **Custom fonts** - All web fonts work flawlessly  
✅ **Advanced features** - Encryption, watermarks, metadata  
✅ **Production ready** - Tested and battle-proven  

---

## 📋 Requirements

- PHP 8.1 or higher
- Laravel 10.x or 11.x
- Chrome/Chromium installed on your system

---

## 🚀 Installation

### Step 1: Install via Composer

```bash
composer require deecodek/larapdfx
```

### Step 2: Install Chrome/Chromium

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install chromium-browser
```

**Alpine Linux (Docker):**
```bash
apk add --no-cache chromium
```

**macOS:**
```bash
brew install --cask google-chrome
```

**Windows:**
Download from [https://www.google.com/chrome/](https://www.google.com/chrome/)

### Step 3: Publish Configuration

```bash
php artisan larapdfx:install
```

This will:
- Publish configuration file to `config/larapdfx.php`
- Check for Chrome installation
- Guide you through setup

### Step 4: Test Installation

```bash
php artisan larapdfx:test
```

This generates a test PDF at `storage/app/test.pdf` to verify everything works.

---

## 📖 Usage

### Basic Usage

```php
use Deecodek\LaraPDFX\Facades\PDF;

// Generate from Blade view
return PDF::view('invoice', ['data' => $data])
    ->download('invoice.pdf');

// Generate from HTML string
$html = '<h1>Hello World</h1>';
return PDF::html($html)
    ->stream('document.pdf');

// Generate from URL
return PDF::url('https://example.com')
    ->download('page.pdf');
```

### Save to File

```php
PDF::view('report', $data)
    ->save(storage_path('app/reports/report.pdf'));

// Or use storage disk
PDF::view('invoice', $data)
    ->save(storage_path('app/public/invoice.pdf'));
```

### Download PDF

```php
// Direct download
return PDF::view('invoice', $data)
    ->download('invoice.pdf');
```

### Stream PDF (Display in Browser)

```php
// Display inline in browser
return PDF::view('document', $data)
    ->stream('document.pdf');
```

### Base64 Encoding

```php
$base64 = PDF::view('report', $data)->base64();

// Use in email or API response
return response()->json([
    'pdf' => $base64
]);
```

---

## 🎨 Page Settings

### Paper Size

```php
// Predefined formats
PDF::view('invoice', $data)
    ->format('A4')  // A4, A3, A5, Letter, Legal, Tabloid, Ledger
    ->download();

// Or use shortcuts
PDF::view('invoice', $data)->a4()->download();
PDF::view('invoice', $data)->letter()->download();
PDF::view('invoice', $data)->legal()->download();

// Custom size (in millimeters)
PDF::view('invoice', $data)
    ->paperSize(210, 297)  // Custom width x height
    ->download();
```

### Orientation

```php
// Landscape
PDF::view('report', $data)
    ->landscape()
    ->download();

// Portrait (default)
PDF::view('report', $data)
    ->portrait()
    ->download();

// Or use string
PDF::view('report', $data)
    ->orientation('landscape')
    ->download();
```

### Margins

```php
// All sides (in millimeters)
PDF::view('document', $data)
    ->margins(20)  // 20mm all sides
    ->download();

// Top/Right/Bottom/Left
PDF::view('document', $data)
    ->margins(10, 15, 10, 15)
    ->download();

// Using array
PDF::view('document', $data)
    ->margins([
        'top' => 10,
        'right' => 15,
        'bottom' => 10,
        'left' => 15,
    ])
    ->download();
```

### Scale

```php
// Scale the rendering (0.1 to 2.0)
PDF::view('document', $data)
    ->scale(0.8)  // 80% scale
    ->download();
```

---

## 📄 Headers & Footers

### Simple Footer with Page Numbers

```php
PDF::view('report', $data)
    ->footerWithPageNumbers()
    ->download();
```

### Custom Header

```php
$header = '<div style="text-align:center; padding:10px;">Company Name</div>';

PDF::view('invoice', $data)
    ->header($header)
    ->download();
```

### Custom Footer

```php
$footer = '<div style="text-align:center; font-size:10px;">
    Page <span class="pageNumber"></span> of <span class="totalPages"></span>
</div>';

PDF::view('report', $data)
    ->footer($footer)
    ->download();
```

### Available Placeholders in Headers/Footers

- `<span class="pageNumber"></span>` - Current page number
- `<span class="totalPages"></span>` - Total pages
- `<span class="date"></span>` - Current date
- `<span class="title"></span>` - Document title
- `<span class="url"></span>` - Document URL

---

## 🔒 Security Features

### Password Protection

```php
// User password (required to open PDF)
PDF::view('confidential', $data)
    ->password('secret123')
    ->download();

// Owner password (required to modify)
PDF::view('document', $data)
    ->ownerPassword('admin123')
    ->download();
```

### Permissions

```php
PDF::view('document', $data)
    ->allowPrinting(false)    // Disable printing
    ->allowCopy(false)        // Disable copying
    ->allowModify(false)      // Disable modifications
    ->download();
```

---

## 💧 Watermarks

### Text Watermark

```php
PDF::view('document', $data)
    ->watermark('CONFIDENTIAL')
    ->download();

// Custom watermark options
PDF::view('document', $data)
    ->watermark('DRAFT', [
        'opacity' => 0.5,
        'fontSize' => '60px',
        'color' => '#ff0000',
        'rotation' => -45,
    ])
    ->download();
```

---

## 📋 Metadata

### Document Properties

```php
PDF::view('report', $data)
    ->title('Annual Report 2025')
    ->author('John Doe')
    ->subject('Financial Report')
    ->keywords(['finance', 'annual', 'report'])
    ->creator('LaraPDFX')
    ->download();

// Or set all at once
PDF::view('document', $data)
    ->metadata([
        'title' => 'My Document',
        'author' => 'Jane Smith',
        'subject' => 'Important Report',
        'keywords' => 'business, report',
        'creator' => 'My Application',
    ])
    ->download();
```

---

## 🎨 CSS Support

LaraPDFX supports **ALL modern CSS features** because it uses Chrome's rendering engine:

### ✅ Fully Supported

- **CSS3** - All properties
- **Flexbox** - Complete support
- **Grid** - Full grid layouts
- **Custom fonts** - Web fonts, Google Fonts
- **RTL languages** - Arabic, Hebrew, Persian
- **Bootstrap** - All versions
- **Tailwind CSS** - Complete support
- **Animations** - CSS animations/transitions
- **Media queries** - Print media queries
- **Modern selectors** - :nth-child, :not, etc.
- **Background images** - All formats
- **SVG** - Inline and external
- **Box shadows** - All shadow effects
- **Border radius** - Rounded corners
- **Gradients** - Linear and radial
- **Transforms** - Rotate, scale, etc.

### Example with Modern CSS

```blade
{{-- resources/views/pdf/modern-invoice.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto p-8">
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold">Invoice</h2>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-right">Date: {{ $date }}</p>
            </div>
        </div>
    </div>
</body>
</html>
```

```php
PDF::view('pdf.modern-invoice', $data)
    ->download('invoice.pdf');
```

---

## 🌍 RTL Language Support

Perfect support for Right-to-Left languages:

```html
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>مرحبا بك</h1>
    <p>هذا نص تجريبي باللغة العربية</p>
</body>
</html>
```

---

## ⚙️ Configuration

Edit `config/larapdfx.php`:

```php
return [
    // Default paper format
    'paper' => [
        'format' => 'A4',
        'margins' => [
            'top' => 10,
            'right' => 10,
            'bottom' => 10,
            'left' => 10,
        ],
    ],

    // Chrome path (auto-detect if null)
    'chrome_path' => null,

    // Node.js paths
    'node_binary' => null,
    'npm_binary' => null,

    // Timeout in seconds
    'timeout' => 60,

    // Print background graphics
    'print_background' => true,

    // Default output directory
    'output_directory' => 'pdfs',

    // Queue settings
    'queue' => [
        'enabled' => false,
        'connection' => null,
        'queue' => 'default',
    ],
];
```

---

## 🔧 Advanced Usage

### Custom Chrome Path

```php
PDF::view('document', $data)
    ->setChromePath('/usr/bin/chromium-browser')
    ->download();
```

### Custom Timeout

```php
PDF::view('large-report', $data)
    ->timeout(120)  // 2 minutes
    ->download();
```

### Print Background

```php
PDF::view('colorful-doc', $data)
    ->printBackground(true)  // Print background colors/images
    ->download();
```

### Prefer CSS Page Size

```php
PDF::view('custom-layout', $data)
    ->preferCSSPageSize(true)  // Use CSS @page size
    ->download();
```

---

## 🎯 Real-World Examples

### Invoice with Logo and Styling

```blade
{{-- resources/views/invoices/template.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; }
        .header { background: #3490dc; color: white; padding: 20px; }
        .invoice-table { width: 100%; border-collapse: collapse; }
        .invoice-table th, .invoice-table td { 
            border: 1px solid #ddd; 
            padding: 8px; 
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE #{{ $invoice->number }}</h1>
    </div>
    
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->qty }}</td>
                <td>${{ $item->price }}</td>
                <td>${{ $item->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
```

```php
// Controller
public function downloadInvoice($id)
{
    $invoice = Invoice::with('items')->findOrFail($id);
    
    return PDF::view('invoices.template', ['invoice' => $invoice])
        ->format('A4')
        ->margins(15)
        ->footerWithPageNumbers()
        ->title('Invoice #' . $invoice->number)
        ->author('Your Company')
        ->download('invoice-' . $invoice->number . '.pdf');
}
```

### Report with Charts (using Chart.js)

```blade
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myChart"></canvas>
    <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar'],
                datasets: [{
                    label: 'Sales',
                    data: [12, 19, 3],
                }]
            }
        });
    </script>
</body>
</html>
```

---

## 🐛 Troubleshooting

### Chrome Not Found

**Error:** `Chrome binary not found`

**Solution:**
```bash
# Ubuntu/Debian
sudo apt install chromium-browser

# Set path in config
'chrome_path' => '/usr/bin/chromium-browser',
```

### Timeout Issues

**Error:** `Maximum execution time exceeded`

**Solution:**
```php
PDF::view('large-doc', $data)
    ->timeout(180)  // Increase timeout
    ->download();
```

### Memory Issues

**Solution:**
```php
// In php.ini
memory_limit = 512M

// Or in code
ini_set('memory_limit', '512M');
```

### Node.js Not Found

**Solution:**
```bash
# Install Node.js
sudo apt install nodejs npm

# Or set path
'node_binary' => '/usr/bin/node',
```

---

## 📊 Performance Tips

1. **Cache views** - Use Laravel's view caching
2. **Queue long PDFs** - Use Laravel queues for large documents
3. **Optimize images** - Compress images before including
4. **Minimize external resources** - Inline CSS/JS when possible
5. **Use local fonts** - Avoid loading fonts from CDN

---

## 🧪 Testing

```bash
# Run tests
composer test

# Run with coverage
composer test-coverage
```

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📝 License

LaraPDFX is open-sourced software licensed under the [MIT license](LICENSE).

---

## 👨‍💻 Author

**deecodek**  
GitHub: [@deecodek](https://github.com/deecodek)

---

## ⭐ Show Your Support

If you find LaraPDFX helpful, please give it a star on GitHub!

---

## 🙏 Acknowledgments

- Built on top of [Spatie Browsershot](https://github.com/spatie/browsershot)
- Powered by Chrome/Chromium headless browser
- Inspired by the need for better PDF generation in Laravel

---

## 📚 Additional Resources

- [Documentation](https://github.com/deecodek/larapdfx)
- [Issue Tracker](https://github.com/deecodek/larapdfx/issues)
- [Changelog](CHANGELOG.md)

---

**Made with ❤️ for the Laravel community**
