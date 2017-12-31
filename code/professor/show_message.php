<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Μηνύματα </title>
	<script>
		function logout() {					//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			window.location = "logout.php";
		}
		
		function reply_message() {				//με το πάτημα του κουμπιού εμφάνιση φόρμας αποστολής μηνύματος
			document.getElementById("breply_message").classList.add("not_displayed");
			document.getElementById("reply_message").classList.remove("not_displayed");
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menup"> <a href="phome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menup"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menup"> <a href="content.php" class="link_to_page"> Διδακτικό περιεχόμενο </a> </span>
		<span class="menup"> <a href="group_project.php" class="link_to_page"> Εργασίες </a> </span>
		<span class="menup"> <a href="test.php" class="link_to_page"> Τεστ </a> </span>
	</div>
	<div class="main">
<?php
include "if_not_logged_p.php";						//έλεγχος αν έχει συνδεθεί ο καθηγητής
include "../connect_to_database.php";
if ((isset($_GET["id"]))) {						//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];						//ανάθεσή της σε μεταβλητή
}
else {									//αν όχι
	echo "<script> alert('Κάτι πήγε στραβά.'); window.location = 'message.php'; </script>";
									//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα message.php
	exit();								//τερματισμός script
}
$link = connect_to_database("../login_register_form.php");		//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM message WHERE id=".$id);		//ανάκτηση στοιχείων μηνύματος από τον πίνακα message
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
		<b> Από το μαθητή: </b> <?php echo $row["from_user"]; ?> <br>
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
				<textarea name="message_text" rows="8" cols="80" id="message_text" required></textarea> <br>
				<button type="submit"> Αποστολή </button>
			</form>
		</div> <br> <br>
		<a href="message.php"> Επιστροφή στα Εισερχόμενα Μηνύματα </a>
		</div>
<?php
$link->query("UPDATE message SET seen=1 WHERE id=".$id);		//ενημέρωση του πίνακα message ότι ο χρήστης διάβασε το μήνυμα
$result->free();
$link->close();								//κλείσιμο σύνδεσης με βάση
?>
</body>
</html>
