var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8090, function() {
    console.log('listening on *:8090');
});

io.on('connection',function(socket){
	console.log('Co nguoi vua ket noi: '+socket.id)
})
var Redis = require('ioredis')
var redis = new Redis(6379)
redis.psubscribe("*",function(error,count){
	//
})
redis.on('pmessage',function(partner,channel,message){
	console.log(channel)
	console.log(message)
	console.log(partner)

	message = JSON.parse(message)
  io.emit(channel,message);
	console.log('Sent');
})


