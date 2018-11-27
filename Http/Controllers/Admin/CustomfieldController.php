<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iprofile\Entities\Customfield;
use Modules\Iprofile\Http\Requests\CreateCustomfieldRequest;
use Modules\Iprofile\Http\Requests\UpdateCustomfieldRequest;
use Modules\Iprofile\Repositories\CustomfieldRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CustomfieldController extends AdminBaseController
{
    /**
     * @var CustomfieldRepository
     */
    private $customfield;

    public function __construct(CustomfieldRepository $customfield)
    {
        parent::__construct();

        $this->customfield = $customfield;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomfieldRequest $request
     * @return Response
     */
    public function store(CreateCustomfieldRequest $request)
    {
        $this->customfield->create($request->all());

        return redirect()->route('admin.iprofile.customfield.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iprofile::customfields.title.customfields')]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Customfield $customfield
     * @param  UpdateCustomfieldRequest $request
     * @return Response
     */
    public function update(Customfield $customfield, UpdateCustomfieldRequest $request)
    {
        $this->customfield->update($customfield, $request->all());

        return redirect()->route('admin.iprofile.customfield.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iprofile::customfields.title.customfields')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Customfield $customfield
     * @return Response
     */
    public function destroy(Customfield $customfield)
    {
        $this->customfield->destroy($customfield);

        return redirect()->route('admin.iprofile.customfield.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iprofile::customfields.title.customfields')]));
    }
}
