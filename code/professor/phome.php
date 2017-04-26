<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Κεντρική Σελίδα </title>
	<script>
		function show_hint(str) {																					//με το πάτημα του κουμπιού στο πεδίο για το όνομα χρήστη
			if (str.length == 0) {
				document.getElementById("hint").innerHTML="";
				return;
			}
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("hint").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","get_hint.php?input="+str, true);
			xmlhttp.send();
		}
		
		function show_message_live() {																				//συνάρτηση εμφάνισης αριθμού αδιάβαστων μηνυμάτων
			var xmlhttp;
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("show_message_live").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","show_message_live.php",true);
			xmlhttp.send();
		}
		
		function logout() {																							//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function show_learner_list() {																				//με το πάτημα του κουμπιού εμφάνιση λίστας χρηστών
			location.href = "show_learner_list.php";
		}
		
		function send_message() {																					//με το πάτημα του κουμπιού εμφάνιση φόρμας αποστολής μηνύματος
			document.getElementById("bsend_message").style.display = "none";
			document.getElementById("send_message").style.display = "inline";
		}
		
		show_message_live();
		setInterval("show_message_live()", 4000);																	//κάθε 1 δευτερόλεπτο έλεγχος αν υπάρχουν νέα μηνύματα
	</script>
</head>
<body>
<?php
include "if_not_logged_p.php";																						//έλεγχος αν έχει συνδεθεί ο καθηγητής
?>																									
	<button class="logout" onclick="logout()"> Αποσύνδεση </button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="menu">
		<span class="active"> Αρχική </span>
		<span class="menup"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menup"> <a href="content.php" class="link_to_page"> Διδακτικό περιεχόμενο </a> </span>
		<span class="menup"> <a href="group_project.php" class="link_to_page"> Εργασίες </a> </span>
		<span class="menup"> <a href="test.php" class="link_to_page"> Τεστ </a> </span>
	</div>
	<div class="main">
		Καλως όρισες <br>
		<div id="show_message_live"> </div>
		Αν θες να δεις λίστα με τους μαθητές <button onclick="show_learner_list()" id="bphoto"> Πάτησε εδώ </button> <br>
		Αν θες να στείλεις μήνυμα σε κάποιο μαθητή <button onclick="send_message()" id="bsend_message"> Πάτησε εδώ </button> <br>
		<div id="send_message" class="not_displayed">
			<form method="post" action="send_message.php"> <br>
				Προς μαθητή <input type="text" name="to_user" onkeyup="show_hint(this.value)" required /> Μαθητές: <span id="hint" > </span> <br>
				Θέμα <input type="text" name="subject" required /> <br>
				Κείμενο: <br>
				<textarea name="message_text" rows="8" cols="80" id="message_text" required></textarea> <br>
				<button type="submit"> Αποστολή </button>
			</form>
		</div>
	</div>
</body>
</html>