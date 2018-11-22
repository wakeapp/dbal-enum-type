<?php

declare(strict_types=1);

namespace Wakeapp\Component\DbalEnumType\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use Wakeapp\Component\DbalEnumType\Exception\EnumException;
use function implode;
use function in_array;
use function sprintf;

abstract class AbstractEnumType extends Type
{
    /**
     * @var array
     */
    protected static $enumList;

    /**
     * Returns class name which contains constants. Constants values will be used as ENUM values.
     *
     * @return string
     */
    abstract public static function getEnumClass(): string;

    /**
     * Returns name of the doctrine type
     *
     * @return string
     */
    abstract public static function getTypeName(): string;

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        $closure = function ($value) {
            return sprintf('\'%s\'', $value);
        };

        $values = implode(',', array_map($closure, static::getValues()));

        return sprintf('ENUM(%s)', $values);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, static::getValues(), true)) {
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
        return static::getTypeName();
    }

    /**
     * Returns list of the enum values
     *
     * @return array
     *
     * @throws EnumException
     */
    public static function getValues(): array
    {
        $enumClass = static::getEnumClass();

        if (!empty(static::$enumList[$enumClass])) {
            return static::$enumList[$enumClass];
        }

        try {
            $class = new ReflectionClass($enumClass);
        } catch (ReflectionException $e) {
            throw new EnumException(sprintf('Failed to create class %s', $enumClass));
        }

        static::setValues($class->getConstants());

        return static::$enumList[$enumClass];
    }

    /**
     * Set currently registered enum values
     *
     * @param array $array
     */
    public static function setValues(array $array)
    {
        static::$enumList[static::getEnumClass()] = $array;
    }
}
