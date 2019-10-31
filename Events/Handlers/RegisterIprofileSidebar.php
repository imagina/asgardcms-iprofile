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
        /* $group->item(trans('iprofile::iprofiles.title.iprofiles'), function (Item $item) {
        $item->icon('fa fa-copy');
        $item->weight(10);
        $item->authorize(
            $this->auth->hasAccess('iprofile.fields.index') || $this->auth->hasAccess('iprofile.departments.index')
        );
        $item->item(trans('iprofile::fields.title.fields'), function (Item $item) {
          $item->icon('fa fa-copy');
          $item->weight(0);
          $item->append('admin.iprofile.field.create');
          $item->route('admin.iprofile.field.index');
          $item->authorize(
            $this->auth->hasAccess('iprofile.fields.index')
          );
        });
        $item->item(trans('iprofile::addresses.title.addresses'), function (Item $item) {
          $item->icon('fa fa-copy');
          $item->weight(0);
          $item->append('admin.iprofile.address.create');
          $item->route('admin.iprofile.address.index');
          $item->authorize(
            $this->auth->hasAccess('iprofile.addresses.index')
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
        $item->item(trans('iprofile::settings.title.settings'), function (Item $item) {
          $item->icon('fa fa-copy');
          $item->weight(0);
          $item->append('admin.iprofile.setting.create');
          $item->route('admin.iprofile.setting.index');
          $item->authorize(
            $this->auth->hasAccess('iprofile.settings.index')
          );
        });
        $item->item(trans('iprofile::userdepartments.title.userdepartments'), function (Item $item) {
          $item->icon('fa fa-copy');
          $item->weight(0);
          $item->append('admin.iprofile.userdepartment.create');
          $item->route('admin.iprofile.userdepartment.index');
          $item->authorize(
            $this->auth->hasAccess('iprofile.userdepartments.index')
          );
        });
        $item->item(trans('iprofile::roleapis.title.roleapis'), function (Item $item) {
          $item->icon('fa fa-copy');
          $item->weight(0);
          $item->append('admin.iprofile.roleapi.create');
          $item->route('admin.iprofile.roleapi.index');
          $item->authorize(
            $this->auth->hasAccess('iprofile.roleapis.index')
          );
        });
        $item->item(trans('iprofile::userapis.title.userapis'), function (Item $item) {
          $item->icon('fa fa-copy');
          $item->weight(0);
          $item->append('admin.iprofile.userapi.create');
          $item->route('admin.iprofile.userapi.index');
          $item->authorize(
            $this->auth->hasAccess('iprofile.userapis.index')
          );
        });
      });*/
    });

    return $menu;
  }
}
