<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$link = connect_to_database("test.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
if (!isset($_POST["difficult"])) {									//αν είναι κενό το πεδίο δυσκολίας
	echo "<script> alert('Δεν επέλεξες δυσκολία.'); location.href = 'test.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test.php
}
$result = $link->query ("SELECT * FROM section WHERE number=".$_POST["section_number"]);		//έλεγχος αν υπάρχει ενότητα με αυτό τον αριθμό στον πίνακα section
if (empty(mysqli_fetch_array($result, MYSQLI_ASSOC))) {							//αν υπάρχει
	$result->free();
	$link->close();											//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Δεν υπάρχει ενότητα με αυτό τον αριθμό.'); location.href = 'test.php'; </script>";
													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test.php
}
$link->query ("INSERT INTO question_and_answer (id, section_number, difficult, question_text, correct_answer, wrong_answer_1, wrong_answer_2, wrong_answer_3) VALUES (DEFAULT, ".$_POST["section_number"].", ".$_POST["difficult"].", '".$_POST["question"]."', '".$_POST["correct_answer"]."', '".$_POST["wrong_answer_1"]."', '".$_POST["wrong_answer_2"]."', '".$_POST["wrong_answer_3"]."')");
													//εισαγωγή ερωτήματος στον πίνακα question_and_answer
$result->free();
$link->close();												//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το ερώτημα προστέθηκε.'); location.href = 'test.php'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test.php
?>
