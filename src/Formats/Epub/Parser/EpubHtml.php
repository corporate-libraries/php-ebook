<?php

namespace Kiwilan\Ebook\Formats\Epub\Parser;

/**
 * Read `.html` file from `.epub` archive to extract content.
 */
class EpubHtml
{
    protected string $filename;

    protected ?string $head = null;

    protected ?string $body = null;

    public static function make(?string $html, ?string $filename): self
    {
        $self = new self();

        if (! $html || ! $filename) {
            return $self;
        }

        $self->filename = $filename;
        $self->head = $self->getTag($html, 'head');
        $self->body = $self->getTag($html, 'body');

        return $self;
    }

    private function getTag(string $html, string $tag): string
    {
        preg_match('/<'.$tag.'.*>(.*?)<\/'.$tag.'>/is', $html, $matches);

        if (array_key_exists(0, $matches)) {
            return trim($matches[0]);
        }

        return '';
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getHead(): ?string
    {
        return $this->head;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function toArray(): array
    {
        return [
            'head' => $this->head,
            'body' => $this->body,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
