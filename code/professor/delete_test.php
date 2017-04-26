<meta charset="utf-8" />
<?php
if (isset($_GET["id"])) {																				//αν υπάρχει η μεταβλητή GET																											
	$id = $_GET["id"];																					//ανάθεσή της σε μεταβλητή
}
else {																									//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'test_list.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test_list.php
}
$link = mysqli_connect("localhost", "root", "", "diplomatiki"); 										//απόπειρα σύνδεσης στη βάση
if (!$link) {																							//αν αποτυχία
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'test_list.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test_list.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT notification_id FROM test WHERE id=".$id);								//ανάκτηση notification_id από τον πίνακα test
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$notification_id = $row["notification_id"];																//ανάθεσή της σε μεταβλητή
$link->query ("DELETE FROM notification WHERE id=".$notification_id);									//διαγραφή ειδοποίησης και τεστ από τους αντίστοιχους πίνακες
$result->free();
$link->close();																							//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το τεστ διαγράφηκε.'); location.href = 'test_list.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test_list.php
?>