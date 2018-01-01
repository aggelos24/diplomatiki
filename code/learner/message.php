<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Μηνύματα </title>
	<script>
		function logout() {									//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function send_message() {								//με το πάτημα του κουμπιού εμφάνιση φόρμας αποστολής μηνύματος
			document.getElementById("bsend_message").classList.add("not_displayed");
			document.getElementById("send_message").classList.remove("not_displayed");
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
	</script>
</head>
<body>
<?php
include "if_not_logged_l.php";										//έλεγχος αν έχει συνδεθεί μαθητής
include "../connect_to_database.php";
$professor_username = "aggelos24";									//ανάθεση του username του καθηγητή σε μεταβλητή
$link = connect_to_database("../login_register_form.php");						//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT user2 FROM friendship WHERE user1='".$_SESSION["session_lusername"]."'");
													//ανάκτηση username φίλων χρήστη από τον πίνακα user
?>
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menul"> <a href="lhome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menul"> <a href="find_friend.php" class="link_to_page"> Βρες φίλους </a> </span>
		<span class="menul"> <a href="history.php" class="link_to_page"> Ιστορία </a> </span>
		<span class="active"> Μηνύματα </span>
		<span class="menul"> <a href="notification.php" class="link_to_page"> Ειδοποιήσεις </a> </span>
	</div>
	<div class="main">
		Αν θες να στείλεις μήνυμα σε κάποιο φίλο σου: <button onclick="send_message()" id="bsend_message"> Πάτησε εδώ </button> <br>
		<div id="send_message" class="not_displayed">
			<form method="post" action="send_message.php?from=message"> <br>
				Προς: <select name="to_user">
<?php
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {						//για κάθε φίλο
	echo "<option value='".$row["user2"]."'> ".$row["user2"]." </option>";				//μενού που να μπορεί να επιλέξει τον παραλήπτη
}
?>
				</select> <br>
				Θέμα: <input type="text" name="subject" required /> <br>
				Κείμενο: <br>
				<textarea name="message_text" rows="6" cols="55" id="message_text" required></textarea> <br>
				<button type="submit"> Αποστολή </button>
			</form>
		</div> <br>
		<span class="big"> Εισερχόμενα Μηνύματα <span class="red_letters"> (τα αδιάβαστα μηνύματα έχουν πιο σκούρο φόντο)</span> | <a href="sent_message.php"> Εξερχόμενα Μηνύματα </a> </span> <br> <br>
		<div class="big container">
			<div class="message_header"> <b> Από τον χρήστη </b> </div>
			<div class="message_header"> <b> Θέμα </b> </div>
			<div class="message_header"> <b> Ημερομηνία που στάλθηκε </b> </div>
		</div>
<?php
$result = $link->query("SELECT count(*) AS inbox FROM message WHERE to_user='".$_SESSION["session_lusername"]."' GROUP BY to_user");
												//ανάκτηση αριθμού εισερχόμενων μηνυμάτων χρήστη από τον πίνακα message
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = $row["inbox"];
if (isset($_GET["pagenum"])) {										//αν υπάρχει η μεταβλητή GET
	$pagenum = $_GET["pagenum"];									//ανάθεσή της σε μεταβλητή
}
else{													//αλλιώς
	$pagenum = 1;											//θέσε τη μεταβλητή σε 1
}
$limit = ($pagenum - 1) * 10;
$result = $link->query("SELECT * FROM message WHERE to_user='".$_SESSION["session_lusername"]."' ORDER BY id DESC LIMIT ".$limit.",10");
													//ανάκτηση 10 το πολύ εισερχόμενων μηνυμάτων χρήστη από τον πίνακα message
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {						//για κάθε εισερχόμενο μήνυμα
	if ($row["from_user"] == $professor_username) {							//αν ο αποστολέας είναι ο καθηγητής
		$from_user = "<b> Καθηγητής </b>";
	}
	else {												//αν ο αποστολέας δεν είναι ο καθηγητής
		$from_user = $row["from_user"];
	}
	if ($row["seen"] == 0) {									//αν δεν έχει διαβαστεί
		echo "<a href='show_message.php?id=".$row["id"]."' class='link_to_page'> <div class='not_seen_message_box'> <div class='container'>".
		"<div class='message_info'>".$from_user."</div>"."<div class='message_info'>".$row["subject"]."</div>"."<div class='message_info'>".date("H:i:s | d-m-Y", strtotime($row["date"]))."</div>";
		echo "</div> </div> </a>";								//εμφάνιση πληροφοριών μηνύματος
	}
	else {												//αν έχει διαβαστεί
		echo "<a href='show_message.php?id=".$row["id"]."' class='link_to_page'> <div class='message_box'> <div class='container'>".
		"<div class='message_info'>".$from_user."</div>"."<div class='message_info'>".$row["subject"]."</div>"."<div class='message_info'>".date("H:i:s | d-m-Y", strtotime($row["date"]))."</div>";
		echo "</div> </div> </a>";								//εμφάνιση πληροφοριών μηνύματος
	}
}
if ($pagenum < ceil($count/10)) {									//αν υπάρχουν μηνύματα σε άλλη σελίδα
	$pagenum++;
	echo "<a href='message.php?pagenum=".$pagenum."'> Επόμενη Σελίδα </a>";				//δημιουργία συνδέσμου για να δει τα επόμενα
	$pagenum--;
}
if ($pagenum > 1) {
	$pagenum--;
	echo "<a href='message.php?pagenum=".$pagenum."'> Προηγούμενη Σελίδα </a>";			//δημιουργία συνδέσμου για να δει τα προηγούμενα
}
$result->free();
$link->close();												//κλείσιμο σύνδεσης με βάση
?>
	</div>
</body>
</html>
