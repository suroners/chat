@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Chat {{ $chat->name}}
                    <br>
                    <span class="users-count"></span>
                </div>
                <div class="panel-body" method="post" enctype="multipart/form-data">
                    <div class="row sms-content">
                        @foreach ($allSms as $sms)
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <p>{{ $sms->name ? $sms->name : 'Guest' }} {{ $sms->email }}</p>
                                <p>{{ $sms->text }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        {!! Form::open(['url' => 'addChat', 'method' => 'post', 'role' => 'form','enctype' => 'multipart/form-data','id' => 'sms-form']) !!}  
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    {{ Form::textarea('sms_text', null,['size' => '30x5','class' => 'form-control','placeholder' => 'Sms', 'id' => 'sms_text']) }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    {!! Form::button('Add Sms',['class' => 'btn btn-primary add-sms']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('assets/js/Chat.js') }}"></script>
<script type="text/javascript">
;(function(){
    // create unique Chat object
    var chat = new Chat(JSON.parse('{!! json_encode($user) !!}'),{{ $chat->id }},{{ $lastSmsId }});

    $(window).load(function(){
        chat.bindEvent();
    })
})()
</script>
@endsection
