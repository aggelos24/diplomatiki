<meta charset="utf-8" />
<?php
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 					//απόπειρα σύνδεσης στη βάση
if (!$link) {												//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'content.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT * FROM section where number=".$_POST["number"]);			//έλεγχος αν υπάρχει ενότητα με αυτόν τον αριθμό
if (!empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {						//αν υπάρχει
	$result->free();
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Υπάρχει ήδη ενότητα με αυτό τον αριθμό.'); location.href = 'content.php'; </script>";
													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
else {													//αν δεν υπάρχει
	$link->query ("INSERT INTO section (number, title) VALUES (".$_POST["number"].", '".$_POST["title"]."')");
													//εισαγωγή ενότητας στον πίνακα section
	$result->free();
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Η ενότητα προστέθηκε.'); location.href = 'content.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
?>
