<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $comment
 * @property int $feed_id
 * @property bool $status
 * @property int $user_id
 */
class FeedComment extends Model {
	use Notifiable, ModelHelper;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'comment',
		'feed_id',
		'user_id',
		'status'
	];


    /**
     * @return BelongsTo
     */
	public function user()
    {
		return $this->belongsTo( User::class );
	}

    /**
     * @return BelongsTo
     */
	public function feed()
    {
		return $this->belongsTo( Feeds::class , 'feed_id', 'id');
	}
}
