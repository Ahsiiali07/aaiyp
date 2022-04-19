<?php

namespace App\Forms\Admin;

use App\Forms\BaseForm;

/**
 * @property string $title
 * @property string $description
 * @property int $category_id
 */
class CreateAdminFeedForm extends BaseForm
{

    /** @var $title */
    public $title;

    /** @var $description */
    public $description;

    /** @var $video_url */
    public $video_url;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'video_url' => $this->video_url,
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
            'video_url' => 'required',
        ];
    }
}
