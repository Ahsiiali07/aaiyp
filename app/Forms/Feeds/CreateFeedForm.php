<?php

namespace App\Forms\Feeds;

use App\Forms\BaseForm;

/**
 * @property string $title
 * @property string $description
 * @property int $category_id
 */
class CreateFeedForm extends BaseForm
{

    /* @var $title */
    public $title;

    /* @var $description */
    public $description;

    /** @var $media_url */
    public $media_url;

    /** @var $media_type */
    public $media_type;

    /* @var $category_id */
    public $category_id;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'media_url'   => $this->media_url,
            'media_type'  => $this->media_type,
            'category_id' => $this->category_id,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ];
    }
}
