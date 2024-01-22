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
    public function remove($id);

    /**
     * @return string
     */
    public function search();

    /**
     * GET for Post api
     * @return string
     */
    public function edit($id);
}
