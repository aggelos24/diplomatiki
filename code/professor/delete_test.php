<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
if (isset($_GET["id"])) {										//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];										//ανάθεσή της σε μεταβλητή
}
else {													//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'test_list.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test_list.php
	exit();												//τερματισμός script
}
$link = connect_to_database("test_list.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT notification_id FROM test WHERE id=".$id);				//ανάκτηση notification_id από τον πίνακα test
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$notification_id = $row["notification_id"];								//ανάθεσή της σε μεταβλητή
$link->query("DELETE FROM notification WHERE id=".$notification_id);					//διαγραφή ειδοποίησης και τεστ από τους αντίστοιχους πίνακες
$result->free();
$link->close();												//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το τεστ διαγράφηκε.'); location.href = 'test_list.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test_list.php
?>
