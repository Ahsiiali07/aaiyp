<?php

namespace App\Forms\FeedComment;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

/**
 * @property string $comment
 */
class UpdateFeedCommentForm extends BaseForm {

    /** @var $comment */
    public $comment;

    /**
     * Convert Instance to Array
     * @return array
     */
    public function toArray() {
        return [
            'comment'       => $this->comment,
        ];
    }

    /**
     * @return mixed|string[]
     */
    public function rules() {
        return [
            'comment' => 'required',
        ];

    }
}
