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

            $group->item(trans('iprofile::profiles.plural'), function (Item $item) {
                $item->icon('fa fa-address-book-o');
                $item->weight(100);

                $item->item(trans('iprofile::profiles.list resource'), function (Item $item) {
                    $item->icon('fa fa-users');
                    $item->weight(0);
                    $item->append('admin.account.profile.index');
                    $item->route('admin.account.profile.index');
                    $item->authorize(
                        $this->auth->hasAccess('iprofile.profiles.index')
                    );
                });
               

                $item->item(trans('iprofile::profiles.bulkload.import'), function (Item $item) {
                    $item->icon('fa fa-upload');
                    $item->weight(0);
                    $item->append('admin.iprofile.bulkload.index');
                    $item->route('admin.iprofile.bulkload.index');
                    $item->authorize(
                        $this->auth->hasAccess('iprofile.bulkload.import')
                    );
                });

            });

           

        });

        return $menu;
    }
}
