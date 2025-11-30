<?php

namespace Deecodek\LaraPDFX\Tests\Feature;

use Deecodek\LaraPDFX\Facades\PDF as PDFFacade;
use Deecodek\LaraPDFX\PDF;
use Deecodek\LaraPDFX\Tests\TestCase;

class PDFGenerationTest extends TestCase
{
    /** @test */
    public function it_can_create_pdf_from_html(): void
    {
        $pdf = PDF::html('<h1>Test</h1>');

        $this->assertInstanceOf(PDF::class, $pdf);
        $this->assertEquals('<h1>Test</h1>', $pdf->getHtml());
    }

    /** @test */
    public function it_can_set_paper_format(): void
    {
        $pdf = PDF::html('<h1>Test</h1>')
            ->format('A4');

        $this->assertInstanceOf(PDF::class, $pdf);
    }

    /** @test */
    public function it_can_set_orientation(): void
    {
        $pdf = PDF::html('<h1>Test</h1>')
            ->landscape();

        $this->assertInstanceOf(PDF::class, $pdf);

        $pdf2 = PDF::html('<h1>Test</h1>')
            ->portrait();

        $this->assertInstanceOf(PDF::class, $pdf2);
    }

    /** @test */
    public function it_can_set_margins(): void
    {
        $pdf = PDF::html('<h1>Test</h1>')
            ->margins(10, 15, 10, 15);

        $this->assertInstanceOf(PDF::class, $pdf);
    }

    /** @test */
    public function it_can_use_facade(): void
    {
        $pdf = PDFFacade::html('<h1>Test</h1>');

        $this->assertInstanceOf(PDF::class, $pdf);
    }

    /** @test */
    public function it_can_chain_methods(): void
    {
        $pdf = PDF::html('<h1>Test</h1>')
            ->format('A4')
            ->landscape()
            ->margins(10)
            ->scale(0.9)
            ->timeout(60);

        $this->assertInstanceOf(PDF::class, $pdf);
    }

    /** @test */
    public function it_can_set_metadata(): void
    {
        $pdf = PDF::html('<h1>Test</h1>')
            ->title('Test Document')
            ->author('Test Author')
            ->subject('Test Subject')
            ->keywords(['test', 'pdf'])
            ->creator('LaraPDFX');

        $this->assertInstanceOf(PDF::class, $pdf);
    }

    /** @test */
    public function it_can_use_shortcuts(): void
    {
        $pdf = PDF::html('<h1>Test</h1>')
            ->a4()
            ->landscape();

        $this->assertInstanceOf(PDF::class, $pdf);
    }
}
