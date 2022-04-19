<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $title
 * @property string $description
 * @property string $image_url
 */
class AdminFeed extends Model
{



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image_url',
    ];

//    /**
//     * @return HasMany
//     */
//    public function sub_categories(): HasMany
//    {
//        return $this->hasMany(Category::class, 'parent_category_id');
//    }
//
//    /**
//     * @return BelongsTo
//     */
//    public function parent_category(): BelongsTo
//    {
//        return $this->belongsTo(Category::class, 'parent_category_id');
//    }
//
//    /**
//     * @return HasMany
//     */
//    public function news(): HasMany
//    {
//        return $this->hasMany(News::class);
//    }
//
//
//    /**
//     * @return HasMany
//     */
//    public function products(): HasMany
//    {
//        return $this->hasMany(Product::class, 'category_id');
//    }
}
