<?php

declare(strict_types=1);

namespace Wakeapp\Component\DbalEnumType\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use Wakeapp\Component\DbalEnumType\Enum\AbstractEnum;
use Wakeapp\Component\DbalEnumType\Exception\EnumException;

abstract class AbstractEnumType extends Type
{
    public const NAME = null;
    public const BASE_ENUM_CLASS = null;

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        $closure = function ($value) {
            return sprintf("'%s'", $value);
        };

        $values = implode(', ', array_map($closure, static::getValues()));

        return sprintf('ENUM(%s)', $values);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!\in_array($value, static::getValues(), true)) {
            throw new InvalidArgumentException(sprintf('Invalid %s value.', $value));
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return static::NAME;
    }

    /**
     * @return array
     *
     * @throws EnumException
     */
    public static function getChoices(): array
    {
        $baseEnumClass = static::BASE_ENUM_CLASS;

        if (is_subclass_of($baseEnumClass, AbstractEnum::class)) {
            /** @var AbstractEnum $baseEnumClass */
            return $baseEnumClass::getListCombine();
        }

        throw new EnumException(sprintf('BASE_ENUM_CLASS should be an instance of "%s"', AbstractEnum::class));
    }

    /**
     * @return array
     *
     * @throws EnumException
     */
    public static function getValues(): array
    {
        return array_keys(static::getChoices());
    }
}
