<?php

namespace Modules\Iprofile\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Core\Http\Controllers\BasePublicController;

class PublicController extends BasePublicController
{
    use DispatchesJobs;

    public function __construct()
    {
        parent::__construct();
    }

}
