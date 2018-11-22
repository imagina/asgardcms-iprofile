<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery\CountValidator\Exception;
use Modules\User\Contracts\Authentication;
use Modules\Iprofile\Entities\Profile;
use Modules\Iprofile\Http\Requests\CreateProfileRequest;
use Modules\Iprofile\Http\Requests\UpdateProfileRequest;
use Modules\Iprofile\Repositories\ProfileRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Log;
use Modules\Iprofile\Entities\Status;

use Maatwebsite\Excel\Facades\Excel;
use Modules\Iprofile\Imports\ProfilesImport;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\RoleRepository;

class ProfileController extends AdminBaseController
{
    /**
     * @var ProfileRepository
     */
    private $profile;
    private $auth;
    private $status;
    private $user;
    private $role;

    public function __construct(
        ProfileRepository $profile, 
        Authentication $auth, 
        Status $status,
        UserRepository $user, 
        RoleRepository $role
    ){
        parent::__construct();

        $this->profile = $profile;
        $this->auth = $auth;
        $this->status = $status;
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $profiles = $this->profile->all();
        $status = $this->status;
        return view('iprofile::admin.profiles.index', compact('profiles','status'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProfileRequest $request
     * @return Response
     */
    public function store(CreateProfileRequest $request)
    {
        $user = $this->auth->user();
        $profile = $user->profile()->first();
        try {
            $profile = $this->profile->create($request->all());
            if (count($profile)) {
                if (!empty($request['mainimage']) && !empty($profile->id)) {
                    $request['mainimage'] = $this->saveImage($request['mainimage'], "assets/iprofiles/profile/" . $profile->user_id . ".jpg");
                } else {
                    $request['mainimage'] = 'modules/iprofile/img/default.jpg';
                }
            }
            $profile->options = ['mainimage' => $request->mainimage];
            $profile->options = ['education' => $request->education];
            $profile->save();

            return redirect()->route('admin.iprofile.profile.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iprofile::profiles.title.profiles')]));
        } catch (\Throwable $t) {
            //var_dump($t);
            $response['status'] = 'error';
            $response['message'] = $t->getMessage();
            Log::error($t);
            return redirect()->route('admin.iprofile.profile.index')
                ->withError($response['message']);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Profile $profile
     * @return Response
     */
    public function edit()
    {
        $user = $this->auth->user();
        $profile = $this->profile->findByUserId($user->id);
        $this->assetPipeline->requireJs('moment.js');
        $this->assetPipeline->requireJs('daterangepicker.js');
        $this->assetPipeline->requireCss('daterangepicker.css');
        if (count($profile)) {
            return view('iprofile::admin.profiles.edit', compact('user', 'profile'));
        }
        return view('iprofile::admin.profiles.create', compact('user'));
        //return view('iprofile::admin.profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Profile $profile
     * @param  UpdateProfileRequest $request
     * @return Response
     */
    public function update(Profile $profile, UpdateProfileRequest $request)
    {

        $profile=$this->profile->update($profile, $request->all());
        if (isset($request->label)) {
            $label = $request->label;
            $desc = $request->desc;
            for ($i = 0; $i < count($label); $i++) {
                if ($label[$i] != "fa-share-alt" && $desc[$i] != "")
                    $socialResult[$i] = array('label' => $label[$i], 'desc' => $desc[$i]);
            }
            $profile->social = json_encode($socialResult);
            $profile->save();
        }
        if (count($profile)) {
            if (!empty($request['mainimage']) && !empty($profile->id)) {
                $request['mainimage'] = $this->saveImage($request['mainimage'], "assets/iprofiles/profile/" . $profile->user_id . ".jpg");
            } else {
                $request['mainimage'] = 'modules/iprofile/img/default.jpg';
            }
        }

        $profile->options = ['mainimage'=>$request->mainimage,'education'=>$request->education];

        $profile->save();


        return redirect()->route('admin.account.profile.edit')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iprofile::profiles.title.profiles')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Profile $profile
     * @return Response
     */
    public function destroy(Profile $profile)
    {
        $this->profile->destroy($profile);

        return redirect()->route('admin.iprofile.profile.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iprofile::profiles.title.profiles')]));
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

     
    /**
     * view import and export from profiles.
     * @return View
     */
    public function indexImport(){
        return view('iprofile::admin.profiles.bulkload.index');
    }

    public function importProfiles(Request $request)
    {
        $msg="";
       
        try {

            $data_excel = Excel::import(new ProfilesImport($this->user,$this->role,$this->profile), $request->importfile);

            $msg=trans('iprofile::profiles.bulkload.success migrate');
            return redirect()->route('admin.account.profile.index')
            ->withSuccess($msg);
           
        } catch (Exception $e) {
           
            $msg  =  trans('iprofile::profiles.bulkload.error in migrate');
            return redirect()->route('admin.account.profile.index')
            ->withError($msg);
            
        }
 
    }

}
