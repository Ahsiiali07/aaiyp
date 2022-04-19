<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $feed_id
 * @property integer $user_id
 * @property string $reason
 * @property string $detailed_reason
 */
class FeedReport extends Model
{
    use Notifiable, ModelHelper;

    protected $table = 'report_feed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'feed_id',
        'user_id',
        'reason',
        'detailed_reason',
    ];

    /**
     * @return BelongsTo
     */
    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feeds::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
