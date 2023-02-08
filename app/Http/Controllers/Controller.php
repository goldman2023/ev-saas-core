<?php

namespace App\Http\Controllers;

use WeTheme;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ForwardsCalls;

    public function __call($method, $arguments) {
        $exploded_child_class = explode('\Controllers\\', get_class($this));
        $controller_basename = $exploded_child_class[1] ?? null;

        if(!empty($controller_basename)) {
            $theme_controller = WeTheme::getThemeController($controller_basename);

            if($theme_controller instanceof self) {
                return $this->forwardCallTo(
                    $theme_controller, $method, $arguments
                );
            }
        }

        try {
            return parent::__call($method, $arguments);
        } catch(\Exception $e) {
            abort(404);
        }
    }
}
