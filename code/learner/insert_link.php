<meta charset="utf-8" />
<?php
session_start();									//δημιουργία συνεδρίας
if (isset($_GET["id"])) {								//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];								//ανάθεση της σε μεταβλητή
}
else {											//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
	exit();										//τερματισμός script
}
$search_1 = strpos($_POST["link"], "http://");
$search_2 = strpos($_POST["link"], "https://");
if ($search_1 === false and $search_2 === false) {					//αν δεν βρέθηκαν τα http:// ή https://
	$page_link = "http://".$_POST["link"];						//πρόσθηκη http:// στην αρχή της συμβολοσειράς
}
else {											//αλλιώς
	$page_link = $_POST["link"];							//ανάθεση της σε μεταβλητή
}
$file_headers = get_headers($page_link);						//ανάθεση επικεφαλίδων που επιστρέφει ο server σε μεταβλητή
if (!$file_headers or ($file_headers[0] == "HTTP/1.1 404 Not Found")) {			//αν επιστροφή σφάλματος ότι δεν βρέθηκε
	header("Location:project.php?id=".$id."&fail=1");				//επιστροφή στη σελίδα project.php
}
else {											//αλλιώς
	include "../connect_to_database.php";
	$link = connect_to_database("../login_register_form.php");			//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
	$link->query("INSERT INTO link (id, project_id, user, url, description) VALUES (DEFAULT, ".$id.", '".$_SESSION["session_lusername"]."', '".$page_link."', '".$_POST["description"]."')");
											//εισαγωγή συνδέσμου στον πίνακα link
	$link->close();									//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Ο σύνδεσμος προστέθηκε.'); location.href = 'project.php?id=".$id."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
?>
