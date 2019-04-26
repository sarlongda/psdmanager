@extends('layouts.master')
@section('page-title', 'Edit Article')

@section('content')
    <div class="content px-5">
        {!! Form::open(array('route' => ['articles.update', $card->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
        <div class="form-row">
            <div class="float-right">PSD Status:
                <span class="badge {{$psd_exist ? 'badge-success' : 'badge-warning'}}">{{$psd_exist ? 'OK' : 'MISSING'}}</span>
            </div>
            <div class="float-right ml-2">Preview Status:
                <span class="badge {{$prev_exist ? 'badge-success' : 'badge-warning'}}">{{$prev_exist ? 'OK' : 'MISSING'}}</span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4 has-feedback {{ $errors->has('article_id') ? ' has-error ' : '' }}">
                {!! Form::label('article_id', 'Article ID', array('class' => 'col-md-12 col-form-label-sm')) !!}
                <div class="col-md-12">
                    <div class="input-group">
                        {!! Form::text('article_id', $card->article_id, array('class' => 'form-control', 'required')) !!}
                    </div>
                    @if ($errors->has('article_id'))
                        <span class="help-block">
                        <strong>{{ $errors->first('article_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-4 has-feedback {{ $errors->has('title') ? ' has-error ' : '' }}">
                {!! Form::label('title', 'Article Title', array('class' => 'col-md-12 col-form-label-sm')) !!}
                <div class="col-md-12">
                    <div class="input-group">
                        {!! Form::text('title', $card->title, array('class' => 'form-control', 'required')) !!}
                    </div>
                    @if ($errors->has('title'))
                        <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-4 has-feedback {{ $errors->has('category_id') ? ' has-error ' : '' }}">
                {!! Form::label('category_id', 'Category', array('class' => 'col-md-12 col-form-label-sm')) !!}
                <div class="col-md-12">
                    <div class="input-group">
                        {{Form::select('category_id', $allCategories, $card->category_id, array('class' => 'form-control'))}}
                    </div>
                    @if ($errors->has('category_id'))
                        <span class="help-block">
                        <strong>{{ $errors->first('category_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4 has-feedback {{ $errors->has('sales_count') ? ' has-error ' : '' }}">
                {!! Form::label('sales_count', 'Sales Count', array('class' => 'col-md-12 col-form-label-sm')) !!}
                <div class="col-md-12">
                    <div class="input-group">
                        {!! Form::text('sales_count', $card->sales_count, array('class' => 'form-control', 'required')) !!}
                    </div>
                    @if ($errors->has('sales_count'))
                        <span class="help-block">
                        <strong>{{ $errors->first('sales_count') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-4 has-feedback {{ $errors->has('age') ? ' has-error ' : '' }}">
                {!! Form::label('age', 'Age', array('class' => 'col-md-12 col-form-label-sm')) !!}
                <div class="col-md-12">
                    <div class="input-group">
                        {!! Form::text('age', $card->age, array('class' => 'form-control', 'required')) !!}
                    </div>
                    @if ($errors->has('age'))
                        <span class="help-block">
                        <strong>{{ $errors->first('age') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-4 has-feedback {{ $errors->has('gender') ? ' has-error ' : '' }}">
                {!! Form::label('gender', 'Gender', array('class' => 'col-md-12 col-form-label-sm')) !!}
                <div class="col-md-12">
                    <div class="input-group">
                        {{Form::select('gender', [0 => 'Male', 1 => 'Female'], $card->gender, array('class' => 'form-control'))}}
                    </div>
                    @if ($errors->has('gender'))
                        <span class="help-block">
                        <strong>{{ $errors->first('gender') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group has-feedback {{ $errors->has('plz') ? ' has-error ' : '' }}">
            {!! Form::label('plz', 'PLZ', array('class' => 'col-md-12 col-form-label-sm')) !!}
            <div class="col-md-12">
                <div class="input-group">
                    {!! Form::text('plz', $card->plz, array('class' => 'form-control')) !!}
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
                    {!! Form::text('city', $card->city, array('class' => 'form-control')) !!}
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
                    {!! Form::text('street', $card->street, array('class' => 'form-control')) !!}
                </div>
                @if ($errors->has('street'))
                    <span class="help-block">
                        <strong>{{ $errors->first('street') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-3">
                <div class="col-md-12">
                    {!! Form::button('Update', array('class' => 'btn btn-success w-100 rounded-0','type' => 'submit', 'name' => 'update', 'value' => 'update' )) !!}
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="col-md-12">
                    {!! Form::button('Generate Preview', array('class' => 'btn btn-success w-100 rounded-0','type' => 'submit', 'name' => 'update', 'value' => 'generate', $psd_exist ? '' : 'disabled' )) !!}
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="col-md-12">
                    {!! Form::button('Preview Front', array('id' => 'btn-preview-front', 'class' => 'btn btn-primary w-100 rounded-0','type' => 'button', 'data-article-id' => $card->article_id, $prev_exist ? '' : 'disabled' )) !!}
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="col-md-12">
                    {!! Form::button('Preview Back', array('id' => 'btn-preview-back', 'class' => 'btn btn-primary w-100 rounded-0','type' => 'button', $prev_exist ? '' : 'disabled' )) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="modal fade" id="modal-article-preview" tabindex="-1" role="dialog" aria-labelledby="modal-article-preview" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <img id="img-article-preview" src="{{asset('Default.png')}}" width="498px" height="auto">
            </div>
        </div>
    </div>
@endsection

@section('js-after')
    @include('articles.edit-script')
@endsection