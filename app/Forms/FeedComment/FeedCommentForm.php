<?php

namespace App\Forms\FeedComment;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

/**
 * @property string $name
 * @property bool $status
 * @property int $user_id
 */
class FeedCommentForm extends BaseForm {

    /** @var $feed_id */
    public $feed_id;

    /** @var $status */
    public $status;

    /** @var $user_id */
    public $user_id;

    /** @var $comment */
    public $comment;

    /**
     * Convert Instance to Array
     * @return array
     */
    public function toArray() {
        return [
            'feed_id'       => $this->feed_id,
            'status'       => $this->status,
            'comment'       => $this->comment,
            'user_id'       => $this->user_id,
        ];
    }

    /**
     * @return mixed|string[]
     */
    public function rules() {
        return [
            'feed_id'  => 'required',
            'comment' => 'required',
            'user_id' => 'required',
        ];

    }
}
