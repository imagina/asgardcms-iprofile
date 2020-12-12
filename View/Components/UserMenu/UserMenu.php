<?php

namespace Modules\Iprofile\View\Components\UserMenu;

use Illuminate\View\Component;

class UserMenu extends Component
{
    public $view;
    public $user;
    public $defaultView;
    public $params;
    public $moreOptions;
    public $showLabel;
    public $componentId;
    protected $authApiController;

    public function __construct($layout = 'user-menu-layout-1', $showLabel = false, $componentId = "userMenuComponent", $moreOptions = [], $params = [])
    {
        $this->defaultView = 'iprofile::frontend.components.user-menu.layouts.user-menu-layout-1.index';
        $this->view = isset($layout) ? 'iprofile::frontend.components.user-menu.layouts.'.$layout.'.index' : $this->defaultView;
        $this->authApiController = app("Modules\Iprofile\Http\Controllers\Api\AuthApiController");
        $this->showLabel = $showLabel;
        $this->moreOptions = $moreOptions;
        $this->componentId = $componentId ?? "userMenuComponent";
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
