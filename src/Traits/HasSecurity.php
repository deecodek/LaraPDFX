<?php

namespace Deecodek\LaraPDFX\Traits;

trait HasSecurity
{
    /**
     * Set user password for PDF.
     */
    public function password(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set owner password for PDF.
     */
    public function ownerPassword(string $password): static
    {
        $this->ownerPassword = $password;

        return $this;
    }

    /**
     * Set PDF permissions.
     */
    public function permissions(array $permissions): static
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Allow printing.
     */
    public function allowPrinting(bool $allow = true): static
    {
        $this->permissions['print'] = $allow;

        return $this;
    }

    /**
     * Allow copying.
     */
    public function allowCopy(bool $allow = true): static
    {
        $this->permissions['copy'] = $allow;

        return $this;
    }

    /**
     * Allow modification.
     */
    public function allowModify(bool $allow = true): static
    {
        $this->permissions['modify'] = $allow;

        return $this;
    }
}
