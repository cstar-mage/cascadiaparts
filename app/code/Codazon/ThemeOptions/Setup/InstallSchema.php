<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Codazon\ThemeOptions\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $connection = $setup->getConnection();

        $setup->startSetup();

        /**
         * Create table 'core_config_data'
         */
        $table = $connection->newTable(
            $setup->getTable('codazon_config_data')
        )->addColumn(
            'config_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Config Id'
        )->addColumn(
            'scope',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            8,
            ['nullable' => false, 'default' => 'default'],
            'Config Scope'
        )->addColumn(
            'scope_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => '0'],
            'Config Scope Id'
        )->addColumn(
            'theme_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => '0'],
            'Config Theme Id'
        )->addColumn(
            'path',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => 'general'],
            'Config Path'
        )->addColumn(
            'value',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'Config Value'
        )->addIndex(
            $setup->getIdxName(
                'codazon_config_data',
                ['scope', 'scope_id', 'path', 'theme_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            ['scope', 'scope_id', 'path', 'theme_id'],
            ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
        )->setComment(
            'Codazon Config Data'
        );
        $connection->createTable($table);

        $setup->endSetup();
    }
}
