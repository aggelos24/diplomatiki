<meta charset="utf-8" />
<?php
$professor_username = "aggelos24";					//ανάθεση του username του καθηγητή σε μεταβλητή
session_start();							//δημιουργία συνεδρίας
if ($_SESSION["session_pusername"] != $professor_username) {		//αν δεν έχει συνδεθεί ο καθηγητής
	echo "<script> alert('Δεν έχεις συνδεθεί.'); location.href = '../login_register_form.php'; </script>";
									//εμφάνιση κατάλληλου μηνύματος και ανακατεύθυνση στη σελίδα login_register_form.php
}
?>
