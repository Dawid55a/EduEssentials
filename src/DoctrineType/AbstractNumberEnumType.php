<?php

namespace App\DoctrineType;

use BackedEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use LogicException;

abstract class AbstractNumberEnumType extends Type
{
    /**
     * @inheritDoc
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof BackedEnum) {
            return $value->value;
        }
        return null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (false === enum_exists($this::getEnumsClass(), true)) {
            throw new LogicException(sprintf('Enum class "%s" not found.', $this::getEnumsClass()));
        }
        return $this::getEnumsClass()::tryFrom($value);
    }

    abstract public static function getEnumsClass(): string;
}