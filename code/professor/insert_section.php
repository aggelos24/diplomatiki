<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$link = connect_to_database("../login_register_form.php");						//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM section where number=".$_POST["number"]);				//έλεγχος αν υπάρχει ενότητα με αυτόν τον αριθμό
if (!empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {						//αν υπάρχει
	echo "<script> alert('Υπάρχει ήδη ενότητα με αυτό τον αριθμό.'); location.href = 'content.php'; </script>";
													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
else {													//αν δεν υπάρχει
	$link->query("INSERT INTO section (number, title) VALUES (".$_POST["number"].", '".$_POST["title"]."')");
													//εισαγωγή ενότητας στον πίνακα section
	echo "<script> alert('Η ενότητα προστέθηκε.'); location.href = 'content.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
$result->free();
$link->close();											//κλείσιμο σύνδεσης με βάση
?>
