<?php

declare(strict_types=1);

namespace Wakeapp\Component\DbalEnumType\Enum;

use ReflectionClass;
use ReflectionException;
use Wakeapp\Component\DbalEnumType\Exception\EnumException;

abstract class AbstractEnum
{
    /**
     * @var array
     */
    protected static $constantList;

    /**
     * @return array
     *
     * @throws EnumException
     */
    public static function getList(): array
    {
        $currentClassName = static::class;

        if (empty(static::$constantList[$currentClassName])) {
            try {
                $class = new ReflectionClass($currentClassName);
            } catch (ReflectionException $e) {
                throw new EnumException(sprintf('Failed to create class %s', $currentClassName));
            }

            static::$constantList[$currentClassName] = $class->getConstants();
        }

        return static::$constantList[$currentClassName];
    }

    /**
     * @return array
     *
     * @throws EnumException
     */
    public static function getListCombine(): array
    {
        return array_combine(static::getList(), static::getList());
    }

    /**
     * @param string $value
     *
     * @return int
     *
     * @throws EnumException
     */
    public static function getBit($value): int
    {
        $constants = static::getList();

        $index = 0;

        foreach ($constants as $constant) {
            if (mb_strtolower($constant) === mb_strtolower($value)) {
                return 1 << $index;
            }

            $index++;
        }

        return 0;
    }
}
