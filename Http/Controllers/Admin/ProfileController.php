<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iprofile\Entities\UserField;
use Modules\Iprofile\Http\Requests\CreateUserFieldRequest;
use Modules\Iprofile\Http\Requests\UpdateUserFieldRequest;
use Modules\Iprofile\Repositories\UserFieldRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProfileController extends AdminBaseController
{
    /**
     * @var UserFieldRepository
     */
    private $userfield;
    private $user;
    private $role;

    public function __construct(UserFieldRepository $userfield, UserRepository $user, RoleRepository $role)
    {
        parent::__construct();

        $this->userfield = $userfield;
        $this->user=$user;
        $this->role=$role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user=$this->user->all();
        return view('iprofile::admin.users.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return view('iprofile::admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserFieldRequest $request
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {

        $this->user->createWithRoles($request, $request->roles, true);

        return redirect()->route('admin.iprofile.users.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iprofile::userfields.title.user')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserField $userfield
     * @return Response
     */
    public function edit($user_id)
    {
        $user=$this->user->find($user_id);
        return view('iprofile::admin.users.edit', compact('user'));
    }

    public function me($user_id)
    {
        $user=$this->auth->user();
        return view('iprofile::admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserField $userfield
     * @param  UpdateUserFieldRequest $request
     * @return Response
     */
    public function update($user_id, UpdateUserFieldRequest $request)
    {
        $this->user->updateAndSyncRoles($user_id, $request, $request->roles);

        return redirect()->route('admin.iprofile.users.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iprofile::userfields.title.user')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserField $userfield
     * @return Response
     */
    public function destroy($user_id)
    {
        $this->user->delete($user_id);

        return redirect()->route('admin.iprofile.users.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iprofile::userfields.title.user')]));
    }

    public function sendResetPassword($user, Authentication $auth)
    {
        $user = $this->user->find($user);
        $code = $auth->createReminderCode($user);

        event(new UserHasBegunResetProcess($user, $code));

        return redirect()->route('admin.user.users.edit', $user->id)
            ->withSuccess(trans('user::auth.reset password email was sent'));
    }
}
