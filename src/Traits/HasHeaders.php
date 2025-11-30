<?php

namespace Deecodek\LaraPDFX\Traits;

trait HasHeaders
{
    /**
     * Set header HTML.
     *
     * @param string $html
     * @return static
     */
    public function header(string $html): static
    {
        $this->headerHtml = $html;
        $this->displayHeaderFooter = true;
        return $this;
    }

    /**
     * Set footer HTML.
     *
     * @param string $html
     * @return static
     */
    public function footer(string $html): static
    {
        $this->footerHtml = $html;
        $this->displayHeaderFooter = true;
        return $this;
    }

    /**
     * Set footer with page numbers.
     *
     * @param string|null $template
     * @return static
     */
    public function footerWithPageNumbers(?string $template = null): static
    {
        $template = $template ?? '<div style="text-align:center;font-size:10px;width:100%;">Page <span class="pageNumber"></span> of <span class="totalPages"></span></div>';
        return $this->footer($template);
    }

    /**
     * Disable header and footer.
     *
     * @return static
     */
    public function noHeaderFooter(): static
    {
        $this->displayHeaderFooter = false;
        $this->headerHtml = null;
        $this->footerHtml = null;
        return $this;
    }
}
