<?php

namespace Deecodek\LaraPDFX\Traits;

trait HasMetadata
{
    /**
     * Set PDF metadata.
     */
    public function metadata(array $metadata): static
    {
        $this->metadata = array_merge($this->metadata, $metadata);

        return $this;
    }

    /**
     * Set PDF title.
     */
    public function title(string $title): static
    {
        $this->metadata['title'] = $title;

        return $this;
    }

    /**
     * Set PDF author.
     */
    public function author(string $author): static
    {
        $this->metadata['author'] = $author;

        return $this;
    }

    /**
     * Set PDF subject.
     */
    public function subject(string $subject): static
    {
        $this->metadata['subject'] = $subject;

        return $this;
    }

    /**
     * Set PDF keywords.
     */
    public function keywords(string|array $keywords): static
    {
        if (is_array($keywords)) {
            $keywords = implode(', ', $keywords);
        }
        $this->metadata['keywords'] = $keywords;

        return $this;
    }

    /**
     * Set PDF creator.
     */
    public function creator(string $creator): static
    {
        $this->metadata['creator'] = $creator;

        return $this;
    }
}
