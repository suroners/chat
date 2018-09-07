@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">New Chat</div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel-body" method="post" enctype="multipart/form-data">
                   
                    {!! Form::open(['url' => 'addChat', 'method' => 'post', 'role' => 'form','enctype' => 'multipart/form-data']) !!}  
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-5">
                                {!! Form::text('name','',['class' => 'form-control','placeholder' => 'Name']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="slug" class="col-sm-2 col-form-label">Slug</label>
                            <div class="col-sm-5">
                                {!! Form::text('slug','',['class' => 'form-control','placeholder' => 'Slug']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Is Pivate</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                <label class="form-check-label">
                                    {!! Form::checkbox('is_private') !!} Check me out
                                </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Is Only Slug</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                <label class="form-check-label">
                                    {!! Form::checkbox('is_only_slug') !!} Check me out
                                </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-5">
                                {!! Form::file('image',['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                                {!! Form::submit('Add Chat',['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
