<?php

namespace App\Forms\Category;
/**
 * @property string $name
 * @property string $image_url
 * @property string $old_image_url
 * @property int $parent_category_id
 */
class UpdateCategoryForm extends \App\Forms\BaseForm
{
    /* @var $name */
    public $name;

    // /* @var $description */
    // public $description;

    // /* @var $image_url */
    // public $image_url;

    // /* @var $old_image_url */
    // public $old_image_url;

    // /* @var $parent_category_id */
    // public $parent_category_id;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            // 'description' => $this->description,
            // 'image_url' => $this->image_url,
            // 'old_image_url' => $this->old_image_url,
            // 'parent_category_id' => $this->parent_category_id,
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
