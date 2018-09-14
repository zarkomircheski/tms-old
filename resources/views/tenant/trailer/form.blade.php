@extends("tenant.layouts.main")

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create Trailer Record</h1>
            {{--@if($errors->has())--}}
            {{--<div>{{ $errors->get('form') }}</div>--}}
            {{--@endif--}}

            <div class="row">
                <div class="col-lg-6">
                    {!! Form::open(['url' => URL::route('trailer.store'), 'method' => 'post']) !!}

                    {!! Form::m_input('text', 'company_name', Request::input('company_name'),
                    ['required'],
                    ['label' => 'Company Name', 'help' => 'Name of the Company', 'error' => formError('company_name')]) !!}

                    {!! Form::m_input('text', 'subdomain', Request::input('subdomain'),
                    ['required'],
                    ['label' => 'Subdomin Name', 'help' => 'Name before main domian Ex: <u>companyname</u>.tms.com', 'error' => formError('subdomain')]) !!}

                    <br>
                    <h3>Admin Info</h3>

                    {!! Form::m_input('text', 'admin_name', Request::input('admin_name'),
                    ['required'],
                    ['label' => 'First Name', 'help' => 'Administrator first name', 'error' => formError('admin_name')]) !!}

                    {!! Form::m_input('text', 'admin_surname', Request::input('admin_surname'),
                    ['required'],
                    ['label' => 'Last Name', 'help' => 'Administrator last name', 'error' => formError('admin_surname')]) !!}

                    {!! Form::m_input('email', 'admin_email', Request::input('admin_email'),
                    ['required'],
                    ['label' => 'Email address', 'help' => 'Administrator email', 'error' => formError('admin_email')]) !!}


                    {!! Form::m_submit('Create') !!}


                    {!! form::close() !!}
                </div>
                {{--{{dd(formError('email'))}}--}}
                <div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Description
                        </div>
                        <div class="panel-body">
                            <p>
                                This is a place for creating new vehicle record.
                            </p>
                        </div>
                        {{--<div class="panel-footer">--}}
                        {{--Panel Footer--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection