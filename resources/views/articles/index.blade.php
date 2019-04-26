@extends('layouts.master')
@section('page-title', 'Articles')

@section('content')
    <div class="content px-5">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <button type="button" class="btn btn-success ml-auto mb-3" data-toggle="modal" data-target="#modal-article-create">
                    <i class="fa fa-fw fa-plus mr-1"></i> New Article
                </button>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                    <thead>
                    <tr>
                        <th>Article ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Template</th>
                        <th>Sales Number</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($cards as $card)
                            <tr>
                                <td>{{$card->article_id}}</td>
                                <td>{{$card->title}}</td>
                                <td>{{$card->category->title}}</td>
                                <td>Template1</td>
                                <td>{{$card->sales_count}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ Route('articles.edit', $card->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn-delete btn btn-sm btn-danger btn-delete-article" data-toggle="modal" title="Delete" data-target="#modal-campaign-delete" data-action = "{{Route('articles.delete', $card->id)}}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {!! Form::open(array('route' => ['articles.create'], 'method' => 'GET', 'role' => 'form', 'class' => 'needs-validation')) !!}
    <div class="modal fade" id="modal-article-create" tabindex="-1" role="dialog" aria-labelledby="modal-default-popin" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" align="center">Create New Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-1">
                    <div class="form-group has-feedback {{ $errors->has('title') ? ' has-error ' : '' }}">
                        {!! Form::label('title', 'Article Title', array('class' => 'col-md-12 col-form-label-sm')) !!}
                        <div class="col-md-12">
                            <div class="input-group">
                                {!! Form::text('title', NULL, array('id' => 'title', 'class' => 'form-control', 'required')) !!}
                            </div>
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error ' : '' }}">
                        {!! Form::label('template', 'Article Template', array('class' => 'col-md-12 col-form-label-sm')) !!}
                        <div class="col-md-12">
                            <div class="input-group">
                                {{Form::select('template', ['0' => 'Template1'], 0, array('class' => 'form-control'))}}
                            </div>
                            @if ($errors->has('template'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('template') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-0">
                    {!! Form::button('Create', array('class' => 'btn btn-success w-100 rounded-0','type' => 'submit' )) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="modal fade" id="modal-campaign-delete" tabindex="-1" role="dialog" aria-labelledby="modal-campaign-delete" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route'=>['articles.delete', 0], 'id' => 'form-article-delete', 'method' => 'DELETE']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you delete this article?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('js-after')
    @include('articles.index-script')
@endsection