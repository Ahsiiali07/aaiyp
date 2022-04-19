<?php

namespace App\Http\Controllers\Web;

use App\Forms\Groups\CreateGroupForm;
use App\Forms\Groups\UpdateGroupForm;
use App\Http\Controllers\Controller;
use App\Services\GroupsService;
use App\Services\GroupUserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class GroupsController extends Controller
{

    /**
     * @var string
     */
    private $backRoute = '/groups';

    /** @var GroupsService  */
    private $service;

    /** @var GroupUserService */
    private $groupUserService;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->service = new GroupsService();
        $this->groupUserService = new GroupUserService();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $items = $this->service->getAll(20);
        return view('group.index')
            ->with(
                [
                    'items' => $items,
                ]
            );
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('group.create');
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
        $msg = 'Group added successfully!';
        Session::flash('success', $msg);

        return response()->json(
            [
                'type' => 'success',
                'msg' => $msg,
                'data' => $group
            ]
        );
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        return view('group.show')
            ->with([
                'item' => $this->service->findById($id),
                'items' => $this->groupUserService->find([
                    'group_id' => $id
    ]),
            ]);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('group.edit')
            ->with([
                'item' => $this->service->findById($id)
            ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id): JsonResponse
    {
        $form = new UpdateGroupForm();
        $form->loadFromArray($request->all());
        $items = $this->service->update($form, $id);

        $msg = 'Group updated successfully!';
        Session::flash('success', $msg);

        return response()->json(
            [
                'type' => 'success',
                'msg' => $msg,
                'data' => $items
            ]
        );
    }

    /**
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */

    public function destroy($id)
    {
        $this->service->remove($id);

        // Set flash
        Session::flash('success', 'Successfully Removed!');

        // Redirect to users
        return redirect($this->backRoute);
    }

}


