<?php namespace App\Http\Controllers\System;

use App\Commands\system\tenantCreateCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenantCreateRequest;
use App\Persistence\Interfaces\System\TenantRepoInterface;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(TenantRepoInterface $tenant)
    {
        //list tenants
        $tenants = $tenant->all(['id','subdomain', 'company_name', 'admin_name', 'admin_surname', 'admin_email']);
        return view('system.tenant.list')->with(compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //show create form
        return view('system.tenant.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TenantCreateRequest $request
     * @return Response
     */
    public function store(TenantCreateRequest $request, TenantRepoInterface $tenant)
    {
        //store tenant
        //$tenant = new Tenant($request->all());
        $tenantId = $tenant->save($request->all());
        $tenantData = $tenant->getFirst($tenantId, ['id', 'subdomain', 'admin_name', 'admin_email']);
        $response = $this->dispatch(new tenantCreateCommand($tenantData));

        if(! $response){
            $tenant->delete($tenantId);
            return \Redirect::back()->withErrors(['form' => 'there was an error!']);
        }

        return \Redirect::route('tenant.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(TenantRepoInterface $tenant, $id)
    {
        $tenant->delete($id);
        return \Redirect::route('tenant.index');
    }
}
