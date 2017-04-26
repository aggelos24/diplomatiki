<?php
session_start();												//δημιουργία συνεδρίας
if (isset($_SESSION["session_lusername"])) {					//αν έχει συνδεθεί κάποιος μαθητής
	header("Location: learner/lhome.php");						//ανακατεύθυνση σε lhome.php
}
else if (isset($_SESSION["session_pusername"])) {				//αν έχει συνδεθεί ο καθηγητής
	header("Location: professor/phome.php");					//ανακατεύθυνση σε phome.php
}
else {															//αν δεν έχει συνδεθεί κανένας
	header("Location: login_register_form.php" );				//ανακατεύθυνση σε login_register_form.php	
}
?>