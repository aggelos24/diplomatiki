<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$link = connect_to_database("project_list.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
if (isset($_GET["id"])) {											//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];											//ανάθεσή της σε μεταβλητή
}
else {														//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project_list.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project_list.php
}
$result = $link->query ("SELECT document FROM project WHERE id=".$id);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row["document"]) {												//αν κάποιος έχει ανέβασει την εργασία
	if (!unlink("../projects/project_".$id."/project.doc")) {						//απόπειρα διαγραφής αρχείου εργασίας, αν αποτυχία
		$link->close();											//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project_list.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project_list.php
	}
}
$result = $link->query ("SELECT * FROM source_file WHERE project_id=".$id." ORDER BY id DESC");			//ανάκτηση στοιχείων αρχείων από τον πίνακα source_file
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {							//για κάθε αρχείο
	if (!unlink($row["path"])) {										//απόπειρα διαγραφής αρχείου πηγής, αν αποτυχία
		$link->close();											//κλείσιμο σύνδεσης με βάση
		echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project_list.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project_list.php
	}
}
rmdir("../projects/project_".$id);										//διαγραφή φακέλου εργασίας
$link->query ("DELETE FROM project WHERE id=".$id);								//διαγραφή εργασίας από τον πίνακα project, και όποιας εγγραφής σε άλλους πίνακες συνδέεται με αυτό το id
$link->query ("DELETE FROM notification WHERE text LIKE '%id=".$id."%'");					//διαγραφή ειδοποιήσεων που αφορούν την συγκεκριμένη εργασία από τον πίνακα notification
$link->close();													//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Η εργασία διαγράφηκε.'); location.href = 'project_list.php'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project_list.php
?>
