<?php
include_once "constants.php";
function connect_to_database($destination) {					//συνάρτηση για σύνδεση στη βάση
	$link = mysqli_connect(DATABASE_HOST_NAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
										//απόπειρα σύνδεσης στη βάση
	if (!$link) {								//αν αποτυχία
		session_start();						//δημιουργία συνεδρίας
		session_unset();						//διαγραφή μεταβλητών συνεδρίας
		session_destroy();						//διαγραφή συνεδρίας
		echo "<script> alert('Σφάλμα βάσης δεδομένων.'); location.href = '".$destination."'; </script>";
										//εμφάνιση κατάλληλου μηνύματος και ανακατεύθυνση στην κατάλληλη σελίδα
		exit();								//τερματισμός script
	}
	$link->query("SET CHARACTER SET utf8");
	$link->query("SET COLLATION_CONNECTION=utf8_general_ci");
	return $link;
}
