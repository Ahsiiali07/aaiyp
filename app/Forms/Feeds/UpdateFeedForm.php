<?php

namespace App\Forms\Feeds;

use App\Forms\BaseForm;

/**
 * @property string $title
 * @property string $description
 * @property int $category_id
 */
class UpdateFeedForm extends BaseForm
{

    /** @var $title */
    public $title;

    /** @var $description */
    public $description;

    /** @var $image_url */
    public $image_url;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->image_url,
        ];
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'image_url' => 'required',
        ];
    }
}
