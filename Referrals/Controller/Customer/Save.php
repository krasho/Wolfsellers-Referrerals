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


class Save extends Action
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

            $data = $this->getRequest()->getPostValue();

            $referral = $this->modelReferralFactory->create();
            $referral->setFirstname($data['firstname']);
            $referral->setLastname($data['lastname']);
            $referral->setEmail($data['email']);
            $referral->setPhone($data['phone']);
            $referral->setStatus('registred');

            $this->validateData($referral);

            $referral->save();

            $this->messageManager->addSuccessMessage(__('Referral has been created successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error occurred while saving referral.' .$e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath('referrals/customer/dashboard/');


    }

    private function validateData($referral)
    {
        if (empty($referral->getFirstname()) || empty($referral->getLastname())) {
            throw new \Exception('First name and last name are required.');
        }
    }

}
