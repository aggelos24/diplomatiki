<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Μηνύματα </title>
	<script>
		function logout() {						//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="menu">
		<span class="menul"> <a href="lhome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menul"> <a href="find_friend.php" class="link_to_page"> Βρες φίλους </a> </span>
		<span class="menul"> <a href="history.php" class="link_to_page"> Ιστορία </a> </span>
		<span class="menul"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menul"> <a href="notification.php" class="link_to_page"> Ειδοποιήσεις </a> </span>
	</div>
	<div class="main">
<?php
include "if_not_logged_l.php";							//έλεγχος αν έχει συνδεθεί μαθητής
include "../connect_to_database.php";
$link = connect_to_database("sent_message.php");				//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
if ((isset($_GET["id"]))) {							//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];							//ανάθεσή της σε μεταβλητή
}
else {										//αν όχι
echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'sent_message.php'; </script>";
										//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα sent_message.php
}
$result = $link->query ("SELECT * FROM message WHERE id=".$id);			//ανάκτηση στοιχείων μηνύματος από τον πίνακα message
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row["to_user"] == "aggelos24") {						//αν ο παραλήπτης είναι ο καθηγητής
	$row["to_user"] = "Καθηγητής";
}
$result->free();
$link->close();									//κλείσιμο σύνδεσης με βάση
?>
		<b> Στο χρήστη: </b> <?php echo $row["to_user"]; ?> <br>
		<b> Θέμα: </b> <?php echo $row["subject"]; ?> <br>
		<b> Ημερομηνία που στάλθηκε: </b> <?php echo date("H:i:s | d-m-Y", strtotime($row["date"])); ?> <br>
		<b> Κείμενο: </b> <br>
		<?php echo str_replace("\n", "\n<br>", $row["text"]); ?> <br> <br>
		<a href="sent_message.php"> Επιστροφή στα Εξερχόμενα Μηνύματα </a>
	</div>
</body>
</html>
