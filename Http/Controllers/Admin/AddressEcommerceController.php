<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iprofile\Entities\AddressEcommerce;
use Modules\Iprofile\Http\Requests\CreateAddressEcommerceRequest;
use Modules\Iprofile\Http\Requests\UpdateAddressEcommerceRequest;
use Modules\Iprofile\Repositories\AddressEcommerceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AddressEcommerceController extends AdminBaseController
{
    /**
     * @var AddressEcommerceRepository
     */
    private $addressecommerce;

    public function __construct(AddressEcommerceRepository $addressecommerce)
    {
        parent::__construct();

        $this->addressecommerce = $addressecommerce;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$addressecommerces = $this->addressecommerce->all();

        return view('iprofile::admin.addressecommerces.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iprofile::admin.addressecommerces.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAddressEcommerceRequest $request
     * @return Response
     */
    public function store(CreateAddressEcommerceRequest $request)
    {
        $this->addressecommerce->create($request->all());

        return redirect()->route('admin.iprofile.addressecommerce.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iprofile::addressecommerces.title.addressecommerces')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AddressEcommerce $addressecommerce
     * @return Response
     */
    public function edit(AddressEcommerce $addressecommerce)
    {
        return view('iprofile::admin.addressecommerces.edit', compact('addressecommerce'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AddressEcommerce $addressecommerce
     * @param  UpdateAddressEcommerceRequest $request
     * @return Response
     */
    public function update(AddressEcommerce $addressecommerce, UpdateAddressEcommerceRequest $request)
    {
        $this->addressecommerce->update($addressecommerce, $request->all());

        return redirect()->route('admin.iprofile.addressecommerce.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iprofile::addressecommerces.title.addressecommerces')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AddressEcommerce $addressecommerce
     * @return Response
     */
    public function destroy(AddressEcommerce $addressecommerce)
    {
        $this->addressecommerce->destroy($addressecommerce);

        return redirect()->route('admin.iprofile.addressecommerce.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iprofile::addressecommerces.title.addressecommerces')]));
    }
}
