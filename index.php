<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Global chat</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
	
	<div id="wrapper">
	    <h1>Welcome <?php session_start(); echo $_SESSION['user']; ?> to global chat app!</h1> 
		<div class="chat_wrapper">
			<form action="" id="nameChange">
				<span><?php echo $_SESSION['user'] . ":"; ?></span>
				<input type="text" id="nameInput" placeholder="Change name">
				<button type="submit">Change</button>
			</form> 	
			
			<div id="abc"></div>
			<div id="chat"></div>

			<form method="" id="messageForm">
				<textarea name="message" cols="30" rows="7" id="textarea" class="textarea" placeholder="Type a message to send"></textarea>
                <button class="submit" id="formSubmit" type="submit">Submit</button>
			</form>

		</div>


	</div>
	
	<script>
		let textarea = document.getElementById("textarea");
		let chat = document.getElementById("chat");
		let form = document.getElementById("messageForm");
		let nameChange = document.getElementById("nameChange");

		LoadChat();
		setInterval(function(){
			LoadChat();
		}, 1000);

		nameChange.onsubmit = function() {
			let newName = document.getElementById("nameInput").value.trim();
			if (newName.length > 0) {
				fetch("setUser.php?action=changeName&name="+newName).then(async (response) => {
					if( await response.ok){
						LoadChat();
						nameChange.reset();
						location.reload()
					}
				});
			}
			return false;

		}

		function LoadChat(){
			fetch("database.php?action=getMessages").then(async (response) => {
				const text = await response.text();
				let scrollpos = chat.scrollTop;
				scrollpos = parseInt(scrollpos) + 520;
				let scrollHeight = chat.scrollHeight;

				chat.innerHTML = text;

				if( scrollpos >= scrollHeight ){
					chat.scrollTop = chat.scrollHeight;
				}
			} )
		}

		
		form.onkeyup = function(event){
			if( event.key == "Enter" ){
				document.getElementById("formSubmit").click()
			}
		};


		form.onsubmit = function(event){
			let message = textarea.value.trim();
			if (message.length > 0) {
				fetch("database.php?action=sendMessage&message="+message).then(async (response) => {
					if( await response.ok){
						LoadChat();
						form.reset();
					}
				});
				
			}
			return false;
		};
	</script>
</body>
</html> 
