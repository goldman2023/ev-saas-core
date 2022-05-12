<?php

namespace App\Enums;

/**
 * @method static self linkedin()
 * @method static self github()
 * @method static self twitter()
 * @method static self instagram()
 * @method static self behance()
 * @method static self dribble()
 * @method static self soundcloud()
 */
class AvailableSocialFieldsEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'linkedin' => 'linkedin',
            'github' => 'github',
            'facebook' => 'facebook',
            'twitter' => 'twitter',
            'instagram' => 'instagram',
            'behance' => 'behance',
            'dribble' => 'dribble',
            'soundcloud' => 'soundcloud',
        ];
    }

    public static function labels(): array
    {
        return [
            'linkedin' => 'Linkedin',
            'github' => 'Github',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'instagram' => 'Instagram',
            'behance' => 'Behance',
            'dribble' => 'Dribble',
            'soundcloud' => 'Soundcloud',
        ];
    }

    public static function icons() {
        return [
            'linkedin' => ['icon' => 'icomoon-linkedin', 'color' => '#0077b5'],
            'github' => ['icon' => 'icomoon-github', 'color' => ''],
            'facebook' => ['icon' => 'icomoon-facebook2', 'color' => '#4267B2'],
            'twitter' => ['icon' => 'icomoon-twitter', 'color' => '#1DA1F2'],
            'instagram' => ['icon' => 'icomoon-instagram', 'color' => '#C13584'],
            'behance' => ['icon' => 'icomoon-behance', 'color' => ''],
            'dribbble' => ['icon' => 'icomoon-dribbble', 'color' => '#ea4c89'],
            'soundcloud' => ['icon' => 'icomoon-soundcloud2', 'color' => '#ff7700'],
        ];
    }
}
