<?php

namespace App\Http\Controllers\Web;


use App\Forms\Feeds\CreateFeedForm;
use App\Http\Controllers\Controller;
use App\Services\FeedsService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class FeedsController extends Controller
{
    /**
     * @var string
     */
    private $backRoute = '/feeds';

    /** @var FeedsService */
    private $service;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->service = new FeedsService();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $items = $this->service->getAll(20);
        return view('feed.index')
            ->with(
                [
                    'items' => $items,
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

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        return view('feed.show')
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
        return view('feed.edit')
            ->with([
                'item' => $this->service->findById($id)
            ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('feed.create');
    }


    public function store(Request $request): JsonResponse
    {
        $form = new CreateFeedForm();
        $form->loadFromArray($request->all());
        $shop = $this->service->store($form);
        $msg = 'Feed added successfully!';
        Session::flash('success', $msg);

        return response()->json(
            [
                'type' => 'success',
                'msg' => $msg,
                'data' => $shop
            ]
        );
    }

}
