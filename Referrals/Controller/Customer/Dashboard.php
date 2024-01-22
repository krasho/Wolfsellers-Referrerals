<?php

namespace Wolfsellers\Referrals\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Wolfsellers\Referrals\Model\Referrals;
use Magento\Customer\Model\Session;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Response\RedirectInterface;


class Dashboard extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Referrals
     */
    protected $modelReferral;

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
     * Dashboard constructor.
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
        Referrals $modelReferral,
        Session $customerSession,
        UrlInterface $urlBuilder,
        RedirectInterface $redirect
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->modelReferral = $modelReferral;
        $this->customerSession = $customerSession;
        $this->urlBuilder = $urlBuilder;
        $this->redirect = $redirect;
    }

    public function execute()
    {

        if (!$this->customerSession->isLoggedIn()) {
            $refererUrl = $this->_redirect->getRefererUrl().'referrals/customer/dashboard';
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->urlBuilder->getUrl('customer/account/login', ['referer' =>  base64_encode($refererUrl)]));
            return $resultRedirect;
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('My Referrals'));

        $referralsData = $this->getReferralsData();

        $resultPage->getLayout()->getBlock('referrals.block')
            ->setData('referrals_data', $referralsData);

        return $resultPage;
    }

    protected function getReferralsData()
    {

        $referralsData = [];

        try {

            $referralsCollection = $this->modelReferral->getCollection();

            foreach ($referralsCollection as $referral) {
                $referralsData[] = [
                    'id' => $referral->getId(),
                    'firstname' => $referral->getFirstname(),
                    'lastname' => $referral->getLastname(),
                    'email' => $referral->getEmail(),
                    'phone' => $referral->getPhone(),
                    'status' => $referral->getStatus(),
                ];
            }
        } catch (\Exception $e) {
            throw new NotFoundException(__('Error al obtener los datos de referidos.'));
        }


        return $referralsData;
    }
}
