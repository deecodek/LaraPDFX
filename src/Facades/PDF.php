<?php

namespace Deecodek\LaraPDFX\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Deecodek\LaraPDFX\PDF view(string $view, array $data = [], array $mergeData = [])
 * @method static \Deecodek\LaraPDFX\PDF html(string $html)
 * @method static \Deecodek\LaraPDFX\PDF url(string $url)
 *
 * @see \Deecodek\LaraPDFX\PDF
 */
class PDF extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'larapdfx';
    }
}
