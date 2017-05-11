$(document).ready(function(){
    
	
	var pollServer = function() {
		
		$.get('chat.php', function(result) {
			
			if(!result.success) {
				console.log("Error polling server for new messages");
				return;
			}
			
			for(var index = 0; index < result.messages.length; index++) {
				
				var chatBubble
				
				if(result.messages[index].sent_by == 'self') {
					
					chatBubble = $('<div class ="row bubble-sent pull-right">' +
							result.messages[index].message + '</div><div class="clearfix"></div>');
					
				} else {
					
					chatBubble = $('<div class ="row bubble-recv">' +
							result.messages[index].message + ' <br> Sent By: ' + result.messages[index].user + '</div><div class="clearfix"></div>');
				}
				
				$('#chatPanel').append(chatBubble);
				
			}
			
			setTimeout(pollServer, 3000);
		});
		
	};
	
	
	$(document).on('ready', function() {
		
		pollServer();
		
		$('button').click(function() {
			$(this).toggleClass('active');
		});
	});
	
	
	$('#sendMessageBtn').on('click', function(event) {
		
		
		event.preventDefault();
		
		var message = $('#chatMessage').val();
		
		$.post('chat.php', {'message':message}, 
				function(result) {
			
			if(!result.success) {
				
				alert("Error sending message!");
			} else {
				
				console.log('Message sent!');
				$('#chatMessage').val('');
			}
		});
		
	});
	
	pollServer();
});