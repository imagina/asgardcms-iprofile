<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iprofile\Events\ImpersonateEvent;

//Controllers

class AuthApiController extends BaseApiController
{
  private $userApiController;
  private $fieldApiController;

  public function __construct(
    UserApiController $userApiController,
    FieldApiController $fieldApiController)
  {
    parent::__construct();
    $this->userApiController = $userApiController;
    $this->fieldApiController = $fieldApiController;
    $this->clearTokens();//CLear tokens
  }

  //Login User
  public function login(Request $request)
  {
    try {
      $credentials = [ //Get credentials
        'email' => $request->input('username'),
        'password' => $request->input('password')
      ];

      //Auth attemp and get token
      $token = $this->validateResponseApi($this->authAttempt($credentials));
      $user = $this->validateResponseApi($this->me());//Get user Data

      $response = ["data" => [
        'userToken' => $token->bearer,
        'expiresIn' => $token->expiresDate,
        'userData' => $user->userData
      ]];//Response
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  //auth attempt by email or username
  public function authAttempt($credentials)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      $credentials = (object)$credentials;

      try {
        //Find email in users fields
        $field = $this->validateResponseApi(
          $this->fieldApiController->show(
            json_encode($credentials->email),
            new Request([
              'filter' => json_encode(['field' => 'value']),
              'include' => 'user'
            ])
          )
        );

        //If exist email in users fields, change email of credentials
        if (isset($field->user)) $credentials->email = $field->user->email;
      } catch (\Exception $e) {
      }

      //Try login
      if (Auth::attempt((array)$credentials)) {
        $user = Auth::user();//Get user
        $token = $this->getToken($user);//Get token

        //Response bearer and expires date
        $response = ["data" => [
          "bearer" => 'Bearer ' . $token->accessToken,
          "expiresDate" => $token->token->expires_at,
        ]];
      } else {
        throw new \Exception('User or Password invalid', 401);
      }

      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
      if ($e->getMessage() === 'Your account has not been activated yet.') $status = 401;
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  //Return user data of current user
  public function me()
  {
    try {
      $user = Auth::user();//Get user loged

      //Find user with relationships
      $userData = $this->validateResponseApi(
        $this->userApiController->show($user->id, new Request([
            'include' => 'fields,departments,addresses,settings,roles']
        ))
      );

      //Response
      $response = ["data" => [
        'userData' => $userData
      ]];
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  //Logout user
  public function logout(Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      $token = $this->validateResponseApi($this->getRequestToken($request));//Get Token
      DB::table('oauth_access_tokens')->where('id', $token->id)->delete();//Delete Token
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "You have been successfully logged out!"], $status ?? 200);
  }

  //Logout all user sessions
  public function logoutAllSessions(Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      $userId = $request->input('userId');//Get user ID form request
      if (isset($userId)) {
        //Delete all tokens of this user
        DB::table('oauth_access_tokens')->where('user_id', $userId)->delete();
        \DB::commit();//Commit to DataBase
      }
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "You have been successfully logged out!"], $status ?? 200);
  }

  // Impersonate user
  public function impersonate(Request $request)
  {
    try {
      //Get Token
      $this->validateResponseApi($this->getRequestToken($request));

      $userId = $request->input('userId');//GEt user id impersonator
      $userIdToImpersonate = $request->input('userIdImpersonate');//Get user ID to impersonate

      Auth::loginUsingId($userId);//Loged impersonator
      $params = $this->getParamsRequest($request);//Get params

      //Check permissions of impersonator and settings to impersonate
      if (isset($params->permissions['profile.user.impersonate']) && $params->permissions['profile.user.impersonate']) {
        //Emit event impersonate
        event(new ImpersonateEvent($userIdToImpersonate, $request->ip()));

        Auth::logout();//logout impersonator
        $userImpersonate = Auth::loginUsingId($userIdToImpersonate);//Loged impersonator
        $token = $this->getToken($userImpersonate);//Get Token
        $user = $this->validateResponseApi($this->me());//Get user Data

        //Response
        $response = ["data" => [
          "userToken" => 'Bearer ' . $token->accessToken,
          'expiresIn' => $token->token->expires_at,
          'userData' => $user->userData
        ]];
      } else throw new \Exception('Unauthorized', 403);
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  //Refresh user Token
  public function refreshToken(Request $request)
  {
    try {
      //Get Token
      $token = $this->validateResponseApi($this->getRequestToken($request));
      $expiresIn = now()->addMinutes(1440);

      //Add 15 minutos to token
      DB::table('oauth_access_tokens')->where('id', $token->id)->update([
        'updated_at' => now(),
        'expires_at' => $expiresIn
      ]);

      $response = ['data' => ['expiresIn' => $expiresIn]];
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }



  /*======== Private Methods ========*/
  //Return token from request
  private function getRequestToken($request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      $value = $request->bearerToken();//Get from request
      if ($value) {
        $id = (new Parser())->parse($value)->getHeader('jti');//Decode and get ID
        $token = \DB::table('oauth_access_tokens')->where('id', $id)->first();//Find data Token
        $success = true;//Default state

        //Validate if exist token
        if (!isset($token)) $success = false;

        //Validate if is revoked
        if (isset($token) && (int)$token->revoked >= 1) $success = false;

        //Validate if Token expirated
        if (isset($token) && (strtotime(now()) >= strtotime($token->expires_at))) $success = false;

        //Revoke Token if is invalid
        if (!$success) {
          if (isset($token)) $token->delete();//Delete token
          throw new \Exception('Unauthorized', 401);//Throw unautorize
        }

        $response = ['data' => $token];//Response Token ID decode
        \DB::commit();//Commit to DataBase
      } else throw new \Exception('Unauthorized', 401);//Throw unautorize
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }

  // Delete invalid tokens
  private function clearTokens()
  {
    //Delete all tokens expirateds or revoked
    DB::table('oauth_access_tokens')->where('expires_at', '<=', now())
      ->orWhere('revoked', 1)
      ->delete();
  }

  //Create and return Token
  private function getToken($user)
  {
    if (isset($user))
      return $user->createToken('Laravel Password Grant Client');
    else return false;
  }
}
