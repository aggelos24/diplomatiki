<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
session_start();																							//δημιουργία συνεδρίας
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 											//απόπειρα σύνδεσης στη βάση
if (!$link) {																								//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'login_register_form.php'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα login_register_form.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT * FROM user");																//ανάκτηση των στοιχείων των χρηστών
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {													//για κάθε χρήστη
	if ( ($row["username"] == $_POST["username"]) and ($row["password"] == md5($_POST["password"])) ) {		//αν ταιριάζουν τα στοιχεία της φόρμας με τα στοιχεία της βάσης
		if ($row["professor"] == 1) {																		//αν είναι ο χρήστης ο εκπαιδευτικός
			$_SESSION["session_pusername"] = "aggelos24";													//ορισμός μεταβλητών συνεδρίας
			$result->free();
			$link->close();																					//κλείσιμο σύνδεσης με βάση
			header("Location: professor/phome.php");														//ανακατεύθυνση στο phome.php
			}
		else {																								//αν είναι ο χρήστης ο μαθητής
			$_SESSION["session_lusername"] = $row["username"];												//ορισμός μεταβλητών συνεδρίας
			$_SESSION["session_lphoto"] = $row["photo"];
			$_SESSION["session_lemail"] = $row["email"];
			$_SESSION["session_ldescription"] = $row["description"];
			$_SESSION["session_llevel"] = $row["level"];
			$link->query ("UPDATE user SET last_login=NOW() WHERE username='".$_POST["username"]."'");	//ανανέωση της ημερομηνίας τελευταίας εισόδου του χρήστη
			$result->free();
			$link->close();																					//κλείσιμο σύνδεσης με βάση
			header("Location: learner/lhome.php");															//ανακατεύθυνση στο lhome.php
		}
	}
}
$result->free();
$link->close();																								//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Λάθος στοιχεία.'); location.href = 'login_register_form.php'; </script>";				//αν δεν είναι χρήστης, εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα login_register_form.php
?>
