<?php namespace App\Http\Controllers\System;

use App\Commands\system\tenantCreateCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenantCreateRequest;
use App\Models\Eloquent\System\Tenant;
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
    public function index()
    {
        //list tenants
        $tenants = Tenant::all()->toArray();
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
    public function store(TenantCreateRequest $request)
    {
        //store tenant
        $tenant = new Tenant($request->all());
        $tenant->save();

        $response = $this->dispatch(new tenantCreateCommand($tenant));

        if(! $response){
            $tenant->delete();
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
    public function destroy($id)
    {
        $tenant = Tenant::find($id);
        $tenant->delete();
        return \Redirect::route('tenant.index');
    }
}
