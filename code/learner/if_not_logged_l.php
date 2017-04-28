<meta charset="utf-8" />
<?php
session_start();						//δημιουργία συνεδρίας
if (!(isset($_SESSION["session_lusername"]))) {			//αν δεν έχει συνδεθεί μαθητής
	echo "<script> alert('Δεν έχεις συνδεθεί.'); location.href = '../login_register_form.php'; </script>";
								//εμφάνιση κατάλληλου μηνύματος και ανακατεύθυνση στη σελίδα login_register_form.php
}
?>
