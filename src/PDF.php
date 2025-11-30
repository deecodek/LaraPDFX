<?php

namespace Deecodek\LaraPDFX;

use Deecodek\LaraPDFX\Exceptions\PDFException;
use Deecodek\LaraPDFX\Traits\HasHeaders;
use Deecodek\LaraPDFX\Traits\HasMetadata;
use Deecodek\LaraPDFX\Traits\HasPageSettings;
use Deecodek\LaraPDFX\Traits\HasSecurity;
use Deecodek\LaraPDFX\Traits\HasWatermark;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class PDF
{
    use HasHeaders, HasMetadata, HasPageSettings, HasSecurity, HasWatermark;

    protected string $html = '';

    protected array $options = [];

    protected ?string $paperFormat = null;

    protected ?string $orientation = null;

    protected array $margins = [];

    protected ?string $headerHtml = null;

    protected ?string $footerHtml = null;

    protected bool $displayHeaderFooter = false;

    protected ?string $password = null;

    protected ?string $ownerPassword = null;

    protected array $permissions = [];

    protected ?string $watermarkText = null;

    protected array $watermarkOptions = [];

    protected array $metadata = [];

    protected ?string $nodeBinary = null;

    protected ?string $npmBinary = null;

    protected ?string $chromePath = null;

    protected int $timeout = 60;

    protected bool $landscape = false;

    protected bool $printBackground = true;

    protected ?float $scale = null;

    protected bool $preferCSSPageSize = false;

    /**
     * Create a new PDF instance.
     */
    public function __construct()
    {
        $this->paperFormat = config('larapdfx.paper.format', 'A4');
        $this->margins = config('larapdfx.paper.margins', [
            'top' => 10,
            'right' => 10,
            'bottom' => 10,
            'left' => 10,
        ]);
        $this->timeout = config('larapdfx.timeout', 60);
        $this->nodeBinary = config('larapdfx.node_binary');
        $this->npmBinary = config('larapdfx.npm_binary');
        $this->chromePath = config('larapdfx.chrome_path');
        $this->printBackground = config('larapdfx.print_background', true);
    }

    /**
     * Create PDF from a Blade view.
     */
    public static function view(string $view, array $data = [], array $mergeData = []): static
    {
        $instance = new static;
        $instance->html = View::make($view, $data, $mergeData)->render();

        return $instance;
    }

    /**
     * Create PDF from raw HTML.
     */
    public static function html(string $html): static
    {
        $instance = new static;
        $instance->html = $html;

        return $instance;
    }

    /**
     * Create PDF from a URL.
     */
    public static function url(string $url): static
    {
        $instance = new static;
        $instance->html = $url;
        $instance->options['isUrl'] = true;

        return $instance;
    }

    /**
     * Set paper format.
     *
     * @param  string  $format  (A4, Letter, Legal, A3, A5, etc.)
     */
    public function format(string $format): static
    {
        $this->paperFormat = $format;

        return $this;
    }

    /**
     * Set custom paper size.
     *
     * @param  float  $width  in millimeters
     * @param  float  $height  in millimeters
     */
    public function paperSize(float $width, float $height): static
    {
        $this->options['width'] = $width.'mm';
        $this->options['height'] = $height.'mm';
        $this->paperFormat = null;

        return $this;
    }

    /**
     * Set paper orientation.
     *
     * @param  string  $orientation  (portrait, landscape)
     */
    public function orientation(string $orientation): static
    {
        $this->landscape = strtolower($orientation) === 'landscape';

        return $this;
    }

    /**
     * Set landscape orientation.
     */
    public function landscape(): static
    {
        $this->landscape = true;

        return $this;
    }

    /**
     * Set portrait orientation.
     */
    public function portrait(): static
    {
        $this->landscape = false;

        return $this;
    }

    /**
     * Set margins.
     */
    public function margins(float|array $top, ?float $right = null, ?float $bottom = null, ?float $left = null): static
    {
        if (is_array($top)) {
            $this->margins = $top;
        } else {
            $this->margins = [
                'top' => $top,
                'right' => $right ?? $top,
                'bottom' => $bottom ?? $top,
                'left' => $left ?? $right ?? $top,
            ];
        }

        return $this;
    }

    /**
     * Set scale factor.
     *
     * @param  float  $scale  (0.1 to 2.0)
     */
    public function scale(float $scale): static
    {
        $this->scale = max(0.1, min(2.0, $scale));

        return $this;
    }

    /**
     * Enable/disable background printing.
     */
    public function printBackground(bool $print = true): static
    {
        $this->printBackground = $print;

        return $this;
    }

    /**
     * Prefer CSS page size.
     */
    public function preferCSSPageSize(bool $prefer = true): static
    {
        $this->preferCSSPageSize = $prefer;

        return $this;
    }

    /**
     * Set timeout in seconds.
     */
    public function timeout(int $seconds): static
    {
        $this->timeout = $seconds;

        return $this;
    }

    /**
     * Set Node.js binary path.
     */
    public function setNodeBinary(string $path): static
    {
        $this->nodeBinary = $path;

        return $this;
    }

    /**
     * Set NPM binary path.
     */
    public function setNpmBinary(string $path): static
    {
        $this->npmBinary = $path;

        return $this;
    }

    /**
     * Set Chrome/Chromium path.
     */
    public function setChromePath(string $path): static
    {
        $this->chromePath = $path;

        return $this;
    }

    /**
     * Build the Browsershot instance.
     */
    protected function buildBrowsershot(): Browsershot
    {
        if (! empty($this->options['isUrl'])) {
            $browsershot = Browsershot::url($this->html);
        } else {
            $browsershot = Browsershot::html($this->html);
        }

        // Set timeout
        $browsershot->timeout($this->timeout);

        // Set binary paths if specified
        if ($this->nodeBinary) {
            $browsershot->setNodeBinary($this->nodeBinary);
        }

        if ($this->npmBinary) {
            $browsershot->setNpmBinary($this->npmBinary);
        }

        if ($this->chromePath) {
            $browsershot->setChromePath($this->chromePath);
        }

        // Set paper format or custom size
        if ($this->paperFormat) {
            $browsershot->format($this->paperFormat);
        } elseif (isset($this->options['width'], $this->options['height'])) {
            $browsershot->paperSize($this->options['width'], $this->options['height']);
        }

        // Set orientation
        if ($this->landscape) {
            $browsershot->landscape();
        }

        // Set margins
        $browsershot->margins(
            $this->margins['top'] ?? 0,
            $this->margins['right'] ?? 0,
            $this->margins['bottom'] ?? 0,
            $this->margins['left'] ?? 0,
            'mm'
        );

        // Print background
        if ($this->printBackground) {
            $browsershot->showBackground();
        }

        // Set scale
        if ($this->scale) {
            $browsershot->scale($this->scale);
        }

        // Prefer CSS page size
        if ($this->preferCSSPageSize) {
            $browsershot->preferCssPageSize();
        }

        // Set header and footer
        if ($this->displayHeaderFooter) {
            $browsershot->showBrowserHeaderAndFooter();

            if ($this->headerHtml) {
                $browsershot->headerHtml($this->headerHtml);
            }

            if ($this->footerHtml) {
                $browsershot->footerHtml($this->footerHtml);
            }
        }

        // No sandbox for compatibility
        $browsershot->noSandbox();

        return $browsershot;
    }

    /**
     * Generate PDF and return as string.
     *
     * @throws PDFException
     */
    public function output(): string
    {
        try {
            return $this->buildBrowsershot()->pdf();
        } catch (\Exception $e) {
            throw new PDFException('Failed to generate PDF: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Save PDF to a file.
     *
     * @throws PDFException
     */
    public function save(string $path): static
    {
        try {
            $directory = dirname($path);
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $this->buildBrowsershot()->save($path);

            return $this;
        } catch (\Exception $e) {
            throw new PDFException('Failed to save PDF: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Download the PDF.
     */
    public function download(string $filename = 'document.pdf'): Response
    {
        $content = $this->output();

        return new Response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Content-Length' => strlen($content),
        ]);
    }

    /**
     * Stream the PDF inline.
     */
    public function stream(string $filename = 'document.pdf'): Response
    {
        $content = $this->output();

        return new Response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
            'Content-Length' => strlen($content),
        ]);
    }

    /**
     * Get base64 encoded PDF.
     */
    public function base64(): string
    {
        return base64_encode($this->output());
    }

    /**
     * Get the generated HTML.
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}
