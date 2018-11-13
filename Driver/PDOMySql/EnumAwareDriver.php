<?php

declare(strict_types=1);

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
