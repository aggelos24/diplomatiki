<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Μηνύματα </title>
	<script>
		function logout() {								//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menul"> <a href="lhome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menul"> <a href="find_friend.php" class="link_to_page"> Βρες φίλους </a> </span>
		<span class="menul"> <a href="history.php" class="link_to_page"> Ιστορία </a> </span>
		<span class="menul"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menul"> <a href="notification.php" class="link_to_page"> Ειδοποιήσεις </a> </span>
	</div>
	<div class="main">
		<a href="message.php"> Εισερχόμενα Μηνύματα </a> | Εξερχόμενα Μηνύματα <br> <br>
		<div class="big container">
			<div class="message_header"> <b> Στον χρήστη </b> </div>
			<div class="message_header"> <b> Θέμα </b> </div>
			<div class="message_header"> <b> Ημερομηνία που στάλθηκε </b> </div>
		</div>
<?php
include "if_not_logged_l.php";									//έλεγχος αν έχει συνδεθεί μαθητής
include "../connect_to_database.php";
$professor_username = "aggelos24";								//ανάθεση του username του καθηγητή σε μεταβλητή
$link = connect_to_database("../login_register_form.php");					//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT count(*) AS sent FROM message WHERE from_user='".$_SESSION["session_lusername"]."' GROUP BY from_user");
												//ανάκτηση αριθμού εξερχόμενων μηνυμάτων χρήστη
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = $row["sent"];
if (isset($_GET["pagenum"])) {									//αν υπάρχει η μεταβλητή GET
	$pagenum = $_GET["pagenum"];								//ανάθεσή της σε μεταβλητή
}
else{												//αλλιώς
	$pagenum = 1;										//θέσε τη μεταβλητή σε 1
}
$limit = ($pagenum - 1) * 10;
$result = $link->query("SELECT * FROM message WHERE from_user='".$_SESSION["session_lusername"]."' ORDER BY id DESC LIMIT ".$limit.",10");
												//ανάκτηση 10 το πολύ εξερχόμενων μηνυμάτων χρήστη
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {					//για κάθε εξερχόμενο μήνυμα
	if ($row["to_user"] == $professor_username) {						//αν ο παραλήπτης είναι ο καθηγητής
		$to_user = "Καθηγητής";
	}
	else {
		$to_user = $row["to_user"];
	}
	echo "<a href='show_sent_message.php?id=".$row["id"]."' class='link_to_page'> <div class='message_box'> <div class='container'>";
	echo "<div class='message_info'>".$to_user."</div>"."<div class='message_info'>".$row["subject"]."</div>"."<div class='message_info'>".date("H:i:s | d-m-Y", strtotime($row["date"]))."</div>";
	echo "</div> </div> </a>";								//εμφάνιση πληροφοριών μηνύματος
}
if ($pagenum < ceil($count/10)) {								//αν υπάρχουν μηνύματα σε άλλη σελίδα
	$pagenum++;
	echo "<a href='sent_message.php?pagenum=".$pagenum."'> Επόμενη Σελίδα </a>";		//δημιουργία συνδέσμου για να δει τα επόμενα
	$pagenum--;
}
if ($pagenum > 1) {
	$pagenum--;
	echo "<a href='sent_message.php?pagenum=".$pagenum."'> Προηγούμενη Σελίδα </a>";	//δημιουργία συνδέσμου για να δει τα προηγούμενα
}
$result->free();
$link->close();											//κλείσιμο σύνδεσης με βάση
?>
	</div>
</body>
</html>
