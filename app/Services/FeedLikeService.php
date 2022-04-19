<?php

namespace App\Services;

use App;
use App\Models\FeedLike;
use App\Traits\NotificationTrait;

/**
 * Class PostLikeService
 * @package App\Services
 */
class FeedLikeService extends BaseService {

	/**
	 * FavoriteService constructor.
	 */
	public function __construct() {
		$this->model = new FeedLike();

		parent::__construct();
	}

	/**
	 * @param $userId
	 *
	 * @return mixed
	 */
	public function getAllForUser( $userId ) {
		return $this->find( [
			'user_id' => $userId
		] );
	}

	/**
	 * @param $userId
	 * @param $feed_id
	 *
	 * @return bool
	 */
	public function addToFavorite( $userId, $feed_id ) {
		$item          = new FeedLike();
		$item->feed_id = $feed_id;
		$item->user_id = $userId;

		$res = $item->save();

		if ( $res ) {
			/** @var FeedsService $feedService */
			$feedService = App::make( FeedsService::class );
			$post        = $feedService->findById( $feed_id );
			NotificationTrait::sendNotification(
				$post->user,
				[
					'title'           => 'New Like on your post',
					'text'            => 'New Like on your post',
					'notification_id' => $feed_id
				],
				INotificationTypes::TYPE_FEED
			);
		}

		return $res;
	}

	/**
	 * @param $userId
	 * @param $feed_id
	 *
	 * @return mixed
	 */
	public function removeFromFavorite( $userId, $feed_id ) {
		$item = $this->findFirst( [
			'user_id' => $userId,
			'feed_id' => $feed_id
		] );
		if ( $item ) {
			return $item->delete();
		}

		return false;
	}
}
