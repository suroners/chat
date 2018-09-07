var Chat = function(user,chat_id,sms_id){
	if(Object.keys(user).length)
		this.user_id = user.id;
	else
		this.user_id = 'guest_'+Math.floor(Math.random()*1000)+Date.now();

	this.user			= user;
	this.chat_id		= chat_id;
	this.last_sms_id	= sms_id;
}

// Sms functions start
Chat.prototype.sendSms = function(data){
	Promise.resolve({
		data : {
			url : base_url + "/addSms",
			data : data,
			type : 'POST'
		},
		sms : data,
		this : this
	}).then(this.PromiseAjax)
	.then(function(obj){
		obj.this.showSms(obj);
	}).catch(function(err){
		console.log(err);
	});
}

Chat.prototype.showSms = function(obj){
	return new Promise(function(resolve,reject){
		if(obj.data.status == "success"){
			var data = obj.data,
				_this = obj.this;

			var data = {
				user : _this.getUserName(),
				email : _this.getUserEmail(),
				text : obj.sms.sms_text
			}

			_this.last_sms_id = obj.data.sms_id;
			_this.appendHTML(data)

			return resolve({messages:'Sms is shown.'});
		}else{
			return reject({messages:'Add sms fail.'});
		}
	});
}

Chat.prototype.getUserName = function(){
	return (Object.keys(this.user).length)? this.user.name : 'Guest';
}

Chat.prototype.getUserEmail = function(){
	return (Object.keys(this.user).length)? this.user.email : '';
}

Chat.prototype.getNewest = function(){
	Promise.resolve({
		data : {
			url : base_url + "/getNewest",
			data : {last_sms_id : this.last_sms_id,chat_id: this.chat_id,user_id: this.user_id},
			type : 'GET'
		},
		this : this
	}).then(this.PromiseAjax)
	.then(function(obj){
		obj.this.appendSms(obj);
	}).catch(function(err){
		console.log(err);
	});
}

Chat.prototype.appendSms = function(obj){
	return new Promise(function(resolve,reject){
		if(obj.data.status == "success"){
			var data = obj.data,
				_this = obj.this,
				allSms = data.allSms;

			for(i in allSms){
				var htmlData = {
					user : allSms[i].name ? allSms[i].name : 'Guest',
					email : allSms[i].email ? allSms[i].email : '',
					text : allSms[i].text
				}

				_this.appendHTML(htmlData)
			}

			if(data.allSms.length)
				_this.last_sms_id = data.allSms[data.allSms.length - 1].id;

			$('.users-count').html("Users Count : "+data.count);

			return resolve({messages:'Sms is shown.'});
		}
	});
}
// Sms functions end


// helper functions start
Chat.prototype.PromiseAjax = function(obj){
	return new Promise(function(resolve,reject){
		$.ajax({
			url: obj.data.url,
			data: obj.data.data,
			type: obj.data.type,
			dataType: 'json',
			success: function(data){
				obj.data = data
				return resolve(obj);
			},
			error : function(err){
				return reject(err);
			}
		});
	});
}

Chat.prototype.appendHTML = function(data){
	$('.sms-content').append('<div class="col-md-12" style="margin-bottom: 10px;"><p>'+data.user+' '+data.email+'</p><p>'+data.text+'</p></div>');
}
// helper functions end

// initialization start
Chat.prototype.bindEvent = function(){
	var _this = this;

	$(document).on('click','.add-sms',function(e){
		var data = {
			user_id: _this.user_id,
			chat_id: _this.chat_id,
			_token: $('[name="_token"]').val(),
			sms_text: $('#sms_text').val(),
		}

		_this.sendSms(data);

		$('#sms_text').val('');
	})

	var id = setInterval(function(){
		_this.getNewest();
	}, 2000);
}


