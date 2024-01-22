<?php

namespace Wolfsellers\Referrals\Block;

use Magento\Framework\View\Element\Template;

class Referrals extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Vendor\CustomModule\Model\ResourceModel\Referral\Collection
     */
    protected $referralCollection;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param \Kaat\Referral\Model\ResourceModel\Referral\CollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Kaat\Referral\Model\ResourceModel\Referral\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Retrieve referral collection
     *
     * @return \Kaat\Referral\CustomModule\Model\ResourceModel\Referral\Collection
     */
    public function getReferralCollection()
    {
        if (!$this->referralCollection) {
            $this->referralCollection = $this->collectionFactory->create();
        }
        return $this->referralCollection;
    }
}
