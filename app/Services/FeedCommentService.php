<?php

namespace App\Services;

use App\Forms\IForm;
use App\Models\FeedComment;
use Illuminate\Validation\ValidationException;

/**
 * Class PostCommentService
 * @package App\Services
 */
class FeedCommentService extends BaseService {

	/**
	 * PostCommentService constructor.
	 */
	public function __construct() {
		$this->model = new FeedComment();

		parent::__construct();
	}

	/**
	 * @param IForm $form
	 *
	 * @return FeedComment
     * @throws ValidationException
	 */
	public function store( IForm $form ) {
		$form->validate();
		$item = new FeedComment();
		$form->loadToModel( $item );
		$item->feed_id = $form->feed_id;
		$item->user_id = auth()->user()->id;
		$item->save();

		return $item;
	}

	/**
	 * @param IForm $form
	 * @param  $itemId
	 *
	 * @return mixed
	 * @throws ValidationException
	 */
	public function update( IForm $form, $itemId ) {
		$form->validate();
		$item = $this->findById( $itemId );
		$form->loadToModel( $item );
		$item->update();

		return $item;
	}

    /**
     * @param null
     *
     * @return mixed
     */
    public function getComments( $itemId ) {
        $comments = $this->model->where( 'feed_id', $itemId );

        return $comments->orderBy( 'id', 'DESC' )->get();
    }
}
