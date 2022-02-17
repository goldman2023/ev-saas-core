<?php

namespace App\Enums;

class AttributeTypeEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'checkbox' => 'checkbox',
            'dropdown' => 'dropdown',
            'radio' => 'radio',
            'plain_text' => 'plain_text',
            'country' => 'country',
            'number' => 'number',
            'date' => 'date',
            'image' => 'image',
            'gallery' => 'gallery',
            'text_list' => 'text_list',
            'wysiwyg' => 'wysiwyg'
        ];
    }

    public static function labels(): array
    {
        return [
            'checkbox' => 'Checkbox',
            'dropdown' => 'Dropdown',
            'radio' => 'Radio',
            'plain_text' => 'Plain text',
            'country' => 'Country',
            'number' => 'Number',
            'date' => 'Date',
            'image' => 'Image',
            'gallery' => 'Gallery',
            'text_list' => 'Text list',
            'wysiwyg' => 'Wysiwyg',
        ];
    }

    public static function getPredefined() {
        return ['checkbox', 'dropdown', 'radio'];
    }
}
