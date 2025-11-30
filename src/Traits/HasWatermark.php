<?php

namespace Deecodek\LaraPDFX\Traits;

trait HasWatermark
{
    /**
     * Add text watermark.
     */
    public function watermark(string $text, array $options = []): static
    {
        $this->watermarkText = $text;
        $this->watermarkOptions = array_merge([
            'opacity' => 0.3,
            'fontSize' => '48px',
            'color' => '#cccccc',
            'rotation' => -45,
        ], $options);

        return $this;
    }

    /**
     * Remove watermark.
     */
    public function noWatermark(): static
    {
        $this->watermarkText = null;
        $this->watermarkOptions = [];

        return $this;
    }

    /**
     * Get watermark HTML to inject.
     */
    protected function getWatermarkHtml(): string
    {
        if (! $this->watermarkText) {
            return '';
        }

        $opacity = $this->watermarkOptions['opacity'] ?? 0.3;
        $fontSize = $this->watermarkOptions['fontSize'] ?? '48px';
        $color = $this->watermarkOptions['color'] ?? '#cccccc';
        $rotation = $this->watermarkOptions['rotation'] ?? -45;

        return <<<HTML
        <div style="
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate({$rotation}deg);
            font-size: {$fontSize};
            color: {$color};
            opacity: {$opacity};
            z-index: 9999;
            pointer-events: none;
            white-space: nowrap;
            font-weight: bold;
        ">{$this->watermarkText}</div>
        HTML;
    }
}
