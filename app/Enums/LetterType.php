<?php

namespace App\Enums;

enum LetterType: string
{
    case INCOMING = 'incoming';
    case OUTGOING = 'outgoing';

    public function type(): string
    {
        return $this->value;
    }
}
