<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Content;

interface Block
{
    public function toMarkdown(): string;

    public function toWordPress(): string;
}
