<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$link = connect_to_database("test.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
if (isset($_GET["id"])) {										//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];										//ανάθεσή της σε μεταβλητή
}
else {													//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'test.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test.php
}
$link->query ("DELETE FROM question_and_answer WHERE id=".$id);						//διαγραφή ερωτήματος από τον πίνακα question_and_answer
$link->close();												//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το ερώτημα διαγράφηκε.'); location.href = 'test.php'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test.php
?>
