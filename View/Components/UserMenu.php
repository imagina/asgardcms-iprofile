<?php

namespace Modules\Iprofile\View\Components\UserMenu;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UserMenu extends Component
{
    public $view;
    public $user;
    public $defaultView;
    public $params;
    public $showLabel;
    public $moduleLinks;
    public $id;
    protected $authApiController;

    public function __construct($layout = 'user-menu-layout-1', $showLabel = false, $id = "userMenuComponent", $params = [])
    {
        $this->defaultView = 'iprofile::frontend.components.user-menu.layouts.user-menu-layout-1.index';
        $this->view = isset($layout) ? 'iprofile::frontend.components.user-menu.layouts.'.$layout.'.index' : $this->defaultView;
        $this->authApiController = app("Modules\Iprofile\Http\Controllers\Api\AuthApiController");
        $this->showLabel = $showLabel;
        $modules = app('modules')->all();
        $this->moduleLinks = [];
        $locale = LaravelLocalization::setLocale() ?: \App::getLocale();
        foreach($modules as $name=>$module){
            $moduleLinksCfg = config('asgard.'.strtolower($name).'.config.userMenuLinks');
            if(!empty($moduleLinksCfg)){
                foreach($moduleLinksCfg as &$moduleLink){
                    $routeWithLocale = $locale.'.'.$moduleLink['routeName'];
                    if(Route::has($routeWithLocale))
                        $moduleLink['routeName'] = $routeWithLocale;
                    else if(!Route::has($moduleLink['routeName']))
                        $moduleLink['routeName'] = 'homepage';
                    $this->moduleLinks[] = $moduleLink;
                }
            }
        }
        $this->id = $id ?? "userMenuComponent";
    }

    private function makeParamsFunction(){

        return [
            "include" => $this->params["include"] ?? [],
            "take" => $this->params["take"] ?? 12,
            "page" => $this->params["page"] ?? false,
            "filter" => $this->params["filter"] ?? ["locale" => \App::getLocale()],
            "order" => $this->params["order"] ?? null,
        ];
    }

    public function render()
    {
        $this->user = null;
        if(\Auth::user()) {
            $user = $this->authApiController->me();
            $user = json_decode($user->getContent());
            $this->user['data'] = $user->data->userData;
        }

        return view($this->view);
    }
}
