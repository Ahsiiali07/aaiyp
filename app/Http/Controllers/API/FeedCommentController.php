<?php

namespace App\Http\Controllers\API;

use App\Forms\FeedComment\FeedCommentForm;
use App\Forms\FeedComment\UpdateFeedCommentForm;
use App\Services\FeedCommentService;
use App\Services\FeedsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

/**
 * Class PostCommentController
 * @package App\Http\Controllers\API
 */
class FeedCommentController extends Controller {

	/**
	 * @var FeedCommentService
	 */
	public $service;

	/**
	 * FeedCommentController constructor.
	 */
	public function __construct() {
		$this->service = new FeedCommentService();
	}

	/**
	 * @param Request $request
	 * @param $feed_id
	 *
	 * @return JsonResponse
	 * @throws ValidationException
	 */
	public function store( Request $request, $feed_id ): JsonResponse
    {
		if ( auth()->id() ) {
			$form          = new FeedCommentForm();
			$form->user_id = auth()->id();
			$form->feed_id = intval( $feed_id );
			$form->loadFromArray( $request->all() );
			$item = $this->service->store( $form );
			if ( $item ) {
				return $this->successResponse( trans( 'Post Comment added Successfully!' ), $item );
			}
		}

		return $this->unAuthorizedResponse();
	}

	/**
	 * @param Request $request
	 * @param $id
	 *
	 * @return JsonResponse
	 * @throws ValidationException
	 */
	public function update( Request $request, $id ) {
		$form = new UpdateFeedCommentForm();
		$form->loadFromArray( $request->all() );
		$item = $this->service->update( $form, $id );
		if ( $request ) {
			return $this->successResponse( trans( 'Post Comment updated Successfully!' ), $item );
		}

		return $this->unAuthorizedResponse();

	}

	/**
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function getPostComment( $id ): JsonResponse
    {;
		$items = $this->service->getComments( $id );

		if ( $items ) {

			return $this->successResponse( null, $items->load( 'user' ) );
		}

		return $this->successResponse( trans( 'No Post Comments Found!' ) );
	}
}
