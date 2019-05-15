<?php

declare(strict_types=1);

/*
 * This file is part of the DbalEnumType package.
 *
 * (c) Wakeapp <https://wakeapp.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wakeapp\Component\DbalEnumType\Driver\PDOMySql;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Wakeapp\Component\DbalEnumType\Schema\EnumAwareMySqlSchemaManager;

class EnumAwareDriver extends Driver
{
    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(Connection $conn)
    {
        return new EnumAwareMySqlSchemaManager($conn);
    }
}
