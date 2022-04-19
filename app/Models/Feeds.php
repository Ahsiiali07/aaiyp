<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $title
 * @property string $description
 * @property string $media_url
 * @property integer $media_type
 * @property integer $category_id
 * @property integer $user_id
 */
class Feeds extends Model {
    use Notifiable, ModelHelper;

  protected $table ='feeds';

    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'description',
        'media_url',
        'media_type',
    ];

    /*
     * @appends created_since
     * @appends total_likes
     * @appends total_comments
     * @appends is_user_liked_feed
     * @appends is_mine_feed
     */
   protected $appends = [
      'created_since',
      
      'long_timestamp',
      
     'total_likes',
       'total_comments',
       'is_user_liked_feed',
       'is_mine_feed'
   ];
   
   

    /**
    * @var mixed
     */
    private $user;

	/**
	 * Get the idea's human-readable time.
	 *
	 * @return string
	 */
	public function getCreatedSinceAttribute()
	{
		return $this->created_at->diffForHumans();
	}

    /**
     * Get the feed long timestamp.
     *
     * @return string/
     *
     */
    public function getLongTimestampAttribute(): string
    {
        return Carbon::parse($this->created_at)->format('d-m-y H:i');
    }

 
    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function likes()
    {
        return $this->hasMany(FeedLike::class, 'feed_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(FeedComment::class, 'feed_id', 'id');
    }

   public function like()
    {
        if (auth()->id()) {
            return $this->hasMany(FeedLike::class,'feed_id', 'id')->where('user_id', auth()->id());
        }

        return null;
    }

    public function comment()
    {
        if (auth()->id()) {
            return $this->hasMany(FeedComment::class,'feed_id', 'id')->where('user_id', auth()->id());
        }

        return null;
    }

    /**
     * @return int
     */
    public function getTotalLikesAttribute(): int
    {
        return $this->likes()->count();
    }

    /**
     * @return int
     */
    public function getTotalCommentsAttribute(): int
    {
        return $this->comments()->count();
    }

    /**
     * @return bool
     */
    public function getIsUserLikedFeedAttribute(): bool
    {
        $like = $this->likes()->where('user_id', auth()->id())->get();
        if ($like->isEmpty()) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function getIsMineFeedAttribute(): bool
    {
        $postUser = $this->user;
        if ($postUser && $postUser->id == auth()->id()) {
            return true;
        }

        return false;
    }


    public function reportfeed(): HasMany
    {
        return $this->hasMany(FeedReport::class);
    }


}
