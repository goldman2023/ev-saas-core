<?php

namespace App\Enums;

/**
 * @method static self checkbox()
 * @method static self dropdown()
 * @method static self radio()
 * @method static self plain_text()
 * @method static self country()
 * @method static self number()
 * @method static self date()
 * @method static self image()
 * @method static self gallery()
 * @method static self text_list()
 * @method static self wysiwyg()
 */
class AttributeTypeEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'checkbox' => 'checkbox',
            'dropdown' => 'dropdown',
            'toggle' => 'toggle',
            'radio' => 'radio',
            'plain_text' => 'plain_text',
            'country' => 'country',
            'number' => 'number',
            'date' => 'date',
            'image' => 'image',
            'gallery' => 'gallery',
            'text_list' => 'text_list',
            'wysiwyg' => 'wysiwyg',
        ];
    }

    public static function labels(): array
    {
        return [
            'checkbox' => 'Checkbox',
            'dropdown' => 'Dropdown',
            'toggle' => 'Toggle',
            'radio' => 'Radio',
            'plain_text' => 'Plain text',
            'country' => 'Country',
            'number' => 'Number',
            'date' => 'Date',
            'image' => 'Image', // TODO: This should be an Upload
            'gallery' => 'Gallery', // This should be n Uploads Collection
            'text_list' => 'Text list',
            'wysiwyg' => 'Wysiwyg',
        ];
    }

    public static function getPredefined()
    {
        return ['checkbox', 'dropdown', 'radio'];
    }

        
    /**
     * getSingles
     *
     * Gets all the types which can have only one attribute value
     * 
     * @return void
     */
    public static function getSingles() {
        return ['toggle', 'plain_text', 'number', 'date', 'radio', 'image', 'wysiwyg'];
    }
}
