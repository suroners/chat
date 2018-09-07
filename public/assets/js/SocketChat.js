var SocketChat = function(user,chat_id){
	if(Object.keys(user).length)
		this.user_id = user.id;
	else
		this.user_id = 'guest_'+Math.floor(Math.random()*1000)+Date.now();

	this.user			= user;
	this.chat_id		= chat_id;

    var host = 'ws://127.0.0.1:8889';
    this.socket = null;
    try {
    	var _this = this;
        this.socket = new WebSocket(host);

        //Manages the open event within your client code
        this.socket.onopen = function (data) {
			var data = {
				user_id: _this.user_id,
				chat_id: _this.chat_id,
				status: 'open'
			};

			_this.sendSms(data);
            return;
        };

        //Manages the message event within your client code
        this.socket.onmessage = function (msg) {
        	var msg = JSON.parse(msg.data);

        	$('.users-count').html("Users Count : "+msg.usersCount);

			if(typeof msg.msg !== 'undefined'){
				var htmlData = {
					user : Object.keys(msg.user).length ? msg.user.name : 'Guest',
					email : Object.keys(msg.user).length ? msg.user.email : '',
					text : msg.msg
				}

				_this.appendHTML(htmlData)
			}

            return;
        };

        //Manages the close event within your client code
        this.socket.onclose = function (data) {
			var data = {
				user_id: _this.user_id,
				chat_id: _this.chat_id,
				status: 'close'
			};

			_this.sendSms(data);
            return;
        };
    } catch (e) {
    	console.log(e)
    }
}

SocketChat.prototype.sendSms = function(sms){
	this.socket.send(JSON.stringify(sms));
}
// Sms functions end

// helper functions start
SocketChat.prototype.appendHTML = function(data){
	$('.sms-content').append('<div class="col-md-12" style="margin-bottom: 10px;"><p>'+data.user+' '+data.email+'</p><p>'+data.text+'</p></div>');
}
// helper functions end

// initialization start
SocketChat.prototype.bindEvent = function(){
	var _this = this;

	$(document).on('click','.add-sms',function(e){
		var data = {
			user_id: _this.user_id,
			chat_id: _this.chat_id,
			status: 'sms',
			msg: $('#sms_text').val(),
		}

		_this.sendSms(data);

		$('#sms_text').val('');
	})

}


