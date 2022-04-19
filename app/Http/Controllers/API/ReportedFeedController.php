<?php

namespace App\Http\Controllers\API;


use App\Forms\Feeds\CreateReportForm;
use App\Services\FeedsService;
use App\Services\ReportedFeedService;
use Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class ReportedPostController
 * @package App\Http\Controllers\API
 */
class ReportedFeedController extends Controller {

    /**
     * @var FeedsService $service
     */
    private $service;

    /**
     * PostController constructor.
     */
    public function __construct() {
        $this->service = new ReportedFeedService();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store( Request $request ): JsonResponse
    {

        $user = Auth::user();
        if ( $user ) {
            $validated = Validator::make( $request->all(), [
                'feed_id'      => 'required',
                'user_id'         => 'required',
                'reason'          => 'required',
                'detailed_reason' => 'required'
            ] );
            if ( $validated->fails() ) {
                return $this->parametersInvalidResponse( null, $validated->errors()->all() );
            }
            $form = new CreateReportForm();
            $form->loadFromArray( $request->all() );
            $item = $this->service->store( $form );

            return $this->successResponse( 'Post reported successfully!', $item );
        }

        return $this->parametersInvalidResponse();

    }

}
