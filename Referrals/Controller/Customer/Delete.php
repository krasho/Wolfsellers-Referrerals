<?php

namespace Wolfsellers\Referrals\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Wolfsellers\Referrals\Model\ReferralsFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Response\RedirectInterface;


class Delete extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var ReferralsFactory
     */
    protected $modelReferralFactory;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var RedirectInterface
     */
    protected $redirect;

    /**
     * Create constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Referrals $modelReferral
     * @param Session $customerSession
     * @param UrlInterface $urlBuilder
     * @param RedirectInterface $redirect
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ReferralsFactory $modelReferralFactory,
        Session $customerSession,
        UrlInterface $urlBuilder,
        RedirectInterface $redirect
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->modelReferralFactory = $modelReferralFactory;
        $this->customerSession = $customerSession;
        $this->urlBuilder = $urlBuilder;
        $this->redirect = $redirect;
    }

    public function execute()
    {

        try {

            $id = $this->getRequest()->getParam('id');

            if (isset($id)) {
                $this->deleteReferralById($id);
                $this->messageManager->addSuccessMessage(__('Referral has been deleted successfully.'));
            }

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error occurred while saving referral.' .$e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath('referrals/customer/dashboard/');


    }

    protected function deleteReferralById($referralId)
    {
        $referral = $this->modelReferralFactory->create();
        $referral->load($referralId);
        if ($referral->getId()) {
            $referral->delete();
        }
    }

}
