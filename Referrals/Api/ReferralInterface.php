<?php

namespace Wolfsellers\Referrals\Api;


interface ReferralInterface
{
    /**
     * GET for Post api
     * @return string
     */
    public function create();

    /**
     * @return string
     */
    public function getData();

    /**
     * @param int $id
     * @return bool true on success
     */
    public function getDelete($id);

    /**
     * @param int $id
     * @return string
     */
    public function getById($id);

    /**
     * GET for Post api
     * @param string $title
     * @return string
     */
    public function getEdit($title);
}
