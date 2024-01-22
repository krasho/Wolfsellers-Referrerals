<?php

namespace Wolfsellers\Referrals\Model;

use Magento\Framework\Model\AbstractModel;

class Referrals extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Wolfsellers\Referrals\Model\ResourceModel\Referrals');
    }
}
