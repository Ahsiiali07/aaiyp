<?php

namespace App\Forms\Category;

/**
 * @property string $name

 */
class CreateCategoryForm extends \App\Forms\BaseForm
{

    /* @var $name */
    public $name;

    // /* @var $description */
    // public $description;

    // /* @var $image_url */
    // public $image_url;

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
            // 'parent_category_id' => $this->parent_category_id,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name' => 'required',
            // 'image_url' => 'required',
            // 'description' => 'required',
        ];
    }
}
