<meta charset="utf-8" />
<?php
include "../constants.php";
session_start();							//δημιουργία συνεδρίας
if ($_SESSION["session_pusername"] != PROFESSOR_USERNAME) {		//αν δεν έχει συνδεθεί ο καθηγητής
	echo "<script> alert('Δεν έχεις συνδεθεί.'); location.href = '../login_register_form.php'; </script>";
									//εμφάνιση κατάλληλου μηνύματος και ανακατεύθυνση στη σελίδα login_register_form.php
}
?>
