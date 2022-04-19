<?php

namespace App\Forms\ReportedFeed;
/**
 * @property string $reason
 * @property string $detailed_reason
 * @property string $user_id
 * @property string $feed_id
 */
class CreateReportedFeedForm extends \App\Forms\BaseForm
{
    /* @var $reason */
    public $reason;

    /* @var $detailed_reason */
    public $detailed_reason;

    /* @var $user_id */
    public $user_id;

    /* @var $feed_id */
    public $feed_id;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'reason' => $this->reason,
            'detailed_reason' => $this->detailed_reason,
            'user_id' => $this->user_id,
            'feed_id' => $this->feed_id,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'reason' => 'required',
            'detailed_reason' => 'required',
            'user_id'  => 'required',
            'feed_id'  => 'required',
        ];
    }
}
