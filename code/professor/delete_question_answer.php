<meta charset="utf-8" />
<?php
if (isset($_GET["id"])) {																			//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];																				//ανάθεσή της σε μεταβλητή
}
else {																								//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'test.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test.php
}
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 									//απόπειρα σύνδεσης στη βάση
if (!$link) {																						//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'test.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$link->query ("DELETE FROM question_and_answer WHERE id=".$id);										//διαγραφή ερωτήματος από τον πίνακα question_and_answer
$link->close();																						//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το ερώτημα διαγράφηκε.'); location.href = 'test.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test.php
?>