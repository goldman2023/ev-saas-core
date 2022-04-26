<?php

namespace App\Http\Services;

use App\Models\Upload;
use Storage;
use Theme;

class IMGProxyService
{
    // TODO: Fix insecure links of the IMGProxy!!!

    protected $host;

    protected $enabled;

    protected $filesystem;

    protected $disks;

    protected $disk_types;

    protected $secure;

    protected $theme_path;

    public array $default_options;

    public function __construct($app)
    {
        $this->host = config('imgproxy.host');
        $this->enabled = ! empty($this->host) && config('imgproxy.enabled', false);
        $this->filesystem = config('filesystems.default');
        $this->disks = config('filesystems.disks');
        $this->disk_types = config('filesystems.disk_types');
        $this->secure = ! (config('app.env') === 'local');
        $this->theme_path = 'themes/'.Theme::parent();

        $this->default_options = [
            'thumbnail' => [
                'w' => 350,
            ],
            'cover' => [
                'w' => 820,
            ],
            'gallery' => [
                'w' => 500,
            ],
            'meta_img' => [
                'w' => 1200,
            ],
            'original' => [
                'w' => 0,
                'h' => 0,
            ],
        ];
    }

    public function isProxyEnabled()
    {
        return $this->enabled;
    }

    public function getProxyUrlTemplate(): string
    {
        if ($this->enabled) {
            return $this->host.'/insecure/fill/%w%/%h%/ce/0/plain/%url%@webp';
        }

        return '';
    }

    public function getDefaultIMGProxyOptions(): array
    {
        return $this->default_options;
    }

    public function getIMGProxyData()
    {
        return [
            'enabled' => $this->isProxyEnabled(),
            'url_template' => $this->getProxyUrlTemplate(),
            'default_options' => $this->getDefaultIMGProxyOptions(),
        ];
    }

    public function get($path, $options = [], $static = false)
    {
        return $this->proxify($this->getFrom($path, $static), $options, $static);
    }

    public function getPlaceholder($proxify = true): mixed
    {
        if (! $proxify) {
            return $this->getFrom($this->theme_path.'/images/photo-placeholder.jpg', true);
        }

        return $this->proxify($this->getFrom($this->theme_path.'/images/photo-placeholder.jpg', true), [], true);
    }

    public function mergeWithDefaultOptions($options = [], $default_target = 'thumbnail'): array
    {
        // TODO: merge recrusively so we don't omit some default parameters!
        return array_merge($this->default_options[in_array($default_target, $this->default_options, true) ? $default_target : 'thumbnail'], $options);
    }

    /**
     * Generate an asset path for the application.
     *
     * Notes:
     * If current app filesystem IS 'cloud' and (not static OR provided $data is Upload), use Storage facade to get the URL.
     * $data can be Upload model or string. If Upload, pass the $data->file_name, otherwise, pass the $data as a string
     * If filesystem IS NOT 'cloud', use ->asset() to get it from the local machine filesystem
     *
     * If $data is numeric (possible ID), try to find Upload by ID and if no Upload with that ID is present, show Placeholder
     * Otherwise, get Upload and pass it to Storage to get URL.
     *
     * @param Upload|string $data
     * @param bool $static
     * @return array
     */
    protected function getFrom(mixed $data, bool $static = false): array
    {
        if (empty($data)) {
            return $this->getPlaceholder(false);
        }

        if ((! $static || $data instanceof Upload) && in_array($this->filesystem, $this->disk_types['cloud'], true)) {
            if (is_numeric($data) && ! $data instanceof Upload) {
                try {
                    $data = Upload::findOrFail($data);
                } catch (\Exception $e) {
                    return $this->getPlaceholder(false);
                }
            }
            // dd(Storage::disk($this->filesystem)->url($data->file_name));
            $url = Storage::disk($this->filesystem)->url($data instanceof Upload ? ($data->file_name ?? null) : $data);
        } else {
            $url = app('url')->asset($data, $this->secure);
        }

        return [
            'static' => $static,
            'url' => $url,
        ];
    }

    /**
     * Generate an asset path for the application.
     *
     * Notes:
     * If current app filesystem IS 'cloud' and (not static OR provided $data is Upload), use Storage facade to get the URL.
     * $data can be Upload model or string. If Upload, pass the $data->file_name, otherwise, pass the $data as a string
     * If filesystem IS NOT 'cloud', use ->asset() to get it from the local machine filesystem
     *
     * @param ?array $data
     * @param ?array $options
     * @param bool $static
     * @return ?string
     */
    protected function proxify(array $data = null, ?array $options = [], bool $static = false): ?string
    {

        // Proxy images through IMGProxy only if 1) it's enabled and 2) asset is not static
        if ($this->enabled && ! $static) {
            $options['w'] = $options['w'] ?? 0;
            $options['h'] = $options['h'] ?? 0;

            // TODO: Static logic is made for local development. On production all images should be routed through IMGProxy!
            // The reason is because if we use images.we-saas.com domain as an IMGProxy server for used for routing all images, we cannot make route stuff from localhost because localhost is local dev. server!
            if (! ($data['static'] ?? false)) {
                $data['url'] = $this->host.'/insecure/fill/'.$options['w'].'/'.$options['h'].'/ce/0/plain/'.$data['url'].'@webp';
            }
        }

        return $data['url'];
    }
}
