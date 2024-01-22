<?php

namespace Wolfsellers\Referrals\Model\ResourceModel\Referrals;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(
            'Wolfsellers\Referrals\Model\Referrals',
            'Wolfsellers\Referrals\Model\ResourceModel\Referrals'
        );
    }
}
