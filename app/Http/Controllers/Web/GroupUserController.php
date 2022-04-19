<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\GroupsService;
use App\Services\GroupUserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Session;

class GroupUserController extends Controller
{
    /** @var GroupUserService */
    private $service;
    /** @var GroupsService */
    private $groupservice;
    /** @var $route */
    public $route;

    /**
     *  GroupUserService constructor.
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->service = new GroupUserService();
        $this->groupservice = new GroupsService();

    }


    /**
     * @param $gId
     * @param $id
     * @return Application|Factory|\Illuminate\View\View
     */
    public function show($gId,$id)
    {
        return view('groupUser.show')
            ->with([
                'gitem' => $this->service->findById($id),
                'item'=>$this->groupservice->findById($gId),
            ]);
    }


    /**
     * @param $gId
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($gId,$id)
    {
        $item=$this->groupservice->findById($gId);
        $this->service->remove($id);
        // Set flash
        Session::flash('success', 'Successfully Removed!');

        return redirect()->route($this->route.'group',$item->id);
    }
}
