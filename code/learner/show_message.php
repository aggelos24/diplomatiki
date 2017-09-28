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
		
		function reply_message() {							//με το πάτημα του κουμπιού εμφάνιση φόρμας αποστολής μηνύματος
			document.getElementById("breply_message").style.display = "none";
			document.getElementById("reply_message").style.display = "inline";
			if (window.innerWidth < 1100){						//προσαρμογή αριθμού στηλών ανάλογα με μέγεθος οθόνης
				document.getElementById("message_text").setAttribute("cols", "40");
			}
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
include "if_not_logged_l.php";									//έλεγχος αν έχει συνδεθεί μαθητής
include "../connect_to_database.php";
$professor_username = "aggelos24";								//ανάθεση του username του καθηγητή σε μεταβλητή
if ((isset($_GET["id"]))) {									//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];									//ανάθεσή της σε μεταβλητή
}
else {												//αν όχι
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'message.php'; </script>";	
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα message.php
	exit();											//τερματισμός script
}
$link = connect_to_database("../login_register_form.php");					//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM message WHERE id=".$id);					//ανάκτηση στοιχείων μηνύματος από τον πίνακα message
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row["from_user"] == $professor_username) {							//αν ο αποστολέας είναι ο καθηγητής
	 $from_user = "Καθηγητής";
}
else {												//αν όχι
	$from_user = $row["from_user"];
}
?>
		<b> Από το χρήστη: </b> <?php echo $row["from_user"]; ?> <br>
		<b> Θέμα: </b> <?php echo $row["subject"]; ?> <br>
		<b> Ημερομηνία που στάλθηκε: </b> <?php echo date("H:i:s | d-m-Y", strtotime($row["date"])); ?> <br>
		<b> Κείμενο: </b> <br>
		<?php echo str_replace("\n", "\n<br>", $row["text"]); ?> <br>
		<button onclick="reply_message()" id="breply_message"> Για απάντηση πάτησε εδώ </button>
		<div id="reply_message" class="not_displayed">
			<form method="post" action="send_message.php?from=message">
				Προς: <input type="text" name="to_user" value="<?php echo $row["from_user"]; ?>" readonly /> <br>
				Θέμα: <input type="text" name="subject" value="<?php echo $row["subject"]; ?>" required /> <br>
				Κείμενο: <br>
				<textarea name="message_text" rows="6" cols="55" id="message_text" required></textarea> <br>
				<button type="submit"> Αποστολή </button>
			</form>
		</div> <br> <br>
		<a href="message.php"> Επιστροφή στα Εισερχόμενα Μηνύματα </a>
		</div>
<?php
$link->query("UPDATE message SET seen=1 WHERE id=".$id);					//ενημέρωση πίνακα message ότι ο χρήστης διάβασε το μήνυμα
$result->free();
$link->close();											//κλείσιμο σύνδεσης με βάση
?>
</body>
</html>
