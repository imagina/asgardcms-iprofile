<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\User\Repositories\UserRepository;
use Modules\User\Contracts\Authentication;
use Illuminate\Support\Facades\Auth;
use Modules\Iprofile\Repositories\DepartmentRepository;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Parser;
use Illuminate\Http\Request;

class AuthApiController extends BasePublicController
{
  private $user;

  private $department;
  
  public function __construct(
    DepartmentRepository $department)
  {
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
  public function login(Request $request)
  {
    $credentials = [
      'email' => $request->input('username'),
      'password' => $request->input('password')
    ];
    
    if (Auth::attempt($credentials)) {
      $user = Auth::user();
      $role = $user->roles()->first();
      
     // $this->logout($request); //Revoke all tokens from this user
      $token = $user->createToken('Laravel Password Grant Client');
      $departments ='';
      $defaultRoute ='/';
      $response = [
        'userToken' => 'Bearer '.$token->accessToken,
        'expires_in' => time($token->token->expires_at),
        'userdata' => [
          'id' => $user->id,
          'email' => $user->email,
          'first_name' => $user->first_name,
          'last_name' => $user->last_name,
          'permissions' => $user->permissions ? array_merge($user->permissions, $role->permissions) : $role->permissions,
          'departments' => $departments,
          'default_route' => $defaultRoute ?? '/',
        ]
      ];
      
      return response($response, 200);
    } else {
      return response('User or Password invalid', 401);
    }
  }
  
  /**
   * Logout passport
   * @param Request $request
   * Logout user request
   */
  public function logout(Request $request)
  {
    if(Auth::guard('api')){
      //If need it, revoke only token from request
      /*$value = $request->bearerToken();
      $id = (new Parser())->parse($value)->getHeader('jti');
      $token = Auth::user()->tokens->find($id);
      $token->revoke();*/
      
      //Delete all tokens of this user
      $user = Auth::user();
      DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();
    }
    
    return response('You have been successfully logged out!', 200);
  }
  
}
