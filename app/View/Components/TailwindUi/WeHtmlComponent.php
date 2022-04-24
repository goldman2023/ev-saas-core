<?php

namespace App\View\Components\TailwindUi;

use App\Enums\ResponsiveVisibilityEnum;
use App\Enums\UserVisibilityEnum;
use App\Facades\IMG;
use Illuminate\View\Component;

class WeHtmlComponent extends Component
{
    public $settings;

    public $weData;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($settings = [], $weData = [])
    {
        $this->settings = $settings;
        if ($settings == []) {
            $this->settings = $this->getDefaultSettings();
        }
        $this->weData = $weData;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.we-component');
    }

    public function getDefaultSettings()
    {
        return [
            'background' => [
                'type' => 'color', // color, image, video
                'color' => '#fff',
                'urls' => [
                    'mobile' => '',
                    'tablet' => '',
                    'desktop' => '',
                ],
                'position' => 'center',
            ],
            'spacing' => [
                'mobile' => [
                    'top' => '0',
                    'bottom' => '0',
                ],
                'tablet' => [
                    'top' => '0',
                    'bottom' => '0',
                ],
                'desktop' => [
                    'top' => '0',
                    'bottom' => '0',
                ],
            ],
            'extra_classes' => '',
            'user_visibility' => 'all', // all, guest, auth, subscriber, non_subscriber
            'responsive_visibility' => 'all', // all, Mobile (), Tablet portrait(sm), Tablet Landscape(md), Laptop(lg), Full Desktop(xl)
        ];
    }

    public function getSpacingClasses()
    {
        $spacing_classes = '';

        // Desktop
        if ($this->settings['spacing']['desktop']['top'] !== 0) {
            $spacing_classes .= ' lg:pt-['.$this->settings['spacing']['desktop']['top'].'px] ';
        }
        if ($this->settings['spacing']['desktop']['bottom'] !== 0) {
            $spacing_classes .= ' lg:pb-['.$this->settings['spacing']['desktop']['bottom'].'px] ';
        }

        // Tablet
        if ($this->settings['spacing']['tablet']['top'] !== 0) {
            $spacing_classes .= ' sm:pt-['.$this->settings['spacing']['tablet']['top'].'px] ';
        }
        if ($this->settings['spacing']['tablet']['bottom'] !== 0) {
            $spacing_classes .= ' sm:pb-['.$this->settings['spacing']['tablet']['bottom'].'px] ';
        }

        // Mobile
        if ($this->settings['spacing']['mobile']['top'] !== 0) {
            $spacing_classes .= ' pt-['.$this->settings['spacing']['mobile']['top'].'px] ';
        }
        if ($this->settings['spacing']['mobile']['bottom'] !== 0) {
            $spacing_classes .= ' pb-['.$this->settings['spacing']['mobile']['bottom'].'px] ';
        }

        return $spacing_classes;
    }

    public function getBackgroundClasses()
    {
        if ($this->settings['background']['type'] === 'color') {
            return ' bg-['.$this->settings['background']['color'].'] ';
        } elseif ($this->settings['background']['type'] === 'image') {
            return ' bg-[url(\''.IMG::get($this->settings['background']['urls']['desktop'], IMG::mergeWithDefaultOptions([], 'original')).'\')] bg-center bg-cover ';
        } elseif ($this->settings['background']['type'] === 'video') {
            // TODO: Add video support for background!
        }
    }

    public function getResponsiveVisibilityClasses()
    {
        if ($this->settings['responsive_visibility'] === ResponsiveVisibilityEnum::all()->value) {
            return '';
        } elseif ($this->settings['responsive_visibility'] === ResponsiveVisibilityEnum::mobile()->value) {
            return ' sm:hidden '; // show only on mobile
        } elseif ($this->settings['responsive_visibility'] === ResponsiveVisibilityEnum::tablet_portrait()->value) {
            return ' hidden sm:block ';
        } elseif ($this->settings['responsive_visibility'] === ResponsiveVisibilityEnum::tablet_landscape()->value) {
            return ' hidden md:block ';
        } elseif ($this->settings['responsive_visibility'] === ResponsiveVisibilityEnum::laptop()->value) {
            return ' hidden lg:block ';
        } elseif ($this->settings['responsive_visibility'] === ResponsiveVisibilityEnum::desktop()->value) {
            return ' hidden xl:block ';
        }
    }

    public function getSectionSettingsClasses()
    {
        return $this->getSpacingClasses().' '.$this->getBackgroundClasses().' '.$this->getResponsiveVisibilityClasses().' '.($this->settings['extra_classes'] ?? '');
    }
}
