<?php

namespace Deecodek\LaraPDFX\Console;

use Deecodek\LaraPDFX\Exceptions\PDFException;
use Deecodek\LaraPDFX\Facades\PDF;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larapdfx:test 
                            {--output= : Output file path (default: storage/app/test.pdf)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test LaraPDFX installation by generating a sample PDF';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Testing LaraPDFX installation...');
        $this->newLine();

        try {
            $outputPath = $this->option('output') ?? storage_path('app/test.pdf');

            $this->line('Generating test PDF...');

            $html = $this->getTestHtml();

            PDF::html($html)
                ->format('A4')
                ->margins(10, 10, 10, 10)
                ->footerWithPageNumbers()
                ->save($outputPath);

            $this->newLine();
            $this->info('✓ Success! PDF generated at: '.$outputPath);
            $this->newLine();

            $fileSize = filesize($outputPath);
            $this->line('File size: '.$this->formatBytes($fileSize));

            return Command::SUCCESS;

        } catch (PDFException $e) {
            $this->newLine();
            $this->error('✗ Failed to generate PDF');
            $this->error('Error: '.$e->getMessage());
            $this->newLine();

            $this->line('<fg=yellow>Troubleshooting tips:</>');
            $this->line('1. Make sure Chrome/Chromium is installed');
            $this->line('2. Check Chrome path in config/larapdfx.php');
            $this->line('3. Ensure Node.js is installed (if required)');
            $this->line('4. Try: composer require spatie/browsershot');

            return Command::FAILURE;
        }
    }

    /**
     * Get test HTML content.
     */
    protected function getTestHtml(): string
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
        }
        h1 {
            color: #4A5568;
            border-bottom: 3px solid #4299E1;
            padding-bottom: 10px;
        }
        .feature {
            background: #EDF2F7;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #4299E1;
        }
        .feature h3 {
            margin-top: 0;
            color: #2D3748;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin: 20px 0;
        }
        .box {
            background: #F7FAFC;
            padding: 20px;
            border: 1px solid #E2E8F0;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            color: #38A169;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
            padding: 20px;
            background: #F0FFF4;
            border: 2px solid #38A169;
            border-radius: 8px;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <h1>🎉 LaraPDFX Test PDF</h1>
    
    <div class="success">
        ✓ Congratulations! Your LaraPDFX installation is working perfectly!
    </div>

    <h2>Features Tested:</h2>
    
    <div class="feature">
        <h3>✓ Modern CSS Support</h3>
        <p>This PDF uses CSS3 features including Grid, Flexbox, border-radius, and modern color schemes.</p>
    </div>

    <div class="feature">
        <h3>✓ Perfect Rendering</h3>
        <p>Chrome headless engine ensures pixel-perfect rendering of your HTML and CSS.</p>
    </div>

    <div class="feature">
        <h3>✓ Custom Fonts & Typography</h3>
        <p>Full support for web fonts, custom typography, and all text styling options.</p>
    </div>

    <h2>CSS Grid Layout Test:</h2>
    <div class="grid">
        <div class="box">
            <h4>Box 1</h4>
            <p>Grid layout works!</p>
        </div>
        <div class="box">
            <h4>Box 2</h4>
            <p>Perfectly aligned!</p>
        </div>
        <div class="box">
            <h4>Box 3</h4>
            <p>Modern CSS!</p>
        </div>
        <div class="box">
            <h4>Box 4</h4>
            <p>Production ready!</p>
        </div>
    </div>

    <h2>What's Next?</h2>
    <p>You can now use LaraPDFX in your Laravel application:</p>
    <pre style="background: #2D3748; color: #E2E8F0; padding: 15px; border-radius: 5px; overflow-x: auto;">
use Deecodek\LaraPDFX\Facades\PDF;

// Generate from view
PDF::view('invoice', \$data)->download('invoice.pdf');

// Generate from HTML
PDF::html(\$html)->save('output.pdf');

// With options
PDF::view('report', \$data)
    ->format('A4')
    ->landscape()
    ->margins(10)
    ->footerWithPageNumbers()
    ->download('report.pdf');
    </pre>

    <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #E2E8F0; color: #718096; font-size: 12px;">
        Generated by LaraPDFX - Modern PDF generation for Laravel<br>
        Created by deecodek | MIT License
    </p>
</body>
</html>
HTML;
    }

    /**
     * Format bytes to human readable.
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2).' '.$units[$pow];
    }
}
