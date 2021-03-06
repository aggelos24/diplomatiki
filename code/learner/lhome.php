<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Κεντρική Σελίδα </title>
	<script>
		function show_notification_message() {							//συνάρτηση εμφάνισης αριθμού αδιάβαστων ειδοποιήσεων και μηνυμάτων
			var xmlhttp;
			xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("show_notification_message").innerHTML = xmlhttp.responseText;
													//προβολή αριθμού αδιάβαστων ειδοποιήσεων και μηνυμάτων
				}
			}
			xmlhttp.open("GET","show_notification_message.php",true);
			xmlhttp.send();
		}
		
		function delete_photo() {								//με το πάτημα του κουμπιού διαγραφή φωτογραφίας
			location.href = "delete_photo.php";
		}
		
		function upload_photo() {								//με το πάτημα του κουμπιού εμφάνιση φόρμας φωτογραφίας
			document.getElementById("bupload_photo").classList.add("not_displayed");
			document.getElementById("upload_photo").classList.remove("not_displayed");
		}
		
		function insert_description() {								//με το πάτημα του κουμπιού εμφάνιση φόρμας περιγραφής
			document.getElementById("binsert_description").classList.add("not_displayed");
			document.getElementById("insert_description").classList.remove("not_displayed");
			adjust_textarea();
		}
		
		function logout() {									//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function send_message_to_professor() {							//με το πάτημα του κουμπιού αποστολή μηνύματος στον καθηγητή
			document.getElementById("bsend_message_to_professor").classList.add("not_displayed");
			document.getElementById("send_message_to_professor").classList.remove("not_displayed");
			adjust_textarea();
		}
		
		function adjust_textarea() {								//προσαρμογή αριθμού στηλών ανάλογα με μέγεθος οθόνης
			if (window.innerWidth < 1100) {							//αν το πλάτος του παραθύρου είναι κάτω απο 1100 pixels
				document.getElementById("message_text").setAttribute("cols", "40");
				document.getElementById("description").setAttribute("cols", "40");
			}
			else {										//αλλιώς
				document.getElementById("message_text").setAttribute("cols", "55");
				document.getElementById("description").setAttribute("cols", "55");  
			}
		}
		
		show_notification_message();
		setInterval("show_notification_message()", 1000);					//κάθε 1 δευτερόλεπτο έλεγχος αν υπάρχουν νέες ειδοποιήσεις και μηνύματα
						
		window.onresize = function() {								//όταν μεταβάλλεται το μέγεθος του παραθύρου
			adjust_textarea();
		}
	</script>
</head>
<body>																									
	<button class="logout" onclick="logout()"> Αποσύνδεση </button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="active"> Αρχική </span>
		<span class="menul"> <a href="find_friend.php" class="link_to_page"> Βρες φίλους </a> </span>
		<span class="menul"> <a href="history.php" class="link_to_page"> Ιστορία </a> </span>
		<span class="menul"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menul"> <a href="notification.php" class="link_to_page"> Ειδοποιήσεις </a> </span>
	</div>
	<div class="main">
<?php
include "if_not_logged_l.php";										//έλεγχος αν έχει συνδεθεί μαθητής
?>
		<span class="big"> Καλώς όρισες χρήστη <?php echo $_SESSION["session_lusername"]; ?> <span id="show_notification_message"> </span> </span> <br> <br>
		Το email σου είναι <?php echo $_SESSION["session_lemail"]; ?> <span class="red_letters">(θα φαίνεται μόνο στους φίλους σου)</span> <br>
<?php
if (!(isset($_SESSION["session_lphoto"]))) {								//αν δεν έχει καταχωρήσει ακόμα κάποια φωτογραφία
	echo "Δεν έχεις ανεβάσει φωτογραφία προφίλ ακόμα <br>";						//εμφάνιση κατάλληλου μηνύματος
}
if (!(isset($_SESSION["session_ldescription"]))) {							//αν δεν έχει καταχωρήσει ακόμα κάποια περιγραφή 
	echo "Δεν έχεις γράψει κάποια περιγραφή για τον εαυτό σου <br><br>";				//εμφάνιση κατάλληλου μηνύματος
}
?>
		Αν θες να ανεβάσεις νέα φωτογραφία προφίλ <span class="red_letters">(αν έχεις ήδη θα αντικατασταθεί)</span> ή να διαγράψεις την υπάρχουσα: <button onclick="upload_photo()" id="bupload_photo"> Πάτησε εδώ </button> <br>
		<div id="upload_photo" class="not_displayed">
			<form method="post" action="upload_photo.php" enctype="multipart/form-data"> <br>
				<input type="file" name="photo" accept="image/*" required />
				<button type="submit"> Πάτησε εδώ για να ανεβάσεις τη φωτογραφία </button> <br>
			</form>
			<button onclick="delete_photo()"> Διαγραφή Φωτογραφίας </button> <br>
		</div>
		Αν θες να γράψεις μια περιγραφή για τον εαυτό σου, ή να αλλάξεις την περιγραφή που έχεις ήδη γράψει: <button onclick="insert_description()" id="binsert_description"> Πάτησε εδώ </button> <br>
		<div id="insert_description" class="not_displayed">
			<form method="post" action="insert_description.php"> <br>
				Κείμενο Περιγραφής: <br>
				<textarea name="description_text" rows="6" cols="55" id="description"><?php echo $_SESSION["session_ldescription"];?></textarea> <br>
				<button type="submit"> Πάτησε εδώ αν τελείωσες </button>
			</form>
		</div>
		Αν θες να στείλεις μήνυμα στον καθηγητή: <button onclick="send_message_to_professor()" id="bsend_message_to_professor"> Πάτησε εδώ </button> <br>
		<div id="send_message_to_professor" class="not_displayed">
			<form method="post" action="send_message.php?from=lhome">
				Προς: <input type="text" name="to_user" value="Καθηγητής" readonly /> <br>
				Θέμα: <input type="text" name="subject" required /> <br>
				Κείμενο: <br>
				<textarea name="message_text" rows="6" cols="55" id="message_text" required></textarea> <br>
				<button type="submit"> Αποστολή </button>
			</form>
		</div> <br>
		<div class="center"> <a href="my_profile.php"> Προεπισκόπηση του προφίλ μου </a> </div>
	</div>
</body>
</html>
