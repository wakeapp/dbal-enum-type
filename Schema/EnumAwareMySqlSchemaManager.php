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
