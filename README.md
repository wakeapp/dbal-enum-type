DBAL Enum Type
==============

Введение
--------

Компонент предоставляет базовую функциональность для регистрации нового типа данных `ENUM` в `Doctrine`.
Таже поддерживается механизм `doctrine:schema:update` для `ENUM`'ов.

Установка
---------

Откройте консоль и, перейдя в директорию проекта, выполните следующую команду для загрузки наиболее подходящей
стабильной версии этого компонента:
```bash
    composer require wakeapp/dbal-enum-type
```
*Эта команда подразумевает что [Composer](https://getcomposer.org) установлен и доступен глобально.*

Пример использования
--------------------

В качестве примера рассмотрим пример на перечислении языков. Для начала нам необходимо создать
класс с перечислениями доступных языков:

```php
<?php

namespace App\AcmeBundle\Entity\Enum;

use Wakeapp\Component\DbalEnumType\Enum\AbstractEnum;

class LanguageListEnum extends AbstractEnum
{
    public const RU = 'ru';
    public const EN = 'en';
    public const DE = 'de';
}
```

Для регистрации нашего перечисления как новый тип данных `Doctrine` необходимо создать еще один класс:

```php
<?php

declare(strict_types=1);

namespace App\AcmeBundle\Doctrine\DBAL\Types;

use App\AcmeBundle\Entity\Enum\LanguageListEnum;
use Wakeapp\Component\DbalEnumType\Type\AbstractEnumType;

class LanguageListEnumType extends AbstractEnumType
{
    public const NAME = 'language_list_enum'; // имя нового типа данных doctrine
    public const BASE_ENUM_CLASS = LanguageListEnum::class;
}
```

Создав необходимые классы остается только зарегистрировать их в `Doctrine DBAL`.
Для регистрации нового `ENUM`-типа воспользуйтесь официальной документацией Doctrine
[Custom Mapping Types](https://www.doctrine-project.org/projects/doctrine-dbal/en/current/reference/types.html#custom-mapping-types).

```php
<?php

\Doctrine\DBAL\Types\Type::addType(LanguageListEnumType::NAME, LanguageListEnumType::class);
```

Если вы используете `Symfony`, то воспользуйтесь соответствующим разделом документации -
[How to Use Doctrine DBAL](https://symfony.com/doc/current/doctrine/dbal.html).

Для начала необходимо зарегистрировать новый глобальный тип данных `enum`:

```yaml
doctrine:
    dbal:
        mapping_types:
            enum: string
```

Далее необходимо установить доступный конкретный вид перечислений в виде списка языков.
Сделать это возможно двумя способами. Первый, классический, через добавление в конфигурационный файл `Doctrine`:

```yaml
doctrine:
    dbal:
        types:
            # Где ключ это LanguageListEnumType::NAME и значение LanguageListEnumType::class
            language_list_enum: App\AcmeBundle\Doctrine\DBAL\Types\LanguageListEnumType
```

Второй способ подойдет если вы используете отдельный бандл. Регистрация происходит через метод `boot`:

```php
<?php

declare(strict_types=1);

namespace App\AcmeBundle;

use App\AcmeBundle\Doctrine\DBAL\Types\LanguageListEnumType;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppAcmeBundleBundle extends Bundle
{
    public function boot()
    {
        Type::addType(LanguageListEnumType::NAME, LanguageListEnumType::class);

        parent::boot();
    }
}

```

Лицензия
--------

![license](https://img.shields.io/badge/License-proprietary-red.svg?style=flat-square)
