<?php namespace Wolfsellers\Referrals\Model\Api;

use Wolfsellers\Referrals\Api\ReferralInterface;
use Wolfsellers\Referrals\Model\ReferralsFactory;

class Referral implements ReferralInterface
{
    private $referralFactory;
    private $quote;
    protected $response = ['success' => false];
    protected  $request;

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
    public function getDelete($id)
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

    /** * @param int $id * @return string */
    public function getById($id)
    {
        try {
            if ($id) {
                $data = $this->referralFactory->create()->load($id)->getData();
                return ['success' => true, 'message' => json_encode($data)];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /** * GET for Post api * @param string $title * @return string */
    public function getEdit($title)
    {
        $edit = file_get_contents("php://input");
        $data = json_decode($edit, true);
        $insertData = $this->referralFactory->create();
        $id = $data['id'];
        if ($id) {
            try {
                $insertData->load($id);
                $insertData->setTitle($data['title'])->save();
                $response = ['success' => true, 'message' => $data];
            } catch (\Exception $e) {
                $response = ['success' => false, 'message' => $e->getMessage()];
            }
        }
        return $response;
    }
}
