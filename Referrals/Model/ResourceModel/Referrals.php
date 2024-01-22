<?php

namespace Wolfsellers\Referrals\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Referrals extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('wolfsellers_referrals', 'id');
    }
}
