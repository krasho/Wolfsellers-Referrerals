<?php

namespace Wolfsellers\Referrals\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('wolfsellers_referrals'))
            ->addColumn('id', Table::TYPE_INTEGER, null, ['identity' => true, 'nullable' => false, 'primary' => true], 'ID')
            ->addColumn('firstname', Table::TYPE_TEXT, 255, ['nullable' => false], 'First Name')
            ->addColumn('lastname', Table::TYPE_TEXT, 255, ['nullable' => false], 'Last Name')
            ->addColumn('email', Table::TYPE_TEXT, 255,  ['nullable' => false, 'unique' => true], 'Email')
            ->addColumn('phone', Table::TYPE_TEXT, 20, ['nullable' => true], 'Phone')
            ->addColumn('status', Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => 'pending'], 'Status')
            ->addColumn('customer_id', Table::TYPE_INTEGER, 1, ['nullable' => true], 'Customer Id')
            ->setComment('Referrals Table');

        $installer->getConnection()->createTable($table);

        // Insert 10 dummy records
        $dummyData = [];
        for ($i = 1; $i <= 10; $i++) {
            $dummyData[] = [
                'firstname' => 'DummyFirstName' . $i,
                'lastname'  => 'DummyLastName' . $i,
                'email'     => 'dummy' . $i . '@example.com',
                'phone'     => '123456789' . $i,
                'status'    => 'pending',
            ];
        }

        $installer->getConnection()->insertMultiple($installer->getTable('wolfsellers_referrals'), $dummyData);

        $installer->endSetup();
    }
}
