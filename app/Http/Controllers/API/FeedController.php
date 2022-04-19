<?php

namespace App\Http\Controllers\API;

use App\Forms\Feeds\CreateFeedForm;
use App\Forms\Feeds\UpdateFeedForm;
use App\Http\Controllers\Controller;
use App\Models\Feeds;
use App\Services\FeedsService;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class FeedController extends Controller {
	/**
	 * @var FeedsService $service
	 */
	private $service;

	/**
	 * constructor
	 */
	public function __construct() {
		$this->service = new FeedsService();
	}

	/**
	 * @return JsonResponse
	 */
	public function get(): JsonResponse {
		$items = $this->service->getAll();
		if ( count( $items ) > 0 ) {
			return $this->successResponse(
				null,
				$items->load( 'category' ,'user')
			);
		}

		return $this->parametersInvalidResponse();
	}


	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function show( $id ): JsonResponse {
		$item = $this->service->findById( $id );
		if ( $item ) {
			return $this->successResponse(
				null,
				$item->load( 'category' )
			);
		}

		return response()->json( 'Post not Found' );
	}

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 * @throws ValidationException
	 */
	public function store( Request $request ): JsonResponse {
		$form = new CreateFeedForm();
		$form->loadFromArray( $request->all() );
		$item = $this->service->store( $form );
		$msg  = 'Post added successfully!';
		Session::flash( 'success', $msg );

		return $this->successResponse( $msg, $item );
	}

	/**
	 * @param Request $request
	 * @param $id
	 *
	 * @return JsonResponse
	 * @throws ValidationException
	 */
	public function update( Request $request, $id ): JsonResponse {
		$form = new UpdateFeedForm();
		$form->loadFromArray( $request->all() );
		$item = $this->service->update( $form, $id );
		$msg  = 'Post updated successfully!';
		Session::flash( 'success', $msg );

		return $this->successResponse( $msg, $item );
	}

	/**
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function destroy( $id ): JsonResponse {
		if ( $this->service->findById( $id ) ) {
			if ( $this->service->remove( $id ) ) {
				return $this->successResponse('Post deleted successfully');
			}
		}

		return $this->parametersInvalidResponse( 'No such Post exist!' );
	}

	/**
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function share( $id ): JsonResponse {
		if ( $this->service->findById( $id ) ) {
			$data = ['sharer_id' => auth()->id()];
			if ( $this->service->duplicate( $id, $data ) ) {
				return $this->successResponse('Post shared successfully');
			}
		}

		return $this->parametersInvalidResponse( 'No such Post exist!' );
	}

	/**
	 * @param $id
	 * @param $catId
	 *
	 * @return JsonResponse
	 */
	public function shareByCategory( $id, $catId): JsonResponse {

		if ( $this->service->findById( $id ) ) {
			$data = ['sharer_id' => auth()->id(), 'category_id' => $catId];
			if ( $this->service->duplicate( $id, $data ) ) {
				return $this->successResponse('Post shared successfully');
			}
		}

		return $this->parametersInvalidResponse( 'No such Post exist!' );
	}

	/**
	 * @return JsonResponse
	 */
	public function getAllAgainstUser(): JsonResponse
	{

		if (Auth::check()) {

			$items = $this->service->get(
				[

					'user_id' => auth()->id(),

				]
			);

			if ($items && count($items) > 0) {
				return $this->successResponse(
					null,
					$items->load('user', 'category')
				);
			}

			return $this->parametersInvalidResponse('No Items Found!');
		}

		return $this->unAuthorizedResponse();
	}

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function filter( Request $request ) {
		$item = $this->service->filter( $request->all() );

		if ( $item ) {

			return $this->successResponse( null, $item );
		}

		return $this->successResponse( 'No Posts Found!' );
	}
}
