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
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Services\UserRegistration;

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
    }

    /**
     * Login User
     *
     * @param Request $request
     */
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

            //Response
            $response = ["data" => [
                'userToken' => $token->bearer,
                'expires_in' => time($token->expiresDate),
                'userData' => $user->userData
            ]];
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    public function register(Request $request)
    {
        try {
            $data = $request->input('attributes');
            //Validate Request
            $this->validateRequestApi(new RegisterRequest ($data));
           $user= app(UserRegistration::class)->register($data);
            $data["departments"]=[1];
            if (isset($data["departments"]) && count($data["departments"])) {
                $user->departments()->sync(array_get($data, 'departments', []));
            }
            //Response
            $response = ["data" => "Request successful"];
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

//Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    //Return data of current user
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

    /**
     * Logout passport
     * @param Request $request
     * Logout user request
     */
    public function logout(Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            if (Auth::guard('api')) {
                //If need it, revoke only token from request
                $value = $request->bearerToken();
                $id = (new Parser())->parse($value)->getHeader('jti');
                $token = Auth::user()->tokens->find($id);
                $token->delete();

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

    /**
     * logout all sessions form user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logoutAllSessions(Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            $userId = $request->input('userId');
            if ($userId) {
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

    /**
     * auth attempt by email or username
     *
     * @param $credentials
     * @return \Illuminate\Http\JsonResponse
     */
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
                    "expiresDate" => 'Bearer' . $token->token->expires_at,
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

    /**
     * Get token for Login
     *
     * @param $user
     */
    private function getToken($user)
    {
        //Delete all tokens expirateds from user
        DB::table('oauth_access_tokens')->where('user_id', $user->id)
            ->where('expires_at', '<=', now())
            ->delete();

        //get Token
        $token = $user->createToken('Laravel Password Grant Client');

        //Update all tokens form user, add 30 days to expire date
        \DB::table('oauth_access_tokens')->where('id', $token->id ?? $token->accessToken)
            ->update(['expires_at' => now()->addDays(90)]);

        return $token;
    }
}
