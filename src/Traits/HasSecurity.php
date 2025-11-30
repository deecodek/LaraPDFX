<?php

namespace Deecodek\LaraPDFX\Traits;

trait HasSecurity
{
    /**
     * Set user password for PDF.
     *
     * @param string $password
     * @return static
     */
    public function password(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Set owner password for PDF.
     *
     * @param string $password
     * @return static
     */
    public function ownerPassword(string $password): static
    {
        $this->ownerPassword = $password;
        return $this;
    }

    /**
     * Set PDF permissions.
     *
     * @param array $permissions
     * @return static
     */
    public function permissions(array $permissions): static
    {
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * Allow printing.
     *
     * @param bool $allow
     * @return static
     */
    public function allowPrinting(bool $allow = true): static
    {
        $this->permissions['print'] = $allow;
        return $this;
    }

    /**
     * Allow copying.
     *
     * @param bool $allow
     * @return static
     */
    public function allowCopy(bool $allow = true): static
    {
        $this->permissions['copy'] = $allow;
        return $this;
    }

    /**
     * Allow modification.
     *
     * @param bool $allow
     * @return static
     */
    public function allowModify(bool $allow = true): static
    {
        $this->permissions['modify'] = $allow;
        return $this;
    }
}
