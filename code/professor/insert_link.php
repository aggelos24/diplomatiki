<meta charset="utf-8" />
<?php
$professor_username = "aggelos24";							//ανάθεση του username του καθηγητή σε μεταβλητή
if (isset($_GET["id"])) {								//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];								//ανάθεση της σε μεταβλητή
}
else {											//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
	exit();										//τερματισμός script
}
$file_headers = get_headers($_POST["link"]);						//ανάθεση επικεφαλίδων που επιστρέφει ο server σε μεταβλητή
if (!$file_headers or ($file_headers[0] == "HTTP/1.1 404 Not Found")) {			//αν επιστροφή σφάλματος ότι δεν βρέθηκε
	header("Location: project.php?id=".$id."&fail=1");				//επιστροφή στη σελίδα project.php
}
else {											//αλλιώς
	include "../connect_to_database.php";
	$link = connect_to_database("../login_register_form.php");			//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
	$link->query("INSERT INTO link (id, project_id, user, url, description) VALUES (DEFAULT, ".$id.", '".$professor_username."', '".$_POST["link"]."', '".$_POST["description"]."')");
											//εισαγωγή συνδέσμου στον πίνακα link
	$link->close();									//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Ο σύνδεσμος προστέθηκε.'); location.href = 'project.php?id=".$id."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
?>
