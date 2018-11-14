<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Parser;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iprofile\Repositories\DepartmentRepository;
use Modules\Iprofile\Repositories\ProfileRepository;
use Modules\Iprofile\Transformers\ProfileTransformer;
use Modules\User\Contracts\Authentication;
use Modules\User\Repositories\UserRepository;

class ApiAuthController extends BasePublicController
{
    private $user;
    private $profile;
    private $department;

    public function __construct(
        ProfileRepository $profile,
        DepartmentRepository $department)
    {
        $this->profile = $profile;
        $this->department = $department;
    }


    /**
     * @param Request $request
     * [
     *    "client_id"     => 'your_client_id',
     *    "client_secret" => 'your_client_secret',
     *    "grant_type"    => 'password',
     *    "code"          => '*',
     * ]
     * @return mixed
     *
     */
    public function apiLogin(Request $request)
    {
        $credentials = [
            'email' => $request->input('username'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $role = $user->roles()->first();

            $this->apiLogout(); //Revoke all tokens from this user
            $token = $user->createToken('Laravel Password Grant Client');
            $profile = $this->profile->findByUserId($user->id);
            $departments = $user->departments()->orderBy('id')->get();

            $response = [
                'userToken' => 'Bearer ' . $token->accessToken,
                'expires_in' => time($token->token->expires_at),
                'userdata' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'permissions' => array_merge($user->permissions, $role->permissions),
                    'departments' => $departments,
                    'profile' => new ProfileTransformer($profile),
                    'default_route' => '/'
                ]
            ];

            return response($response, 200);
        } else {
            return response('User or Password invalid', 401);
        }
    }

    /**
     * Logout passport
     * @return response
     */
    public function apiLogout()
    {
        if (Auth::guard('api')) {
            //If need it, revoke only token from request
            /*$value = $request->bearerToken();
            $id = (new Parser())->parse($value)->getHeader('jti');
            $token = Auth::user()->tokens->find($id);
            $token->revoke();*/

            //Delete all tokens of this user
            $user = Auth::user();
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
        }

        return response('You have been successfully logged out!', 200);
    }

}
