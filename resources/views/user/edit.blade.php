@extends('layouts.app')

@section('content')
    <div class="container edit-user">
        <div class="row">
            <div class="centered-panel">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('auth.edit_user') }}</div>
                    <div class="panel-body">
                        {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'put']) !!}
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                {!! Form::label('name', trans('auth.name'), ['class' => 'col-md-4 control-label']) !!}
                                <div class="input-wrapper">
                                    {!! Form::text('name', null,  ['class' => 'form-control']) !!}
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {!! Form::label('name', trans('auth.email'), ['class' => 'col-md-4 control-label']) !!}
                                <div class="input-wrapper">
                                    {!! Form::email('email', null,  ['class' => 'form-control']) !!}
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                {!! Form::label('old_password', trans('auth.old_password'), ['class' => 'col-md-4 control-label']) !!}

                                <div class="input-wrapper">
                                    {!! Form::password('old_password',  ['class' => 'form-control']) !!}
                                    @if ($errors->has('old_password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                {!! Form::label('password', trans('auth.new_password'), ['class' => 'col-md-4 control-label']) !!}

                                <div class="input-wrapper">
                                    {!! Form::password('password',  ['class' => 'form-control']) !!}
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('password_confirmation', trans('auth.confirm_password'), ['class' => 'col-md-4 control-label']) !!}

                                <div class="input-wrapper">
                                    {!! Form::password('password_confirmation',  ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="actions-panel reverse">
                                <div class="col-md-6 col-md-offset-4">
                                    {!! Form::submit(trans('auth.save'), ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
