<?php

namespace Deecodek\LaraPDFX\Traits;

trait HasMetadata
{
    /**
     * Set PDF metadata.
     *
     * @param array $metadata
     * @return static
     */
    public function metadata(array $metadata): static
    {
        $this->metadata = array_merge($this->metadata, $metadata);
        return $this;
    }

    /**
     * Set PDF title.
     *
     * @param string $title
     * @return static
     */
    public function title(string $title): static
    {
        $this->metadata['title'] = $title;
        return $this;
    }

    /**
     * Set PDF author.
     *
     * @param string $author
     * @return static
     */
    public function author(string $author): static
    {
        $this->metadata['author'] = $author;
        return $this;
    }

    /**
     * Set PDF subject.
     *
     * @param string $subject
     * @return static
     */
    public function subject(string $subject): static
    {
        $this->metadata['subject'] = $subject;
        return $this;
    }

    /**
     * Set PDF keywords.
     *
     * @param string|array $keywords
     * @return static
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
     *
     * @param string $creator
     * @return static
     */
    public function creator(string $creator): static
    {
        $this->metadata['creator'] = $creator;
        return $this;
    }
}
