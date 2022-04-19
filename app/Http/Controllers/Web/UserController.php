<?php

namespace App\Http\Controllers\Web;

use App\Forms\Users\UpdateUserStatusForm;
use App\Services\Users\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class UserController
 * @package App\Http\Controllers\Web
 */
class UserController extends Controller {

    /**
     * @var UserService $userService
     */
    private $userService;

    /**
     * UserController constructor.
     */
    public function __construct() {
        $this->middleware( 'auth' );
        $this->userService = new UserService();
    }

    /**
     * @return BinaryFileResponse
     */

    public function export(): BinaryFileResponse
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    /**
     * @return Application|Factory|View
     */
    public function index(Request $request) {
        $params = $request->query->all();
        $items  = $this->userService->search( $request->filter, $params->pageSize ?? 20 );
        return view( 'users.index' )
            ->with(
                [
                    'items' => $items,
                    'params' => $params,
                ]
            );
    }

    /**
     * @return Application|Factory|View
     */
    public function indexUser(Request $request) {
        $params = $request->query->all();
        $items  = $this->userService->searchUser( $request->filter, $params->pageSize ?? 20 );
        return view( 'users.index' )
            ->with(
                [
                    'items' => $items,
                    'params' => $params,
                ]
            );
    }

    /**
     * @return Application|Factory|View
     */
    public function indexLeader(Request $request) {
        $params = $request->query->all();
        $items  = $this->userService->searchLeader( $request->filter, $params->pageSize ?? 20 );
        return view( 'leaders.index' )
            ->with(
                [
                    'items' => $items,
                    'params' => $params,
                ]
            );
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function show( $id ) {
        return view( 'users.show' )
            ->with( [
                'item' => $this->userService->findById( $id )
            ] );
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function showLeader( $id ) {
        return view( 'leaders.show' )
            ->with( [
                'item' => $this->userService->findById( $id )
            ] );
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function edit( $id ) {
        return view( 'users.edit' )
            ->with( [
                'item' => $this->userService->findById( $id )
            ] );
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function editLeader( $id ) {
        return view( 'leaders.edit' )
            ->with( [
                'item' => $this->userService->findById( $id )
            ] );
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update( Request $request, $id ) {
        $form = new UpdateUserStatusForm();
        $form->loadFromArray( $request->all() );
        $user = $this->userService->updateStatus( $form, $id );
        $msg     = 'User Status updated successfully!';
        Session::flash( 'success', $msg );

        return response()->json(
            [
                'type' => 'success',
                'msg'  => $msg,
                'data' => $user
            ]
        );
    }

    /**
     * @param $id
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy( $id ) {
        $res = $this->userService->remove( $id );

        if ( $res ) {
            // set flash
            Session::flash( 'success', 'User deleted Successfully!' );
            // Redirect to users
            return redirect( '/users' );
        }
        // set flash
        Session::flash( 'success', 'No User Found!' );
        // Redirect to users
        return redirect( '/users' );
    }

    /**
     * @param $id
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function destroyLeader( $id ) {
        $res = $this->userService->remove( $id );

        if ( $res ) {
            // set flash
            Session::flash( 'success', 'Leader deleted Successfully!' );
            // Redirect to users
            return redirect( '/leaders' );
        }
        // set flash
        Session::flash( 'success', 'No leader Found!' );
        // Redirect to users
        return redirect( '/leaders' );
    }

    /**
     * @param $id
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function approve( $id ) {
        $res = $this->userService->approve( $id );

        if ( $res ) {
            // set flash
            Session::flash( 'success', 'User Approved Successfully!' );
            // Redirect to users
            return redirect( '/users' );
        }
        // set flash
        Session::flash( 'success', 'No User Found!' );
        // Redirect to users
        return redirect( '/users' );
    }

    /**
     * @param $id
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function approveLeader( $id ) {
        $res = $this->userService->approve( $id );

        if ( $res ) {
            // set flash
            Session::flash( 'success', 'Leader Approved Successfully!' );
            // Redirect to Leaders
            return redirect( '/leaders' );
        }
        // set flash
        Session::flash( 'success', 'No Leader Found!' );
        // Redirect to users
        return redirect( '/leaders' );
    }

}
