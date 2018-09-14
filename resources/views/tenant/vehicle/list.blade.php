@extends("tenant.layouts.main")

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">vehicles List <a href="{{URL::route('vehicle.create')}}" type="button" class="btn btn-outline btn-primary btn-xs">New</a> </h1>
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
                                <th>ID</th>
                                <th>Type</th>
                                <th>Model</th>
                                <th>Registration</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($vehicles as $vehicle)
                                <tr>
                                    <td class="left col-xs-2">{{$vehicle['id']}}</td>
                                    <td class="left col-xs-2">{{$vehicle['type']}}</td>
                                    <td class="left col-xs-2">{{$vehicle['model']}}</td>
                                    <td class="left col-xs-2">{{$vehicle['reg']}}</td>
                                    <td class="left col-xs-2">
                                        <div class="col-xs-4">
                                            {!! Form::open(['route' => ['vehicle.edit', 'tenant' => $vehicle['id'] ], 'method' => 'get']) !!}
                                            {!! Form::m_submit('edit', ['class' => 'btn btn-outline btn-primary btn-xs']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="col-xs-4">
                                            {!! Form::open(['route' => ['tenant.destroy', 'tenant' => $vehicle['id'] ], 'method' => 'delete']) !!}
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