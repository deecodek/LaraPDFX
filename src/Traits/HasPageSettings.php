<?php

namespace Deecodek\LaraPDFX\Traits;

trait HasPageSettings
{
    /**
     * Set page size to A4.
     *
     * @return static
     */
    public function a4(): static
    {
        return $this->format('A4');
    }

    /**
     * Set page size to A3.
     *
     * @return static
     */
    public function a3(): static
    {
        return $this->format('A3');
    }

    /**
     * Set page size to A5.
     *
     * @return static
     */
    public function a5(): static
    {
        return $this->format('A5');
    }

    /**
     * Set page size to Letter.
     *
     * @return static
     */
    public function letter(): static
    {
        return $this->format('Letter');
    }

    /**
     * Set page size to Legal.
     *
     * @return static
     */
    public function legal(): static
    {
        return $this->format('Legal');
    }

    /**
     * Set page size to Tabloid.
     *
     * @return static
     */
    public function tabloid(): static
    {
        return $this->format('Tabloid');
    }

    /**
     * Set page size to Ledger.
     *
     * @return static
     */
    public function ledger(): static
    {
        return $this->format('Ledger');
    }
}
