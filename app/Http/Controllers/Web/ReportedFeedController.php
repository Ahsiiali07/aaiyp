<?php

namespace App\Http\Controllers\Web;

use App\Services\FeedsService;
use App\Services\ReportedFeedService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Class ReportedPostController
 * @package App\Http\Controllers\Web
 */
class ReportedFeedController extends Controller {

    /**
     * @var ReportedFeedService $service
     */
    private $service;

    /**
     * PostController constructor.
     */
    public function __construct() {
        $this->middleware( 'auth' );
        $this->service = new ReportedFeedService();
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function index( Request $request ) {
       $paginatedRecords = true;
        $items = $this->service->getReports(
            $request->input( 'filter' ),
            $paginatedRecords
        );

        if ( $request->ajax() ) {
            return view( 'report._list' )
                ->with( [
                    'items' => $items
                ] );
        }

        return view( 'reported_feed.index' )
            ->with( [
                'items' => $items,
            ] );
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function show( $id ) {
        return view( 'reported_feed.show' )
            ->with( [
                'item' => $this->service->findById( $id )
            ] );
    }

    /**
     * @param $id
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy( $id ) {
        $this->service->remove( $id );

        // Set flash
        Session::flash( 'success', 'Successfully Removed!' );

        // Redirect to users
        return redirect( '/reported-feed' );
    }

}
