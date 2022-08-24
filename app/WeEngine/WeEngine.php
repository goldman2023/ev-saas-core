<?php

namespace App\WeEngine;

use App\WeEngine\Loaders\DatabaseTwigLoader;

class WeEngine
{
    protected $loader = null;
    protected $twig = null;
    protected $sandbox = null;


    public function __construct($app)
    {
        $this->loader = new DatabaseTwigLoader();
        $this->twig = new \Twig\Environment($this->loader);
        $this->setTwigSandbox();   
    }

    public function twig() {
        return $this->twig;
    }

    protected function setTwigSandbox() {
        $tags = ['if', 'for', 'do', 'apply', 'set', 'verbatim'];
        $filters = ['date', 'length', 'escape', 'upper', 'url_encode', 'sort', 'filter', 'slice', 'title'];
        $methods = [];
        $properties = [];
        $functions = ['range', 'dump', 'absolute_url'];

        $policy = new \Twig\Sandbox\SecurityPolicy($tags, $filters, $methods, $properties, $functions);

        $this->sandbox = new \Twig\Extension\SandboxExtension($policy, true);
        $this->twig->addExtension($this->sandbox);

    }
}
