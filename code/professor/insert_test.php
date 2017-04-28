<meta charset="utf-8" />
<?php
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 						//απόπειρα σύνδεσης στη βάση
if (!$link) {													//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'insert_test_form.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_test_form.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT username FROM user where username='".$_POST["user"]."'");			//έλεγχος αν το όνομα χρήστη υπάρχει στη βάση
if (empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {								//αν δεν υπάρχει
	$result->free();
	$link->close();												//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Δεν υπάρχει μαθητής με αυτό το Όνομα Χρήστη.'); location.href = 'insert_test_form.php'; </script>";
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_test_form.php
}
if ($_POST["section_number"] > 0) {
	$section_number = $_POST["section_number"];
	$result = $link->query ("SELECT * FROM section WHERE number=".$section_number);				//έλεγχος αν υπάρχει ενότητα με αυτό τον αριθμό στον πίνακα section
	if (empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {							//αν δεν υπάρχει
		$result->free();
		$link->close();											//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Δεν υπάρχει ενότητα με αυτό τον αριθμό.'); location.href = 'insert_test_form.php'; </script>";
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_test_form.php
	}
	$minimum_question_num = 4;
	$result = $link->query ("SELECT count(*) AS difficult_num FROM question_and_answer WHERE difficult=1 AND section_number=".$section_number);
														//ανάκτηση αριθμού δύσκολων ερωτημάτων από τον πίνακα question_and_answer
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if ($row["difficult_num"] < $minimum_question_num) {							//αν ο αριθμός των δύσκολων ερωτημάτων είναι μικρότερος του ελάχιστου
		$result->free();
		$link->close();											//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Δεν υπάρχουν αρκετές δύσκολες ερωτήσεις.'); location.href = 'insert_test_form.php'; </script>";
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_test_form.php
	}
	$result = $link->query ("SELECT count(*) AS easy_num FROM question_and_answer WHERE difficult=0 AND section_number=".$section_number);
														//ανάκτηση αριθμού εύκολων ερωτημάτων από τον πίνακα question_and_answer
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if ($row["easy_num"] < $minimum_question_num) {								//αν ο αριθμός των δύσκολων ερωτημάτων είναι μικρότερος του ελάχιστου
		$result->free();
		$link->close();											//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Δεν υπάρχουν αρκετές εύκολες ερωτήσεις.'); location.href = 'insert_test_form.php'; </script>";
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_test_form.php
	}
}
else if ($_POST["section_number"] == 0) {									//αν το τεστ είναι εφ' όλης της ύλης
	$section_number = "NULL";
	$minimum_question_num = 9;
	$result = $link->query ("SELECT count(*) AS difficult_num FROM question_and_answer WHERE difficult=1");
														//ανάκτηση αριθμού δύσκολων ερωτημάτων από τον πίνακα question_and_answer
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if ($row["difficult_num"] < $minimum_question_num) {							//αν ο αριθμός των δύσκολων ερωτημάτων είναι μικρότερος του ελάχιστου
		$result->free();
		$link->close();											//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Δεν υπάρχουν αρκετές δύσκολες ερωτήσεις.'); location.href = 'insert_test_form.php'; </script>";
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_test_form.php
	}
	$result = $link->query ("SELECT count(*) AS easy_num FROM question_and_answer WHERE difficult=0");	//ανάκτηση αριθμού εύκολων ερωτημάτων από τον πίνακα question_and_answer
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if ($row["easy_num"] < $minimum_question_num) {								//αν ο αριθμός των δύσκολων ερωτημάτων είναι μικρότερος του ελάχιστου
		$result->free();
		$link->close();											//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Δεν υπάρχουν αρκετές εύκολες ερωτήσεις.'); location.href = 'insert_test_form.php'; </script>";
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_test_form.php
	}
}
else {
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'insert_test_form.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_test_form.php
}

$notification_text = "Στις ".date("d-m-Y", strtotime($_POST["test_date"]))." έχεις τεστ";
$link->query ("INSERT INTO notification (id, to_user, text, seen, display) VALUES (DEFAULT, '".$_POST["user"]."', '".$notification_text."', DEFAULT, DEFAULT)");
														//δημιουργία ειδοποίησης στο μαθητή
$notification_id = $link->insert_id;										//ανάθεση του id της ειδοποίησης σε μεταβλητή 
$link->query ("INSERT INTO test (id, section_number, user, test_date, status, notification_id) VALUES (DEFAULT, ".$section_number.", '".$_POST["user"]."', '".$_POST["test_date"]."', 'pending', ".$notification_id.")");
														//δημιουργία τεστ
$result->free();
$link->close();													//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το τεστ δημιουργήθηκε.'); location.href = 'insert_test_form.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα insert_test_form.php
?>
