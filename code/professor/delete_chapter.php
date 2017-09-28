<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$link = connect_to_database("../login_register_form.php");						//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM chapter WHERE section_number=".$_POST["section_number"]." AND number=".$_POST["chapter_number"]);
													//έλεγχος αν υπάρχει το κεφάλαιο προς διαγραφή
if (empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {							//αν δεν υπάρχει
	$result->free();
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Δεν υπάρχει κεφάλαιο με αυτόν τον αριθμό.'); location.href = 'content.php'; </script>";
													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
	exit();												//τερματισμός script
}
else {													//αν υπάρχει
	$link->query("DELETE FROM chapter WHERE section_number=".$_POST["section_number"]." AND number=".$_POST["chapter_number"]);
													//διαγραφή κεφαλαίου από τη βάση
	$result->free();
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Το κεφάλαιο διαγράφηκε.'); location.href = 'content.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
?>
