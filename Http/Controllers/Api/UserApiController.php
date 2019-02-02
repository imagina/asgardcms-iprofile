<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Inotification\Events\StorageBroadcastingEvent;
use Modules\Iprofile\Repositories\UserRepository;
use Modules\Iprofile\Transformers\UserProfileTransformer;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;

class UserApiController extends BaseApiController
{
    private $user;


    public function __construct(UserRepository $user)
    {
        $this->user = $user;


    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        //try {
        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $users = $this->user->getItemsBy($params);

        //Response
        $response = [
            "data" => UserProfileTransformer::collection($users)
        ];

        //If request pagination add meta-page
        $params->page ? $response["meta"] = ["page" => $this->pageTransformer($users)] : false;
        /* } catch (\Exception $e) {
           $status = $this->getStatusError($e->getCode());
           $response = ["errors" => $e->getMessage()];
         }*/

        //Return response
        return response()->json($response, $status ?? 200);
    }


    /**
     * GET A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $user = $this->user->getItem($criteria, $params);

            //Break if no found item

            if (!$user) throw new \Exception('Item not found', 400);

            //Response
            $response = ["data" => new UserProfileTransformer($user)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($user)] : false;
        } catch (\Exception $e) {
            \Log::error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {

        \DB::beginTransaction();
        try {
            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new CreateUserRequest($data));

            $exist = \DB::table('users')->where('email', $data["email"])->first();


            if (!$exist) {
                //Create item

                $user = $this->user->createWithRoles($data, $data["roles"], $data["status"]);

                $status = 200;
                $response = [
                    'susses' => [
                        'code' => '201',
                        "source" => [
                            "pointer" => url($request->path())
                        ],
                        "title" => trans('core::core.messages.resource created', ['name' => trans('imonitor::common.singular')]),
                        "detail" => [
                            'id' => $user->id
                        ]
                    ]
                ];
            } else {
                $status = 400;
                $response = ["error" => $data["email"] . ' | User Name already exist'];
            }

            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @param $criteria
     * @param Request $request
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes');
            $user = $this->user->find($criteria);
            //Validate Request
            //$this->validateRequestApi(new Request((array)$data));
            $data['id'] = $criteria;
            $data['roles'] = $user->roles;
            $data['activated'] = $data['activated'] ?? $user->activated ?? true;

            if (!$user || $user->id == $data["id"]) {
                $this->user->update($user, $data);

                $status = 200;
                $response = [
                    'susses' => [
                        'code' => '201',
                        "source" => [
                            "pointer" => url($request->path())
                        ],
                        "title" => trans('core::core.messages.resource created', ['name' => trans('imonitor::common.singular')]),
                        "detail" => [
                            'id' => $user->id
                        ]
                    ]
                ];
            } else {
                $status = 400;
                $response = ["errors" => $data["email"] . ' | User Name no exist'];
            }


            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @param Request $request
     * @return mixed
     */
    public function mediaUpload(Request $request)
    {
        try {
            $auth = \Auth::user();
            $data = $request->all();//Get data
            $user_id = $data['user'];
            $name = $data['nameFile'];
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $nameFile = $name . '.' . $extension;
            $allowedextensions = array('JPG', 'JPEG', 'PNG', 'GIF', 'ICO', 'BMP', 'PDF', 'DOC', 'DOCX', 'ODT', 'MP3', '3G2', '3GP', 'AVI', 'FLV', 'H264', 'M4V', 'MKV', 'MOV', 'MP4', 'MPG', 'MPEG', 'WMV');
            $destination_path = 'assets/iprofile/profile/files/' . $user_id . '/' . $nameFile;
            $disk = 'publicmedia';
            if (!in_array(strtoupper($extension), $allowedextensions)) {
                throw new Exception(trans('iprofile::profile.messages.file not allowed'));
            }
            if ($user_id == $auth->id || $auth->hasAccess('user.users.create')) {

                if (in_array(strtoupper($extension), ['JPG', 'JPEG'])) {
                    $image = \Image::make($file);

                    \Storage::disk($disk)->put($destination_path, $image->stream($extension, '90'));
                } else {

                    \Storage::disk($disk)->put($destination_path, \File::get($file));
                }

                $status = 200;
                $response = ["data" => ['url' => $destination_path]];


            } else {
                $status = 403;
                $response = [
                    'error' => [
                        'code' => '403',
                        "title" => trans('iprofile::profile.messages.access denied'),
                    ]
                ];
            }

        } catch (\Exception $e) {
            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @param Request $request
     * @return mixed
     */
    public function mediaDelete(Request $request)
    {
        try {
            $disk = "publicmedia";
            $auth = \Auth::user();
            $data = $request->all();//Get data
            $user_id = $data['user'];
            $dirdata = $request->input('file');

            if ($user_id == $auth->id || $auth->hasAccess('user.users.create')) {

                \Storage::disk($disk)->delete($dirdata);

                $status = 200;
                $response = [
                    'susses' => [
                        'code' => '201',
                        "source" => [
                            "pointer" => url($request->path())
                        ],
                        "title" => trans('core::core.messages.resource delete'),
                        "detail" => [
                        ]
                    ]
                ];
            } else {
                $status = 403;
                $response = [
                    'error' => [
                        'code' => '403',
                        "title" => trans('iprofile::profile.messages.access denied'),
                    ]
                ];
            }

        } catch (\Exception $e) {
            \Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }
}
