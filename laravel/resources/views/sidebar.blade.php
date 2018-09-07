<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Sidebar</div>

            <div class="panel-body">
				@foreach ($chats as $chat)
					<div class="col-md-12" style="margin-bottom: 10px;">
                        <a href="{{ url('chat') }}/{{ $chat->slug }}" target="_blank">
    						<img src="{{ url('assets/images') }}/{{ $chat->image_name }}" alt="{{ $chat->image_name }}" style="width: 50px;height: 50px;">
                            <p style="display: inline;">{{ $chat->name }}</p>
                        </a>
					</div>
				@endforeach
            </div>
        </div>
    </div>
</div>

