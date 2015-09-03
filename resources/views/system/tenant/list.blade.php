@extends("system.layouts.main")

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tenants List <a href="{{URL::route('tenant.create')}}" type="button" class="btn btn-outline btn-primary btn-xs">New</a> </h1>
            <div class="row">
                <div class="col-lg-12">
                    {{--<div class="panel panel-default">--}}
                        {{--<div class="panel-heading">--}}
                            {{--List--}}
                        {{--</div>--}}
                        <!-- /.panel-heading -->
                        {{--<div class="panel-body">--}}
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Subdomain</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($tenants as $tenant)
                                        <tr>
                                            <td class="left col-xs-2">{{$tenant['company_name']}}</td>
                                            <td class="left col-xs-2">{{$tenant['subdomain']}}</td>
                                            <td class="left col-xs-2">{{$tenant['admin_name']}}</td>
                                            <td class="left col-xs-2">{{$tenant['admin_surname']}}</td>
                                            <td class="left col-xs-2">{{$tenant['admin_email']}}</td>
                                            <td class="left col-xs-2">
                                                <div class="col-xs-4">
                                                {!! Form::open(['route' => ['tenant.edit', 'tenant' => $tenant['id'] ], 'method' => 'get']) !!}
                                                {!! Form::m_submit('edit', ['class' => 'btn btn-outline btn-primary btn-xs']) !!}
                                                {!! Form::close() !!}
                                                </div>
                                                <div class="col-xs-4">
                                                {!! Form::open(['route' => ['tenant.destroy', 'tenant' => $tenant['id'] ], 'method' => 'delete']) !!}
                                                {!! Form::m_submit('Delete', ['class' => 'btn btn-outline btn-danger btn-xs']) !!}
                                                {!! Form::close() !!}
                                                </div>

                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        {{--</div>--}}
                        <!-- /.panel-body -->
                    {{--</div>--}}
                    <!-- /.panel -->
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

@endsection