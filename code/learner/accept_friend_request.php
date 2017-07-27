<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
if ((isset($_GET["id"]))) {											//αν υπάρχει η μεταβλητή GET
	$friendship_id = $_GET["id"];										//ανάθεσή της σε μεταβλητή
}
else {														//αν όχι
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'notification.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα notification.php
	exit();													//τερματισμός script
}
session_start();												//δημιουργία συνεδρίας
$link = connect_to_database("notification.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$link->query("UPDATE friend_request SET status='accepted' WHERE id=".$friendship_id);				//ενημέρωση του πίνακα friend_request
$result = $link->query("SELECT from_user, notification_id FROM friend_request WHERE id=".$friendship_id);	//ανάκτηση username αυτού που έστειλε το αίτημα, και το id της ειδοποίησης
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$user = $row["from_user"];
$link->query("UPDATE notification SET display=0 WHERE id=".$row["notification_id"]);				//κάνε την ειδοποίηση να μην φαίνεται
$link->query("INSERT INTO friendship (user1, user2) VALUES ('".$user."', '".$_SESSION["session_lusername"]."')");
														//ενημέρωση του πίνακα friendship
$link->query("INSERT INTO friendship (user1, user2) VALUES ('".$_SESSION["session_lusername"]."', '".$user."')");
$result->free();
$link->close();													//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Αποδεχτήκατε το αίτημα φιλίας.'); location.href = 'notification.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα notification.php
?>
