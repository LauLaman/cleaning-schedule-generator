<?php

declare(strict_types=1);

namespace App\System\Domain\ValueObject;

use Noahlvb\ValueObject\ValueObjectInteger;

abstract class AbstractId extends ValueObjectInteger
{
    protected function sanitize(int $value): int
    {
        return $value;
    }

    public function isValid(int $value): bool
    {
        return true;
    }
}
