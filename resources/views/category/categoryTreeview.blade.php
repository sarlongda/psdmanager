@extends('layouts.master')
@section('page-title', 'Category')
@section('css-after')
    <link href="/css/treeview.css" rel="stylesheet">
@endsection
@section('content')
    <div class="container px-5">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Category List</h3>
                        <ul id="tree1">
                            @foreach($categories as $category)
                                <li class="mb-1">
                                    @if(count($category->childs))
                                        <i class="indicator fas fa-plus-circle"></i>
                                    @endif
                                    {{ $category->title }}
                                    <div class="btn-group float-right mr-5 border border-primary rounded">
                                        <button class="btn btn-sm btn-primary d-block p-1 px-2 btn-edit-category" data-toggle="modal" title="Edit" data-target="#modal-campaign-edit" data-category-title="{{$category->title}}" data-action = "{{Route('categories.update', [$category->id])}}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <button type="button" class="btn-delete btn btn-sm btn-danger d-block p-1 px-2 btn-delete-category" data-toggle="modal" title="Delete" data-target="#modal-campaign-delete" data-action = "{{Route('categories.delete', [$category->id])}}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    @if(count($category->childs))
                                        @include('category.manageChild',['childs' => $category->childs])
                                    @endif
                                </li>

                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h3>Add New Category</h3>

                        {!! Form::open(['route'=>'categories.store']) !!}

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            {!! Form::label('Title:') !!}
                            {!! Form::text('title', old('title'), ['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>

                        <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                            {!! Form::label('Category:') !!}
                            {!! Form::select('parent_id',$allCategories, old('parent_id'), ['class'=>'form-control', 'placeholder'=>'Select Category']) !!}
                            <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success">Add New</button>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-campaign-delete" tabindex="-1" role="dialog" aria-labelledby="modal-campaign-delete" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route'=>['categories.delete', 0], 'id' => 'form-category-delete', 'method' => 'DELETE']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you delete this category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-campaign-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['route'=>['categories.update', 0], 'id' => 'form-category-edit', 'method' => 'PUT']) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('Title:') !!}
                        {!! Form::text('title', old('title'), ['class'=>'form-control', 'id' => 'category_title', 'required']) !!}
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('js-after')
    <script src="/js/treeview.js"></script>
    @include('category.categoryView-script')
@endsection