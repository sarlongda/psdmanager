@extends('layouts.master')
@section('page-title', 'Create Article')

@section('content')
    <div class="content px-5">
        {!! Form::open(array('route' => ['articles.store'], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
        <div class="form-group has-feedback {{ $errors->has('title') ? ' has-error ' : '' }}">
            {!! Form::label('title', 'Article Title', array('class' => 'col-md-12 col-form-label-sm')) !!}
            <div class="col-md-12">
                <div class="input-group">
                    {!! Form::text('title', $request->title, array('class' => 'form-control', 'required')) !!}
                </div>
                @if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group has-feedback {{ $errors->has('article_id') ? ' has-error ' : '' }}">
            {!! Form::label('article_id', 'Article ID', array('class' => 'col-md-12 col-form-label-sm')) !!}
            <div class="col-md-12">
                <div class="input-group">
                    {!! Form::text('article_id', '', array('class' => 'form-control', 'required')) !!}
                </div>
                @if ($errors->has('article_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('article_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group has-feedback {{ $errors->has('category_id') ? ' has-error ' : '' }}">
            {!! Form::label('category_id', 'Category', array('class' => 'col-md-12 col-form-label-sm')) !!}
            <div class="col-md-12">
                <div class="input-group">
                    {{Form::select('category_id', $allCategories, 0, array('class' => 'form-control'))}}
                </div>
                @if ($errors->has('category_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('category_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group has-feedback {{ $errors->has('sales_count') ? ' has-error ' : '' }}">
            {!! Form::label('sales_count', 'Sales Count', array('class' => 'col-md-12 col-form-label-sm')) !!}
            <div class="col-md-12">
                <div class="input-group">
                    {!! Form::text('sales_count', 10, array('class' => 'form-control', 'required')) !!}
                </div>
                @if ($errors->has('sales_count'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sales_count') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group has-feedback {{ $errors->has('age') ? ' has-error ' : '' }}">
            {!! Form::label('age', 'Age', array('class' => 'col-md-12 col-form-label-sm')) !!}
            <div class="col-md-12">
                <div class="input-group">
                    {!! Form::text('age', 24, array('class' => 'form-control', 'required')) !!}
                </div>
                @if ($errors->has('age'))
                    <span class="help-block">
                        <strong>{{ $errors->first('age') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group has-feedback {{ $errors->has('gender') ? ' has-error ' : '' }}">
            {!! Form::label('gender', 'Gender', array('class' => 'col-md-12 col-form-label-sm')) !!}
            <div class="col-md-12">
                <div class="input-group">
                    {{Form::select('gender', [0 => 'Male', 1 => 'Female'], 0, array('class' => 'form-control'))}}
                </div>
                @if ($errors->has('gender'))
                    <span class="help-block">
                        <strong>{{ $errors->first('gender') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group has-feedback {{ $errors->has('plz') ? ' has-error ' : '' }}">
            {!! Form::label('plz', 'PLZ', array('class' => 'col-md-12 col-form-label-sm')) !!}
            <div class="col-md-12">
                <div class="input-group">
                    {!! Form::text('plz', NULL, array('class' => 'form-control')) !!}
                </div>
                @if ($errors->has('plz'))
                    <span class="help-block">
                        <strong>{{ $errors->first('plz') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group has-feedback {{ $errors->has('city') ? ' has-error ' : '' }}">
            {!! Form::label('city', 'City', array('class' => 'col-md-12 col-form-label-sm')) !!}
            <div class="col-md-12">
                <div class="input-group">
                    {!! Form::text('city', NULL, array('class' => 'form-control')) !!}
                </div>
                @if ($errors->has('city'))
                    <span class="help-block">
                        <strong>{{ $errors->first('city') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group has-feedback {{ $errors->has('street') ? ' has-error ' : '' }}">
            {!! Form::label('street', 'Street', array('class' => 'col-md-12 col-form-label-sm')) !!}
            <div class="col-md-12">
                <div class="input-group">
                    {!! Form::text('street', NULL, array('class' => 'form-control')) !!}
                </div>
                @if ($errors->has('street'))
                    <span class="help-block">
                        <strong>{{ $errors->first('street') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {!! Form::button('Create', array('class' => 'btn btn-success w-100 rounded-0','type' => 'submit' )) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection