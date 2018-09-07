;(function(){
	var Chat = function(){
		this.lawActivity = new Array();
		this.electionActivity = new Array();
		this.currentElections = new Array();
		this.previousElections = new Array();
		this.Lows = new Array();
	}

	// Election functions start
	Chat.prototype.showElection = function(){
		Promise.resolve({
			data : {
				url : APPIQUERYURL + "/api/v1/elections/activity",
				data : new Array(),
				type : 'GET'
			},
			this : this,
			electionType : 'current'
		}).then(this.PromiseAjax)
		.then(function(obj){
			obj.this.electionActivity = obj.data;
			obj.this.showCurrentElection(obj);
			obj.this.showPreviousElection(obj);
		}).catch(function(err){
			console.log(err);
		});
	}

	Chat.prototype.appendElection = function(obj){
		return new Promise(function(resolve,reject){
			if(obj.activity.length){
				var table = $('.teacher-row'),
					activity = obj.activity,
					data = obj.data,
					electionType = obj.electionType,
					_this = obj.this,
					summary = '';

				var data = {
					this : _this,
					activity : activity,
					election : data,
					electionType : electionType,
					table : table
				}

				_this.electionHtml(data,false)

				return resolve({messages:'Election is shown.'});
			}else{
				return reject({messages:'No Election.'});
			}
		});
	}

	Chat.prototype.electionHtml = function(data,time){
		var _this = data.this,
			activity = data.activity,
			table = data.table,
			electionType = data.electionType,
			election = data.election;

		for(i in activity){
			if(electionType == 'current' && election && election.Guid == activity[i].Election.Guid){
				summary = _this.joinEvents(activity[i].Events,time);
				if(summary){
					_this.appendHTML({summary:summary, result:election.Results.Result, table:table, name:'Election proposed by '+activity[i].Election.Proposer,link:APPIQUERYURL+'/elections.html?election=current'});
				}
			}else if(electionType == 'previous'){
				for(k in election){
					if(election[k].Guid == activity[i].Election.Guid){
						summary = _this.joinEvents(activity[i].Events,time);
						if(summary){
							_this.appendHTML({summary:summary, result:election[k].Results.Result, table:table, name:'Election proposed by '+activity[i].Election.Proposer,link:APPIQUERYURL+'/elections.html?election='+election[k].Guid});
						}
					}
				}
			}
		}
	}


	Chat.prototype.showCurrentElection = function(obj){
		Promise.resolve({
			data : {
				url : APPIQUERYURL + "/api/v1/elections/current",
				data : new Array(),
				type : 'GET'
			},
			this : obj.this,
			electionType : 'current',
			activity : obj.data
		}).then(this.PromiseAjax)
		.then(function(obj){
			return new Promise(function(resolve,reject){
				obj.this.currentElections = obj.data;
				return resolve(obj);
			})
		})
		.then(this.appendElection)
		.catch(function(err){
			console.log(err);
		});
	}

	Chat.prototype.showPreviousElection = function(obj){
		Promise.resolve({
			data : {
				url : APPIQUERYURL + "/api/v1/elections/previous",
				data : new Array(),
				type : 'GET'
			},
			this : obj.this,
			electionType : 'previous',
			activity : obj.data
		}).then(this.PromiseAjax)
		.then(function(obj){
			return new Promise(function(resolve,reject){
				obj.this.previousElections = obj.data;
				return resolve(obj);
			})
		})
		.then(this.appendElection)
		.catch(function(err){
			console.log(err);
		});
	}
	// Election functions end

	// Low functions start
	Chat.prototype.showLow = function(){
		Promise.resolve({
			data : {
				url : APPIQUERYURL + "/api/v1/laws/activity",
				data : new Array(),
				type : 'GET'
			},
			this : this,
		}).then(this.PromiseAjax)
		.then(function(obj){
			obj.this.lawActivity = obj.data;
			obj.this.getlow(obj);
		})
		.catch(function(err){
			console.log(err);
		});
	}

	Chat.prototype.getlow = function(obj){
		Promise.resolve({
			data : {
				url : APPIQUERYURL + "/api/v1/laws",
				data : new Array(),
				type : 'GET'
			},
			this : obj.this,
			activity : obj.data
		}).then(this.PromiseAjax)
		.then(this.appendLow)
		.catch(function(err){
			console.log(err);
		});
	}

	Chat.prototype.appendLow = function(obj){
		return new Promise(function(resolve,reject){
			obj.this.Lows = obj.data;
			if(obj.activity.length){
				var table = $('.teacher-row'),
					activity = obj.activity,
					data = obj.data,
					electionType = obj.electionType,
					_this = obj.this,
					summary = '',
					lawType = '',
					result = '';

				var data = {
					this : _this,
					activity : activity,
					lows : data,
					table : table
				}

				_this.LowHtml(data,false);

				return resolve({messages:'Lows is shown.'});
			}else{
				return reject({messages:'No Low.'});
			}
		});
	}

	Chat.prototype.LowHtml = function(data,time){
		var _this = data.this,
			activity = data.activity,
			table = data.table,
			lows = data.lows;

			for(i in activity){
				for(k in lows){
					if(lows[k].Guid == activity[i].Law.Guid){
						summary = _this.joinEvents(activity[i].Events,time);
						if(summary){
							switch(lows[k].State){
								case 'passed' :
									lawType = 'Passed with ';
									break;
								case 'failed' :
									lawType = 'Failed with ';
									break;
								default :
									lawType = ' ';
									break;
							}
							result = lawType + lows[k].VotesYes + ' Yes : ' + lows[k].VotesNo + ' No';
							_this.appendHTML({summary:summary, result:result, table:table, name:lows[k].Title,link:APPIQUERYURL+'/laws.html?lawid='+lows[k].Guid});
						}
					}
				}
			}
	}
	// Low functions end

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
		data.table.append('<div class="row data-row"> <div class="col-md-5"> <p><a href='+data.link+'>'+data.name+'</a></p> </div> <div class="col-md-7 resut-col"> <p>'+data.result+'</p> </div> <div class="col-md-12"> <p class="summary">'+data.summary+'</p> </div> </div>');
	}
	// helper functions end

	// initialization start
	Chat.prototype.bindEvent = function(){
		this.showElection();
		this.showLow();
	}

	// create unique Teacher object
	var chat = new Chat();

	$(window).load(function(){
		chat.bindEvent();
	})
	// initialization end
})()