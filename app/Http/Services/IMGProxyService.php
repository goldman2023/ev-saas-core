<?php

namespace App\Http\Services;

use App\Models\Upload;
use Storage;
use Theme;

class IMGProxyService
{
    protected $host;
    protected $enabled;
    protected $filesystem;
    protected $disks;
    protected $disk_types;
    protected $secure;
    protected $theme_path;


    public function __construct($app) {
        $this->host = config('imgproxy.host');
        $this->enabled = !empty($this->host) ? config('imgproxy.enabled', false) : false;
        $this->filesystem = config('filesystems.default');
        $this->disks = config('filesystems.disks');
        $this->disk_types = config('filesystems.disk_types');
        $this->secure = !(config('app.env') === 'local');
        $this->theme_path = 'themes/' . Theme::parent();
    }

    public function get($path, $options = [], $static = false) {
        return $this->proxify($this->getFrom($path, $static), $options, $static);
    }

    public function getPlaceholder(): string {
        return $this->proxify($this->getFrom($this->theme_path.'/images/photo-placeholder.jpg', true), [], true);
    }

    /**
     * Generate an asset path for the application.
     *
     * Notes:
     * If current app filesystem IS 'cloud' and (not static OR provided $data is Upload), use Storage facade to get the URL.
     * $data can be Upload model or string. If Upload, pass the $data->file_name, otherwise, pass the $data as a string
     * If filesystem IS NOT 'cloud', use ->asset() to get it from the local machine filesystem
     *
     * @param Upload|string $data
     * @param bool $static
     * @return string
     */
    protected function getFrom(mixed $data, bool $static = false): string
    {
        if(empty($data)) {
            return $this->getPlaceholder();
        }

        if ((!$static || $data instanceof Upload) && in_array($this->filesystem, $this->disk_types['cloud'], true)) {
            $url = Storage::disk($this->filesystem)->url($data instanceof Upload ? ($data->file_name ?? null) : $data);
        } else {
            $url = app('url')->asset($data, $this->secure);
        }

        return !empty($url) ? $url : $this->getPlaceholder();
    }

    /**
     * Generate an asset path for the application.
     *
     * Notes:
     * If current app filesystem IS 'cloud' and (not static OR provided $data is Upload), use Storage facade to get the URL.
     * $data can be Upload model or string. If Upload, pass the $data->file_name, otherwise, pass the $data as a string
     * If filesystem IS NOT 'cloud', use ->asset() to get it from the local machine filesystem
     *
     * @param ?string $url
     * @param ?array $options
     * @param bool $static
     * @return string
     */
    protected function proxify(string $url = null, ?array $options = [], bool $static = false) {
        // Proxy images through IMGProxy only if 1) it's enabled and 2) asset is not static
        if($this->enabled && !$static) {
            $options['w'] = $options['w'] ?? 0;
            $options['h'] = $options['h'] ?? 0;

            $url = $this->host.'/insecure/fill/'.$options['w'].'/'.$options['h'].'/ce/0/plain/'.$url.'@webp';
        }

        return $url;
    }
}
