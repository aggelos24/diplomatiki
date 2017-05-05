<?php
if ((isset($_GET["sort"]))) {							//αν υπάρχει η μεταβλητή GET
	$sort = $_GET["sort"];							//ανάθεσή της σε μεταβλητή
}
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 		//απόπειρα σύνδεσης στη βάση
if (!$link) {									//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'phome.php'; </script>";
										//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα phome.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
if ($sort == "level") {								//αν η ταξινόμηση είναι με βάση το επίπεδο
	$result = $link->query ("SELECT * FROM user WHERE professor=0 ORDER BY level");										//ανάκτηση στοιχείων μαθητών ταξινομημένα με βάση το επίπεδο από τον πίνακα user
}
else if ($sort == "date") {							//αν η ταξινόμηση είναι με βάση την ημερομηνία τελευταίας σύνδεσης χρήστη
	$result = $link->query ("SELECT * FROM user WHERE professor=0 ORDER BY last_login DESC");
										//ανάκτηση στοιχείων μαθητών ταξινομημένα με βάση την ημερομηνία τελευταίας σύνδεσης χρήστη από τον πίνακα user
}
else {										//αν δεν έχει οριστεί τύπος ταξινόμησης
	$result = $link->query ("SELECT * FROM user WHERE professor=0");	//ανάκτηση στοιχείων μαθητών από τον πίνακα user
}
$i=0;
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {			//για κάθε μαθητή
    $results[$i] = [ "username" => $row["username"], "email" => $row["email"], "level" => $row["level"], "last_login" => date("d-m-Y", strtotime($row["last_login"]))];
    $i++;
}
$myJSON = json_encode($results);						//κωδικοποίηση των αποτελεσμάτων σε JSON
echo $myJSON;									//εκτύπωση της μεταβλητής myJSON
$result->free();
$link->close();									//κλείσιμο σύνδεσης με βάση
?>
