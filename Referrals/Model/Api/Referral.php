<?php namespace Wolfsellers\Referrals\Model\Api;

use Wolfsellers\Referrals\Api\ReferralInterface;
use Wolfsellers\Referrals\Model\ReferralsFactory;

class Referral implements ReferralInterface
{
    private $referralFactory;
    private $quote;
    protected $response = ['success' => false];
    protected $request;


    public function __construct(
        ReferralsFactory $referralFactory,
        \Magento\Framework\Webapi\Rest\Request $request)
    {
        //$this->quote = $quote;
        $this->referralFactory = $referralFactory;
        $this->request = $request;
    }

    public function create()
    {
        $data = $this->request->getBodyParams();
        $factory = $this->referralFactory->create();
        try {
            $factory->setFirstname($data['firstName']);
            $factory->setLastname($data['lastName']);
            $factory->setEmail($data['email']);
            $factory->setPhone($data['phone']);
            $factory->setStatus($data['status']);
            $factory->setCustomerId($data['customer_id']);
            $factory->save();

            $response = ['success' => true, 'message' => $data];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
        }
        return $response;
    }

    public function edit($id)
    {
        $data = $this->request->getBodyParams();
        $factory = $this->referralFactory->create()->load($id);
        try {
            $factory->setFirstname($data['firstName']);
            $factory->setLastname($data['lastName']);
            $factory->setEmail($data['email']);
            $factory->setPhone($data['phone']);
            $factory->setStatus($data['status']);
            $factory->setCustomerId($data['customer_id']);
            $factory->save();

            $response = ['success' => true, 'message' => $data];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
        }
        return $response;
    }


    /** * @return string */
    public function getData()
    {
        try {
            $data = $this->referralFactory->create()->getCollection()->getData();
            return $data;
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /** * @param int $id * @return bool true on success */
    public function remove($id)
    {
        try {
            if ($id) {
                $data = $this->referralFactory->create()->load($id);
                $data->delete();
                return "success";
            }
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
        }
        return "false";
    }

    public function search()
    {
        $data = $this->request->getParams();
        try {
            $referralCollection = $this->referralFactory->create()->getCollection();
            if (!empty($data['firstname'])) {
                $referralCollection->addFieldToFilter('firstname', ['eq' => $data['firstname']]);
            }

            if (!empty($data['lastname'])) {
                $referralCollection->addFieldToFilter('lastname', ['eq' => $data['lastname']]);
            }

            if (!empty($data['email'])) {
                $referralCollection->addFieldToFilter('email', ['eq' => $data['email']]);
            }

            if (!empty($data['phone'])) {
                $referralCollection->addFieldToFilter('phone', ['eq' => $data['phone']]);
            }

            if (!empty($data['status'])) {
                $referralCollection->addFieldToFilter('status', ['eq' => $data['status']]);
            }

            if (!empty($data['customer_id'])) {
                $referralCollection->addFieldToFilter('customer_id', ['eq' => $data['customer_id']]);
            }


            $data = $referralCollection->getData();
            return ['success' => true, 'message' => json_encode($data)];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
