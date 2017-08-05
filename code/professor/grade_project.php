<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
if (isset($_GET["id"])) {										//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];										//ανάθεσή της σε μεταβλητή
}
else {													//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project_list.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project_list.php
	exit();												//τερματισμός script
}
$link = connect_to_database("project_list.php");							//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$link->query("UPDATE project SET grade=".$_POST["grade"]." WHERE id=".$id);				//ενημέρωση πίνακα project με τον καινούργιο βαθμό	
$link->close();												//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Η εργασία βαθμολογήθηκε, μπορείς με την ίδια διαδικασία να αλλάξεις τον βαθμό.'); location.href = 'project_list.php'; </script>";
													//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project_list.php
?>
