<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$link = connect_to_database("content.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query ("SELECT * FROM section where number=".$_POST["number"]);			//έλεγχος αν υπάρχει ενότητα με αυτόν τον αριθμό στον πίνακα section
if (empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {							//αν δεν υπάρχει
	$result->free();
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Δεν υπάρχει ενότητα με αυτόν τον αριθμό.'); location.href ='content.php'; </script>";
													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
else {													//αν υπάρχει
	$link->query ("DELETE FROM section WHERE number=".$_POST["number"]);				//διαγραφή ενότητας από τον πίνακα section
	$result->free();
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Η ενότητα διαγράφηκε.'); location.href = 'content.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
?>
