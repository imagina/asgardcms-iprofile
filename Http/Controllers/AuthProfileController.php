<?php

namespace Modules\Iprofile\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iprofile\Entities\UserField;
use Modules\Iprofile\Repositories\UserRepository;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Modules\User\Http\Requests\ResetRequest;
use Modules\User\Http\Controllers\AuthController;
use Modules\User\Repositories\RoleRepository;
use Socialite;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\MessageBag;

use Modules\Iprofile\Http\Requests\LoginRequestProfile;


class AuthProfileController extends AuthController

{
    private $user;
    /**
     * @var RoleRepository
     */
    private $role;
    private $errors;

    public function __construct( MessageBag $errors, UserRepository $user, RoleRepository $role)
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
        $this->errors= $errors;
    }

    public function getLogin()
    {

        $tpl = 'iprofile::frontend.login';
        $ttpl = 'iprofile.login';
        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl);
    }

    public function postLogin(LoginRequest $request)
    {

        parent::postLogin($request);
        return redirect()->intended(route(config('asgard.user.config.redirect_route_after_login')))
            ->withSuccess(trans('user::messages.successfully logged in'));

    }

    public function getRegister()

    {
        parent::getRegister();

        $tpl = 'iprofile::frontend.register';
        $ttpl = 'iprofile.register';
        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl);

    }

    public function userRegister(RegisterRequest $request)
    {

        if (array_key_exists('g-recaptcha-response', $request->all())) {

            $validator = \Validator::make($request->all(), [
                'g-recaptcha-response' => 'required|captcha'
            ]);
            if ($validator->fails()) {
                $this->errors->add('g-recaptcha', trans('iforms::common.captcha_required'));
                return redirect()->route('account.register')
                    ->withErrors($this->errors)->withInput($request->except('password','password_confirmation'));
            }

        }
        $roleCustomer = $this->role->findByName('Customers');
        $user = User::where("email", $request->email)->first();

        if(isset($user->email) && !empty($user->email)){
            if($user->roles()->first()->slug=='user') {
                $this->user->update($user, $request->all());
                $user->roles()->sync($roleCustomer->id);
                $code = $this->auth->createActivation($user);
                $this->auth->activate($user->id,$code);
                $this->createProfile($request,$user);
                return redirect()->route('account.register')
                    ->withSuccess(trans('user::messages.account created check email for activation'));
            }else {
                return redirect()->route('account.register')
                    ->withErrors(trans('user::messages.account created check email for activation'));

            }
        }else{
            $user = $this->user->createWithRolesFromCli($request->all(), $roleCustomer, true);
            $this->createProfile($request,$user);

            return redirect()->route('account.register')
                ->withSuccess(trans('user::messages.account created check email for activation'));
        }

    }


    public function getLogout()

    {
        parent::getLogout();
        return \Redirect::to('/');
    }

    public function getActivate($userId, $code)

    {
        if ($this->auth->activate($userId, $code)) {
            return redirect()->route('account.login')
                ->withSuccess(trans('user::messages.account activated you can now login'));
        }
        return redirect()->route('account.register')
            ->withError(trans('user::messages.there was an error with the activation'));

    }

    public function getReset()

    {
        $tpl = 'iprofile::frontend.reset.begin';
        $ttpl = 'iprofile.reset.begin';
        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl);
    }

    public function postReset(ResetRequest $request)

    {
        parent::postReset($request);

        return redirect()->route('account.reset')
            ->withSuccess(trans('user::messages.check email to reset password'));

    }

    public function getResetComplete()

    {

        $tpl = 'iprofile::frontend.reset.complete';
        $ttpl = 'iprofile.reset.complete';
        if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl);

        //return view('user::public.reset.complete');

    }

    public function postResetComplete($userId, $code, ResetCompleteRequest $request)

    {
        parent::postResetComplete($userId, $code, $request);

        return redirect()->route('account.login')
            ->withSuccess(trans('user::messages.password reset'));
    }

    public function getSocialAuth($provider = null, Request $request)
    {

        if(!empty($request->query('redirect'))) {
            \Session::put('redirect',$request->query('redirect'));
        }


        if (!config("services.$provider")) {
            return '';// abort('404');
        }

        if ($provider == 'facebook') {
            return Socialite::driver($provider)->scopes(['user_friends'])->redirect();
        }

        return Socialite::driver($provider)->redirect();
    }


    function _createOrGetUser($provider, $fields = array())
    {

        $providerUser = Socialite::driver($provider)->stateless(true)->fields($fields)->user();

        $provideraccount = $this->provideraccount->whereProvider($provider)->whereProviderUserId($providerUser->getId())
            ->first();


        //If user for this social login exists update short token and return the user associated
        if (isset($provideraccount->user)) {

            $updateoptions = $provideraccount->options;
            $updateoptions["short_token"] = $providerUser->token;
            $provideraccount->options = $updateoptions;
            $provideraccount->save();

            return $provideraccount->user;

            //New social login or user
        } else {

            $userdata['email'] = $providerUser->getEmail();
            $userdata['password'] = str_random(8);


            if ($provider == 'facebook') {
                //$social_picture = $providerUser->user['picture']['data'];
                $userdata['first_name'] = $providerUser->user['first_name'];
                $userdata['last_name'] = $providerUser->user['last_name'];
                $userdata["verified"] = $providerUser->user["verified"];




            } else {
                $fullname = explode(" ", $providerUser->getName());
                $userdata['first_name'] = $fullname[0];
                $userdata['last_name'] = $fullname[1];
                $userdata["verified"] = true;
            }

            //Let's create the User
            $role = $this->role->findByName(config('asgard.user.config.default_role', 'User'));

            if ($userdata["verified"]) {
                $user = $this->user->createWithRoles($userdata, $role, true);
            } else {
                $user = $this->user->createWithRoles($userdata, $role);
            }


            if (isset($user->email) && !empty($user->email)) {

                //Let's associate the Social Login with this user
                $provideraccount = new ProviderAccount();
                $provideraccount->provider_user_id = $providerUser->getId();
                $provideraccount->user_id = $user->id;
                $provideraccount->provider = $provider;
                $provideraccount->options = ['short_token'=>$providerUser->token];
                $provideraccount->save();

                //Let's create the Profile for this user

                $social_picture = $providerUser->getAvatar();

                //$image = \Image::make($social_picture['url']);
                $image = \Image::make($social_picture);
                $destination_path = 'assets/iprofiles/profile/' . $user->id . '.jpg';
                Storage::disk('publicmedia')->put($destination_path, $image->stream('jpg', '80'));
                $profile = new UserField() ;
                $profile->user_id = $user->id;
                $profile->name = 'mainimage';
                $profile->plain_value= $destination_path;
                $profile->type= 'image';
                $profile->save();

            } else {
                return null;
            }


            return $user;
        }

    }


    public function getSocialAuthCallback($provider = null)
    {
        if (!config("services.$provider")) {
            return abort('404');
        } else {
            $fields = array();

            $redirect = \Session::get('redirect','');
            \Session::put('redirect','');


            if ($provider == 'facebook') {
                $fields = ['first_name', 'last_name', 'picture.width(1920).redirect(false)', 'email', 'gender', 'birthday', 'address', 'about', 'link', 'verified'];
            }

            try {

                $user = $this->_createOrGetUser($provider, $fields);


                if (isset($user->id)) {
                    \Sentinel::login($user);

                    if(!empty($redirect)) return redirect($redirect);

                    return redirect()->route('account.profile.index')
                        ->withSuccess(trans('iprofile::messages.account created'));

                } else {
                    return redirect()->back()->with(trans('user::messages.error create account'));;
                }


            } catch(\Exception $e) {
                \Log::info($e->getMessage());

                return redirect($redirect)->withError($e->getMessage());
            }




        }


    }
}