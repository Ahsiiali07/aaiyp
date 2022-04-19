<?php

namespace App\Forms\Groups;
/**
 * @property string $name
 * @property string $image_url
 * @property string $old_image_url
 * @property int $category_id
 */
class UpdateGroupForm extends \App\Forms\BaseForm
{
    /* @var $name */
    public $name;

    /* @var $description */
    public $description;

    /* @var $image_url */
    public $image_url;

    /* @var $old_image_url */
    public $old_image_url;

    /* @var $category_id */
    public $category_id;



    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'old_image_url' => $this->old_image_url,
            'category_id' => $this->category_id,

        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [


        ];
    }
}
