<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Models\Category;
use App\Models\Group;
use App\Forms\IForm;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

/**
 * Class CategoryService
 * @package App\Services
 */
class GroupsService extends BaseService {

    /**
     * CategoryService constructor.
     */
    public function __construct() {
        $this->model = new Group();

        parent::__construct();
    }

    /**
     * @param null $paginate
     *
     * @return mixed
     */
    public function getAll( $paginate = null ) {
        if ( $paginate ) {
            return $this->model->paginate( $paginate );
        }

        return $this->model->get();
    }

    /**
     * @param IForm $form
     *
     * @return mixed
     * @throws ValidationException
     */
    public function store( IForm $form ) {
        $form->validate();
        if ( $form->image_url ) {
            $form->image_url = GeneralHelper::uploadImageManual( $form->image_url, 'images/group' );
        }
        $group = new Group();
        $form->loadToModel( $group );
        $group->save();

        return $group;
    }

    /**
     * @param IForm $form
     * @param  $groupId
     *
     * @return mixed
     * @throws ValidationException
     */
    public function update( IForm $form, $groupId ) {
        $form->validate();
        if ( $form->image_url ) {
            $form->image_url = GeneralHelper::uploadImageManual( $form->image_url, 'images/category', ( ! $form->old_image_url ) ?: true, $form->old_image_url ?? null );
        } else {
            $form->image_url = $form->old_image_url;
        }
        $group = $this->findById( $groupId );
        $form->loadToModel( $group );
        $group->update();

        return $group;
    }

    /**
     * @param $data
     * @param $groupId
     *
     * @return mixed
     */
    public function updateDetails( $data, $groupId ) {
        $group = $this->findById( $groupId );
        $group->update( $data );

        return $group;
    }

    /**
     * @return array
     */
    public static function allWithIdAndName(): array
    {
        return Category::all()->pluck( 'name', 'id' )->all();
    }

    /**
     * @param $categoryId
     * @param $paginate
     * @return mixed
     */
    public function getByCategory($categoryId, $paginate = null )
    {
        if ($paginate){
            if ($this->relations){
                return $this->model->where('category_id',$categoryId)->with($this->relations)->orderBy('id','DESC')->paginate($paginate);
            }
            return $this->model->where('category_id',$categoryId)->orderBy('id','DESC')->paginate($paginate);
        }
        if ($this->relations){
            return $this->model->where('category_id',$categoryId)->with($this->relations)->orderBy('id','DESC')->get();
        }
        return $this->model->where('category_id',$categoryId)->orderBy('id','DESC')->get();
    }
}
