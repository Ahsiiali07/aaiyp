<?php

namespace App\Forms\Users;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

/**
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string $password
 * @property string $password_confirmation
 * @property string $device_token
 * @property string $image
 * @property string $signup_otp
 * @property string $pin
 * @property int $user_type

 * @property boolean $is_verified
 *
 *
 */
class RegisterForm extends BaseForm {

    /** @var $email */
    public $email;

    /** @var $firstname */
    public $firstname;

    /** @var $lastname */
    public $lastname;

    /** @var $device_token */
    public $device_token;

    /** @var $user_type */
    public $user_type;

       /** @var $mobile */
    public $mobile;

      /** @var $image */
    public $image;
    
     /** @var $gender */
    public $gender;

    /** @var $password */
    public $password;

    /** @var $password_confirmation */
    public $password_confirmation;
    /**
     * Convert Instance to Array
     * @return array
     */
    public function toArray() {
        return [
            'firstname'           => $this->firstname,
            'lastname'           => $this->lastname,
            'email'                 => $this->email,
            'device_token'          => $this->device_token,
            'image'                 => $this ->image,
            'mobile'                => $this->mobile,
             'gender'                => $this->gender,
            'user_type'             => $this->user_type,
            'password'              => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];
    }

    /**
     * @return array
     */
    public function rules() {
        return [
            'email'                 => 'email|required|unique:users',
            'firstname'                  => 'required',
            'lastname'                  => 'required',
             'image'                => 'required',
            'password'              =>'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ];

    }
}
