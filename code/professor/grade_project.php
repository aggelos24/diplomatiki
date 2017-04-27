<meta charset="utf-8" />
<?php
if (isset($_GET["id"])) {											//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];											//ανάθεσή της σε μεταβλητή
}
else {														//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project_list.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project_list.php
}
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 						//απόπειρα σύνδεσης στη βάση
if (!$link) {													//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'test.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα test.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$link->query ("UPDATE project SET grade=".$_POST["grade"]." WHERE id=".$id);					//ενημέρωση πίνακα project με τον καινούργιο βαθμό	
$link->close();													//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Η εργασία βαθμολογήθηκε, μπορείς με την ίδια διαδικασία να αλλάξεις τον βαθμό.'); location.href = 'project_list.php'; </script>";
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project_list.php
?>
