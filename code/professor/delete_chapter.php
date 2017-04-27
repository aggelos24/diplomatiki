<meta charset="utf-8" />
<?php
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 							//απόπειρα σύνδεσης στη βάση
if (!$link) {														//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'content.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT * FROM chapter WHERE section_number=".$_POST["section_number"]." AND number=".$_POST["chapter_number"]);
															//έλεγχος αν υπάρχει το κεφάλαιο προς διαγραφή
if (empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {									//αν δεν υπάρχει
	$result->free();
	$link->close();													//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Δεν υπάρχει κεφάλαιο με αυτόν τον αριθμό.'); location.href = 'content.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
else {															//αν υπάρχει
	$link->query ("DELETE FROM chapter WHERE section_number=".$_POST["section_number"]." AND number=".$_POST["chapter_number"]);
															//διαγραφή κεφαλαίου από τη βάση
	$result->free();
	$link->close();													//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Το κεφάλαιο διαγράφηκε.'); location.href = 'content.php'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
?>
