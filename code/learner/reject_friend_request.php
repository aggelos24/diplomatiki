<meta charset="utf-8" />
<?php
if ((isset($_GET["id"]))) {																						//αν υπάρχει η μεταβλητή GET
	$friendship_id = $_GET["id"];																				//ανάθεσή της σε μεταβλητή
}
else {																											//αν όχι
echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'notification.php'; </script>";						//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα notification.php
}
session_start();																								//δημιουργία συνεδρίας
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 												//απόπειρα σύνδεσης στη βάση
if (!$link) {																									//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'notification.php'; </script>";					//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα notification.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$link->query ("UPDATE friend_request SET status='rejected' WHERE id=".$friendship_id);							//ενημέρωση του πίνακα friend_request
$result=$link->query ("SELECT notification_id FROM friend_request WHERE id=".$friendship_id);					//ανάκτηση id ειδοποίησης από τον πίνακα notification
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$link->query ("UPDATE notification SET display=0 WHERE id=".$row["notification_id"]);							//κάνε την ειδοποίηση να μην φαίνεται
$result->free();
$link->close();																									//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Απέρριψες το αίτημα φιλίας.'); location.href = 'notification.php'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα notification.php
?>