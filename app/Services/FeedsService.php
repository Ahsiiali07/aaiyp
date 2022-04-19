<?php

namespace App\Services;

use App\Forms\IForm;
use App\Helpers\GeneralHelper;
use App\Models\Feeds;
use Illuminate\Validation\ValidationException;

/**
 * Class CategoryService
 * @package App\Services
 */
class FeedsService extends BaseService {

    /**
     * TestimonialsService constructor.
     */
    public function __construct() {
        $this->model = new Feeds();

        parent::__construct();
    }

    /**
     * @param IForm $form
     *
     * @return Feeds
     * @throws ValidationException
     */
    public function store( IForm $form ): Feeds
    {
        // Validate Form
        $form->validate();

        $model = $this->model;

        // Assign values to model attributes
        $form->loadToModel( $model );

        if ( isset( $form->media_url ) ) {
            $model->media_url = GeneralHelper::uploadImageManual( $form->media_url, 'media/feed' );
        }
        $model->user_id = auth()->id();
        $model->save();

        return $model;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function filter( array $data ) {
        $query = $this->model;
        if ( isset( $data['title'] ) ) {
            $query = $query->where( 'title', 'LIKE', '%' . $data['title'] . '%' );
        }
        if ( isset( $data['category_id'] ) ) {
            $query = $query->where( 'category_id', $data['category_id'] );
        }
        return $query->get();
    }
}
