<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $name
 * @property string $image_url
 */
class Category extends Model {

    use Notifiable, ModelHelper;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        // 'description',
        // 'image_url',
        // 'parent_category_id',
    ];

    /**
     * @return HasMany
     */
    public function sub_categories(): HasMany {
        return $this->hasMany( __CLASS__, 'parent_category_id' );
    }

    /**
     * @return BelongsTo
     */
    public function parent_category(): BelongsTo {
        return $this->belongsTo( __CLASS__, 'parent_category_id' );
    }



    /**
     * @return HasMany
     */
    public function feed(): HasMany
    {
        return $this->hasMany(Feeds::class);
    }

    /**
     * @return HasMany
     */
    public function group(): HasMany
    {
        return $this->hasMany(Group::class);
    }


}
