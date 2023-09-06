<?php
declare(strict_types=1);

namespace App\Shared\Traits;

trait ToArray
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}