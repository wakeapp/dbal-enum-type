<?php

declare(strict_types=1);

namespace Wakeapp\Component\DbalEnumType\Schema;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\MySqlSchemaManager;

class EnumAwareMySqlSchemaManager extends MySqlSchemaManager
{
    /**
     * @param $tableColumn
     *
     * @return Column
     */
    public function getPortableTableColumnDefinition($tableColumn): Column
    {
        return $this->_getPortableTableColumnDefinition($tableColumn);
    }
}
