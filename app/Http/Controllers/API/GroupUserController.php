<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\GroupUserService;
use App\Services\Users\IUserType;
use Auth;

use Illuminate\Http\Request;
use Validator;

class GroupUserController extends Controller
{
    /**
     * @var GroupUserService $service
     */
    private $service;

    public function __construct()
    {
        $this->service = new GroupUserService();
    }


    /**
     * @param Request $request
     * @param $id
     */
    public function add(Request $request)
    {
        $user = Auth::user();


        if ($user) {

            if (isset($request->user_id, $request->group_id ))  {

                $res = $this->service->saveUser($request->all());
                if ($res) {

                    return $this->successResponse(trans('Operation Successful!'));
                }

                return $this->parametersInvalidResponse();
            }

            return $this->parametersInvalidResponse();
        }

        return $this->unAuthorizedResponse();
    }


}
