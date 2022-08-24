<?php

namespace App\WeEngine\Loaders;

class DatabaseTwigLoader implements \Twig\Loader\LoaderInterface
{

    public function __construct()
    {

    }

    protected function splitName(string $name) {
        return explode('|', $name);
    }

    public function getSourceContext(string $name): \Twig\Source
    {
        list($model_class, $model_id) = $this->splitName($name);

        if (false === $source = $this->getValue($model_class, $model_id)) {
            throw new \Twig\Error\LoaderError(sprintf('Template "%s" does not exist.', $name));
        }

        return new \Twig\Source($source, $name);
    }

    public function exists(string $name)
    {
        list($model_class, $model_id) = $this->splitName($name);

        return $name === $this->getValue($model_class, $model_id);
    }

    public function getCacheKey(string $name): string
    {
        return $name;
    }

    public function isFresh(string $name, int $time): bool
    {
        list($model_class, $model_id) = $this->splitName($name);

        if (($lastModified = $this->getValueLastModified($model_class, $model_id)) === false) {
            return false;
        }

        return $lastModified <= $time;
    }

    protected function getValue($model_class, $model_id)
    {
        $model = app($model_class)->find($model_id);

        if(!empty($model)) {
            return $model?->content ?? '';
        }

        return false;
    }

    protected function getValueLastModified($model_class, $model_id) {
        $model = app($model_class)->find($model_id);

        if(!empty($model)) {
            return $model->updated_at->timestamp;
        }

        return false;
    }
}