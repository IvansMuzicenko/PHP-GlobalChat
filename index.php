<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Global chat</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
    <script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
</head>
<body>
	
	<div id="wrapper">
	    <h1>Welcome <?php session_start(); echo $_SESSION['user']; ?> to global chat app!</h1>  	
		<div class="chat_wrapper">
			
			<div id="abc"></div>
			<div id="chat"></div>

			<form method="POST" id="messageForm">
				<textarea name="message" cols="30" rows="7" id="textarea" class="textarea" placeholder="Type a message to send"></textarea>
                <button class="submit" type="submit">Submit</button>
			</form>

		</div>


	</div>
	
	<script>
		LoadChat();

		setInterval(function(){
			LoadChat();
		}, 1000);

		function LoadChat(){
			$.post('database.php?action=getMessages', function(response){
				let scrollpos = $('#chat').scrollTop();
				scrollpos = parseInt(scrollpos) + 520;
				let scrollHeight = $('#chat').prop('scrollHeight');

				$('#chat').html(response);

				if( scrollpos >= scrollHeight ){
					$('#chat').scrollTop( $('#chat').prop('scrollHeight') );
				}
			});
		}
		
		$('#textarea').keyup(function(e){
			if( e.which == 13 ){
				$('form').submit();
			}
		});


		$('form').submit(function(){
			let message = $('#textarea').val();

			$.post('database.php?action=sendMessage&message='+message, function(response){
				if( response == 1 ){
					LoadChat();
					document.getElementById('messageForm').reset();
				}
			});
			return false;
		});
	</script>
</body>
</html> 
