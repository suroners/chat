<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Sidebar</div>

            <div class="panel-body">
				@foreach ($chats as $chat)
					<div class="col-md-12" style="margin-bottom: 10px;">
                        <div>
                            <img src="{{ url('assets/images') }}/{{ $chat->image_name }}" alt="{{ $chat->image_name }}" style="width: 50px;height: 50px;">
                            <p style="display: inline;">{{ $chat->name }}</p>
                        </div>
                        <a href="{{ url('socketChat') }}/{{ $chat->slug }}" target="_blank"><p style="display: inline;">Socket Chat</p></a>
                        <a href="{{ url('chat') }}/{{ $chat->slug }}" target="_blank"><p style="display: inline;">Ajax Chat</p></a>
                    </div>
				@endforeach
                @if (!empty($onlySlugChats))
                    <p>Only Slug Chuts</p>
                    @foreach ($onlySlugChats as $chat)
                        <div class="col-md-12" style="margin-bottom: 10px;">
                            <div>
                                <img src="{{ url('assets/images') }}/{{ $chat->image_name }}" alt="{{ $chat->image_name }}" style="width: 50px;height: 50px;">
                                <p style="display: inline;">{{ $chat->name }}</p>
                            </div>
                            <a href="{{ url('socketChat') }}/{{ $chat->slug }}" target="_blank"><p style="display: inline;">Socket Chat</p></a>
                            <a href="{{ url('chat') }}/{{ $chat->slug }}" target="_blank"><p style="display: inline;">Ajax Chat</p></a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

