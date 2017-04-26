<meta charset="utf-8" />
<?php
session_start();																									//δημιουργία συνεδρίας
$ok = 1;
if (isset($_GET["id"])) {																							//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];																								//ανάθεσή της σε μεταβλητή
}
else {																												//αν δεν υπάρχει
	$ok = 0;
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 													//απόπειρα σύνδεσης στη βάση
if (!$link) {																										//αν αποτυχία
	$ok = 0;
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$file_type = pathinfo(basename($_FILES["project_document"]["name"]),PATHINFO_EXTENSION);							//εύρεση επέκτασης αρχείου
$target_file = "../projects/project_".$id."/project.doc";															//ορισμός διεύθυνσης προορισμού του αρχείου
if ($file_type != "doc") {																							//αν ο τύπος αρχείου δεν είναι doc
	$ok = 0;
	$link->close();																									//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Το αρχείο δεν είναι .doc.'); location.href = 'project.php?id=".$id."'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
}
if ($ok) {
	if (file_exists($target_file)) {																				//αν έχει ανεβεί ήδη η εργασία
		unlink($target_file);																						//διαγραφή προηγούμενης εργασίας
	}
	if (move_uploaded_file($_FILES["project_document"]["tmp_name"], $target_file)) {								//απόπειρα μετακίνησης εικόνας στην διεύθυνση προορισμού
		chmod($target_file, 0777);
		$link->query ("UPDATE project SET document=1 WHERE id=".$id);												//αν επιτυχία, ενημέρωση του πίνακα project
		$link->query ("INSERT INTO project_change (id, project_id, user, change_description, date) VALUES (DEFAULT, ".$id.", '".$_SESSION["session_lusername"]."', '".$_POST["changelog_text"]."', NOW())");
		$link->close();																								//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Η εργασία ανέβηκε.'); location.href = 'project.php?id=".$id."'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
	}
	else {																											//αν αποτυχία
		echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project.php?id=".$id."'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project.php
	}
}
?>