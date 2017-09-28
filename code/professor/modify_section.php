<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$link = connect_to_database("../login_register_form.php");				//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM section where number=".$_POST["number"]);		//έλεγχος αν υπάρχει ενότητα με αυτόν τον αριθμό
if (empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {					//αν δεν υπάρχει
	$result->free();
	$link->close();									//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Δεν υπάρχει ενότητα με αυτόν τον αριθμό.'); location.href = 'content.php'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
	exit();										//τερματισμός script
}
else {											//αν υπάρχει
	$link->query("UPDATE section SET title='".$_POST["title"]."' WHERE number=".$_POST["number"]);
											//ενήμερωση πίνακα section
	$result->free();
	$link->close();									//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Η ενότητα μετονομάστηκε.'); location.href = 'content.php'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
?>
