<?php
declare(strict_types=1);

namespace App\Shared\Traits;

use JetBrains\PhpStorm\Pure;

trait StaticCreateSelf
{
    /**
     * @param array $values
     * @return StaticCreateSelf
     */
    #[Pure]
    public static function create(array $values): self
    {
        $dto = new self();

        foreach ($values as $key => $value) {
            if (property_exists($dto, $key)) {
                $dto->$key = $value;
            }
        }

        return $dto;
    }
}