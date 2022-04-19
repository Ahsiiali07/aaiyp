<?php

namespace App\Services;

use App\Models\GroupUser;

class GroupUserService extends BaseService
{
    /**
     * GroupUserService constructor.
     */
    public function __construct() {
        $this->model = new GroupUser();

        parent::__construct();
    }

    /**
     * @param $user_id
     * @param $group_id
     * @return bool
     */
    public function saveUser($data)
    {
        $gu = new GroupUser();
        $gu->user_id = $data['user_id'];
        $gu->group_id = $data['group_id'];
        return $gu->save();
    }

}
