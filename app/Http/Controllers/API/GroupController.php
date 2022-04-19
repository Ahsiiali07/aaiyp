<?php

namespace App\Http\Controllers\API;

use App\Forms\Groups\CreateGroupForm;
use App\Http\Controllers\Controller;
use App\Services\GroupsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Session;

class GroupController extends Controller
{
    /**
     * @var GroupsService $service
     */
    private $service;

    /**
     * constructor
     */
    public function __construct() {
        $this->service = new GroupsService();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $form = new CreateGroupForm();
        $form->loadFromArray($request->all());
        $group = $this->service->store($form);
        if ($group){
            return $this->successResponse(trans('Group Added'), $group);
        }
      return $this->parametersInvalidResponse();
    }
    
        /**
     * @return JsonResponse
     */
    public function getAllGroups(): JsonResponse {
        $items = $this->service->getAll();
        if ( count( $items ) > 0 ) {
            return $this->successResponse(
                null,
                $items->load( 'category' )
            );
        }

       return $this->parametersInvalidResponse('no group in db ');
    }

}
