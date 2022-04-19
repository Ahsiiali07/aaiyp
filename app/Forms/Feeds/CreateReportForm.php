<?php

namespace App\Forms\Feeds;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

/**
 * @property float $reason
 * @property integer $user_id
 * @property integer $feed_id
 * @property integer $detailed_reason
 */
class CreateReportForm extends BaseForm {


    /** @var $reason */
    public $reason;

    /** @var $detailed_reason */
    public $detailed_reason;

    /** @var $user_id */
    public $user_id;

    /** @var $feed_id */
    public $feed_id;

    /**
     * Convert Instance to Array
     * @return array
     */
    public function toArray(): array
    {
        return [
            'reason'          => $this->reason,
            'detailed_reason' => $this->detailed_reason,
            'user_id'         => $this->user_id,
            'feed_id'      => $this->feed_id,
        ];
    }

    /**
     * @return string[]
     */
    public function rules() {
        return [
            'reason'     => 'required',
            'user_id'    => 'required',
            'feed_id' => 'required',
        ];

    }
}
