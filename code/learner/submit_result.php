<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
session_start();										//δημιουργία συνεδρίας
if (isset($_GET["id"])) {									//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];									//ανάθεση σε μεταβλητή
}
else {												//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'history.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα history.php
	exit();											//τερματισμός script
}
$link = connect_to_database("../login_register_form.php");					//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT section_number FROM test WHERE id=".$id);			//ανάκτηση στοιχείων τεστ από τον πίνακα test
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row["section_number"] != NULL) {								//αν το τεστ είναι σε κάποια συγκεκριμένη ενότητα
	$score = $_POST["question_1"]+$_POST["question_2"]+$_POST["question_3"]+$_POST["question_4"]+$_POST["question_5"];
												//υπολογισμός βαθμολογίας
	if (($score >= 4) and ($_SESSION["session_llevel"] != 6)) {				//αν η βαθμολογία είναι μεγαλύτερη ή ίση του 4 και το επίπεδο δεν είναι 6
		$_SESSION["session_llevel"]++;							//αύξηση της μεταβλητής session για το επίπεδο του χρήστη
		$link->query("UPDATE user SET level=".$_SESSION["session_llevel"]." WHERE username='".$_SESSION["session_lusername"]."'");
												//ενημέρωση πίνακα user για το νέο επίπεδο
	}
	else if (($score <= 1) and ($_SESSION["session_llevel"] != 1)) {			//αν η βαθμολογία είναι μικρότερη ή ίση του 1 και το επίπεδο δεν είναι 1
		$_SESSION["session_llevel"]--;							//μείωση της μεταβλητής session για το επίπεδο του χρήστη
		$link->query("UPDATE user SET level=".$_SESSION["session_llevel"]." WHERE username='".$_SESSION["session_lusername"]."'");
												//ενημέρωση πίνακα user για το νέο επίπεδο
	}
}
else {												//αν το τεστ είναι εφ' όλης της ύλης
	$score = $_POST["question_1"]+$_POST["question_2"]+$_POST["question_3"]+$_POST["question_4"]+$_POST["question_5"]+$_POST["question_6"]+$_POST["question_7"]+$_POST["question_8"]+$_POST["question_9"]+$_POST["question_10"];
												//υπολογισμός βαθμολογίας
	if (($score >= 8) and ($_SESSION["session_llevel"] != 6)) {				//αν η βαθμολογία είναι μεγαλύτερη ή ίση του 8 και το επίπεδο δεν είναι 6
		$_SESSION["session_llevel"]++;							//αύξηση της μεταβλητής session για το επίπεδο του χρήστη
		$link->query("UPDATE user SET level=".$_SESSION["session_llevel"]." WHERE username='".$_SESSION["session_lusername"]."'");
												//ενημέρωση πίνακα user για το νέο επίπεδο
	}
	else if (($score <= 2) and ($_SESSION["session_llevel"] != 1)) {			//αν η βαθμολογία είναι μικρότερη ή ίση του 2 και το επίπεδο δεν είναι 1
		$_SESSION["session_llevel"]--;							//μείωση της μεταβλητής session για το επίπεδο του χρήστη
		$link->query("UPDATE user SET level=".$_SESSION["session_llevel"]." WHERE username='".$_SESSION["session_lusername"]."'");
												//ενημέρωση πίνακα user για το νέο επίπεδο
	}
}
$link->query("UPDATE test SET score=".$score.", status='completed' WHERE id=".$id);
$result->free();
$link->close();											//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το τεστ ολοκληρώθηκε.'); location.href = 'history.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα history.php
?>
