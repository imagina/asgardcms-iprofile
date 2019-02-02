<?php

namespace Modules\Iprofile\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIprofileSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('iprofile::profiles.title.profiles'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('iprofile.addresses.index') ||$this->auth->hasAccess('iprofile.user_fields.index')||$this->auth->hasAccess('iprofile.departments.index')
                );
                $item->item(trans('iprofile::profiles.list resource'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iprofile.profiles.create');
                    $item->route('admin.iprofile.profiles.index');
                    $item->authorize(
                        $this->auth->hasAccess('iprofile.user_fields.index')
                    );
                });
                $item->item(trans('iprofile::departments.title.departments'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iprofile.department.create');
                    $item->route('admin.iprofile.department.index');
                    $item->authorize(
                        $this->auth->hasAccess('iprofile.departments.index')
                    );
                });

// append



            });
        });

        return $menu;
    }
}
