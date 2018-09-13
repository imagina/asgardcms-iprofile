<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery\CountValidator\Exception;
use Modules\Iprofile\Entities\Profile;
use Modules\Iprofile\Http\Requests\CreateProfileRequest;
use Modules\Iprofile\Http\Requests\UpdateProfileRequest;
use Modules\Iprofile\Http\Controllers\BaseApiController;
use Modules\Iprofile\Repositories\ProfileRepository;
use Modules\Iprofile\Repositories\AddressRepository;
use Modules\Iprofile\Transformers\AddressesTransformer;
use Modules\Iprofile\Transformers\ProfileTransformer;
use Modules\User\Repositories\UserRepository;
use Log;


class ApiProfileController extends BaseApiController
{
  /**
   * @var ProfileRepository
   */

  private $profile;
  private $user;
  private $addresses;

  public function __construct(
    ProfileRepository $profile,
    UserRepository $user,
    AddressRepository $addresses)
  {
    parent::__construct();

    $this->profile = $profile;
    $this->user = $user;
    $this->addresses = $addresses;
  }


  /**
   * Display a listing of the resource.
   *
   * @return Response
   */

  public function index()
  {
    $user = \Auth::user();
    $profile = $this->profile->findByUserId($user->id);
    $addresses = $this->addresses->findByProfileId($profile->id);
    $addressesEncoded = json_encode(AddressesTransformer::collection($addresses));
    //Default Template
    $tpl = 'iprofile::frontend.index';
    $ttpl='iprofile.index';

    if(view()->exists($ttpl)) $tpl = $ttpl;

    return view($tpl, compact('user','profile','addressesEncoded','addresses'));

  }

  public function updateAddress(Request $request){

    $status=true;
    $data = $request->all();
    $user = $this->auth->user();
    $profile = $this->profile->findByUserId($user->id);
    $addresses=$this->addresses->updateMassiveById($data,$profile->id);
    $addressesEncoded = json_encode(AddressesTransformer::collection($addresses));
    return [
      "status" => $status,
      "addresses"=>$addresses,
      "addressesEncoded"=>$addressesEncoded
    ];
  }

  public function storeNewAddress(Request $request){
    try{
      $status=true;
      $data = $request->all();
      unset($data['id']);
      $user = $this->auth->user();
      $profile = $this->profile->findByUserId($user->id);
      $data[0]['profile_id']=$profile->id;
      if($data[0]['type']==null)
        $data[0]['type']="  ";
      $this->addresses->create($data[0]);
      $addresses = $this->addresses->findByProfileId($profile->id);
      $addressesEncoded = json_encode(AddressesTransformer::collection($addresses));
      return [
        "status" => $status,
        "addresses"=>$addresses,
        "addressesEncoded"=>$addressesEncoded
      ];
    }catch(\Exception $e){
      $status=false;
      return [
        "status" => $status,
        "error"=>$e->getMessage()
      ];
    }
  }

  /**
   * @return mixed
   */
  public function edit()

  {
    try {
      $user = \Auth::user();
      $profile = $this->profile->findByUserId($user->id);
      //$addresses = AddressesTransformer::collection($this->addresses->findByProfileId($profile->id));

      $response = ["data" => new ProfileTransformer($profile)];

    }catch(\Exception $e){
      $status = 500;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response,$status ?? 200);



  }

  /**
   * @return mixed
   */
  public function show()

  {
    try {
      $user = \Auth::user();
      $profile = $this->profile->findByUserId($user->id);
      //$addresses = AddressesTransformer::collection($this->addresses->findByProfileId($profile->id));

      $response = ["data" => new ProfileTransformer($profile)];

    }catch(\Exception $e){
      $status = 500;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response,$status ?? 200);



  }

  /**

   * Update the specified resource in storage.
   *
   * @param  Profile $profile
   * @param  Request $request
   * @return Response
   */

  public function update(Request $request)
  {
    try {
      $user = \Auth::user(); //Get User
      $profile = $this->profile->findByUserId($user->id); //Get Model profile
      $updtProfile = $request->profileData; //Get data profile

      //Validate mainimage, if not exist, set default image
      if(empty($updtProfile['options']['mainimage'])){
        $updtProfile['options']['mainimage'] = 'modules/iprofile/img/default.jpg';
      }

      //Update profile image
      $updtProfile['options']['mainimage'] = $this->saveImage(
        $updtProfile['options']['mainimage'],
        "assets/iprofiles/profile/" . $profile->user_id . ".jpg"
      );

      //Update data Profile
      $profileData = $this->profile->update($profile, $updtProfile);
      //Update data User
      $userData = $this->user->update($user, $request->userData);

      //Response
      $response = ["data" => [
        "profileData" => new ProfileTransformer($profileData),
        "userData" => [
          "first_name" => $userData->first_name,
          "last_name" => $userData->last_name,
          "email" => $userData->email
        ]
      ]];

    } catch (\Exception $e) {
      $status = 500;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response,$status ?? 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $value
   * @param  $destination_path
   * @return Response
   */

  public function saveImage($value, $destination_path)

  {
    $disk = "publicmedia";
    //Defined return.
    if (starts_with($value, 'http')) {
      $url = url('modules/bcrud/img/default.jpg');
      if ($value == $url) {
        return 'modules/iprofile/img/default.jpg';
      } else {
        if (empty(str_replace(url(''), "", $value))) {

          return 'modules/iprofile/img/default.jpg';
        }
        str_replace(url(''), "", $value);
        return str_replace(url(''), "", $value);
      }
    };

    // if a base64 was sent, store it in the db
    if (starts_with($value, 'data:image')) {
      // 0. Make the image
      $image = \Image::make($value);
      // resize and prevent possible upsizing

      $image->resize(config('asgard.iprofile.config.imagesize.width'), config('asgard.iprofile.config.imagesize.height'), function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
      });

      // 2. Store the image on disk.
      \Storage::disk($disk)->put($destination_path, $image->stream('jpg', '80'));
      // Save Thumbs
      \Storage::disk($disk)->put(
        str_replace('.jpg', '_mediumThumb.jpg', $destination_path),
        $image->fit(config('asgard.iprofile.config.mediumthumbsize.width'), config('asgard.iprofile.config.mediumthumbsize.height'))->stream('jpg', '80')

      );

      \Storage::disk($disk)->put(
        str_replace('.jpg', '_smallThumb.jpg', $destination_path),
        $image->fit(config('asgard.iprofile.config.smallthumbsize.width'), config('asgard.iprofile.config.smallthumbsize.height'))->stream('jpg', '80')
      );

      // 3. Return the path
      return $destination_path;

    }

    // if the image was erased
    if ($value == null) {
      // delete the image from disk
      \Storage::disk($disk)->delete($destination_path);

      // set null in the database column
      return null;
    }
  }




}

