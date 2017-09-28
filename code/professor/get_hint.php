<?php
include "../connect_to_database.php";
$link = connect_to_database("../login_register_form.php");			//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$username = array();
$result=$link->query("SELECT username FROM user WHERE professor=0");		//ανάκτηση username των μαθητών από τον πίνακα user
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {			//για κάθε μαθητή
	array_push($username, $row["username"]);				//προσθήκη του username του στον πίνακα username
}
$input = $_GET["input"];							//καταχώρηση της μεταβλητή GET
if (strlen($input) > 0) {
	$hint="";
	for($i=0; $i < count($username); $i++) {				//για κάθε τιμή του πίνακα username
		if ($input == substr($username[$i], 0, strlen($input)) ) {	//αν η είσοδος είναι υποσυμβολοσειρά του username
			if (empty($hint)) {					//αν η hint είναι κενή
				$hint=$username[$i];				//ανάθεση του username στη hint
			}
			else {							//αν δεν είναι κενή
				$hint=$hint." , ".$username[$i];		//προσθήκη του username στην υπάρχουσα συμβολοσειρά
			}
		}
	}
}
if (empty($hint)) {								//αν η hint είναι κενή
	echo "Κανένας μαθητής με αυτό το username.";				//εμφάνιση κατάλληλου μηνύματος
}
else {										//αν δεν είναι κενή
	echo $hint;								//εκτύπωση της μεταβλητής hint
}
?>
