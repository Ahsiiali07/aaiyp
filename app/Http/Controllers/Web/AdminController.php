<?php

namespace App\Http\Controllers\Web;

use App\Forms\Admin\CreateAdminFeedForm;
use App\Forms\Admin\UpdateAdminFeedForm;
use App\Http\Controllers\Controller;
use App\Services\AdminService;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * @var string
     */
    private $backRoute = '/admin-feeds';
    /**
     * @var AdminService
     */
    private $service;


    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->service = new AdminService();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $items = $this->service->getAll(20);
        return view('admin_feeds.index')
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
        return view('admin_feeds.create');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $form = new CreateAdminFeedForm();
        $form->loadFromArray($request->all());
        $items = $this->service->store($form);
        $msg = 'Post added successfully!';
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
     * @return Application|Factory|View
     */
    public function show($id)
    {
        return view('admin_feeds.show')
            ->with([
                'item' => $this->service->findById($id)
            ]);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        return view('admin_feeds.edit')
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
        $form = new UpdateAdminFeedForm();
        $form->loadFromArray($request->all());
        $items = $this->service->update($form, $id);
        $msg = 'Post updated successfully!';
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
