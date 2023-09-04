<?php

namespace App\DoctrineType;

use App\DTO\TestStatusEnum;

class TestStatusType extends AbstractNumberEnumType
{

    const NAME = 'test_status';

    public static function getEnumsClass(): string
    {
        return TestStatusEnum::class;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }
}