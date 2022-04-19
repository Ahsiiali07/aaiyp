<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string $password
 * @property string $password_confirmation
 * @property string $device_token
 * @property string $signup_otp
 * @property string $pin
 * @property int $user_type
 * @property string $mobile
 * @property string $address
 * @property string $image
 * @property int $is_verified
 * @property int $is_approved
 * @property string $city
 * @property string $country
 * @property int $status
 *
 */
class User extends Authenticatable {
    use HasApiTokens, Notifiable, ModelHelper, Billable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'firstname',
        'lastname',
        'mobile',
        'gender',
        // 'address',
        'user_type',
        'image',
        'device_token',
        'is_verified',
        'is_approved',
        'status',
        'social_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pin',
        'password',
        'signup_otp',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'is_verified' => 'boolean',
        'status'      => 'boolean',
    ];
    /**
     * @var bool|mixed
     */
    private $is_approved;



    /**
     * @return HasMany
     */
    public function favorites(): HasMany
    {
        return $this->hasMany( Favorite::class );
    }





}
