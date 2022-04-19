<?php

namespace App\Http\Controllers\API;

use App\Services\FeedsService;
use App\Services\FeedLikeService;
use Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * Class PostLikeController
 * @package App\Http\Controllers\API
 */
class FeedLikeController extends Controller
{

    /**
     * @var FeedLikeService $service
     */
    private $service;

    /**
     * @var FeedsService
     */
    private $feedsService;

    /**
     * FavoriteController constructor.
     */
    public function __construct()
    {
        $this->service = new FeedLikeService();
        $this->feedsService = new FeedsService();
    }

    /**
     * @param $feedId
     *
     * @return JsonResponse
     */
    public function favoriteUnFavorite($feedId): JsonResponse
    {
        if (Auth::check()) {

            $userId = auth()->id();

            if (isset($feedId)) {
                if ($ser = $this->feedsService->findById($feedId)) {

                    $item = $this->service->findFirst([
                        'user_id' => auth()->id(),
                        'feed_id' => $feedId,
                    ]);

                    if ($item) {
                        $res = $this->service->removeFromFavorite($userId, $feedId);
                        if ($res) {
                            return $this->successResponse('Post  Un-like successfully!');
                        }

                        return $this->parametersInvalidResponse('Error: post not removed from likes!');
                    }

                    $res = $this->service->addToFavorite($userId, $feedId);

                    if ($res) {
                        return $this->successResponse('Post  like successfully!');
                    }

                    return $this->parametersInvalidResponse('Error: post not added from Like!');
                }

                return $this->parametersInvalidResponse('No Post Found!');
            }

            return $this->parametersInvalidResponse();
        }

        return $this->unAuthorizedResponse();
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
                    $items->load('user', 'feed', 'feed.category')
                );
            }

            return $this->parametersInvalidResponse('No Items Found!');
        }

        return $this->unAuthorizedResponse();
    }


}
