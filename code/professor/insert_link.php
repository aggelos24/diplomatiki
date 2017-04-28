<meta charset="utf-8" />
<?php
if (isset($_GET["id"])) {								//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];								//ανάθεση της σε μεταβλητή
}
else {											//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
$search_1 = strpos($_POST["link"], "http://");
$search_2 = strpos($_POST["link"], "https://");
if ($search_1 === false and $search_2 === false) {					//αν δεν βρέθηκαν τα http:// ή https://
	$page_link = "http://".$_POST["link"];						//πρόσθεσε http:// στην αρχή της συμβολοσειράς
}
else {											//αλλιώς
	$page_link = $_POST["link"];							//ανάθεση της σε μεταβλητή
}
$file_headers = get_headers($page_link);						//καταχώριση επικεφαλίδων που επιστρέφει ο server σε μεταβλητή
if (!$file_headers or ($file_headers[0] == "HTTP/1.1 404 Not Found")) {			//αν επέστρεψε σφάλμα ότι δεν βρέθηκε
	header("Location:project.php?id=".$id."&fail=1");				//επιστροφή στη σελίδα project.php
}
else {
	$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 		//απόπειρα σύνδεσης στη βάση
	if (!$link) {									//αν αποτυχία
		echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
	}
	$link->query ("SET CHARACTER SET utf8");
	$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
	$link->query ("INSERT INTO link (id, project_id, user, url, description) VALUES (DEFAULT, ".$id.", 'aggelos24', '".$page_link."', '".$_POST["description"]."')");
											//εισαγωγή συνδέσμου στον πίνακα link
	$link->close();									//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Ο σύνδεσμος προστέθηκε.'); location.href = 'project.php?id=".$id."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
?>
