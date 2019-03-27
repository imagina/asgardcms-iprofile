<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iprofile\Repositories\UserFieldRepository;
use Modules\Iprofile\Repositories\UserRepository;
use Modules\Iprofile\Transformers\FieldTrasnformer;
use Modules\Iprofile\Transformers\UserProfileTransformer;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Repositories\RoleRepository;
use Illuminate\Support\Carbon;


class ProfileController extends AdminBaseController
{
    /**
     * @var UserFieldRepository
     */

    private $user;
    private $role;
    private $userField;

    public function __construct(UserRepository $user, RoleRepository $role, UserFieldRepository $userField)
    {
        parent::__construct();

        $this->user = $user;
        $this->role = $role;
        $this->userField=$userField;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->user->all();
       // $user= $this->user->getItemsBy((object)['take'=>false,'filter'=>['field'=>['name'=>'type_request','value'=>'nuevo']],'include'=>[]]);

        return view('iprofile::admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $fields=json_decode(json_encode(new FieldTrasnformer(config('asgard.iprofile.config.fields'))));
        // dd($fields);
        return view('iprofile::admin.users.create',['fields'=>$fields]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
      dd($request->all());
        $this->user->createWithRoles($request->all(), $request->roles, true);

        return redirect()->route('admin.iprofile.profiles.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iprofile::userfields.title.user')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $user_id
     * @return Response
     */
    public function edit($user_id)
    {
        $user = json_decode(json_encode(new UserProfileTransformer($this->user->find($user_id))));
        $user2 = $this->user->find($user_id);
        $fields=json_decode(json_encode(new FieldTrasnformer(config('asgard.iprofile.config.fields'))));
        $trans  = 'iprofile::profiles.form';
      //  $fields2=config('asgard.iprofile.config.fields');

      //  dd($fields,$fields2);
        return view('iprofile::admin.users.edit', compact('user','fields','trans','user2'));
    }

    public function me()
    {
        $this->user->find($this->auth->user()->id);

        return view('iprofile::admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $user_id
     * @param Request $request
     * @return Response
     */
    public function update($user_id, Request $request)
    {
        $data = $request->all();
        if (isset($data['validate']) && $data['validate']) {
            $timeUpdate= config()->get('asgard.iprofile.config.time_update');
            $data['date_update']=\Carbon::now()->addday(1);
        }
        $user=$this->user->find($user_id);
        $this->user->update($user, $request->all());

        return redirect()->route('admin.iprofile.profiles.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iprofile::user.title.user')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user_id
     * @return Response
     */
    public function destroy($user_id)
    {
        $this->user->delete($user_id);

        return redirect()->route('admin.iprofile.users.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iprofile::profiles.title.user')]));
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
