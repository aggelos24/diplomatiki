<meta charset="utf-8" />
<?php
session_start();													//δημιουργία συνεδρίας
if ((isset($_GET["id"])) and (isset($_GET["id"]))) {									//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];												//ανάθεσή της σε μεταβλητή
}
else {															//αν όχι
echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'notification.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα notification.php
}
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 							//απόπειρα σύνδεσης στη βάση
if (!$link) {														//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'notification.php'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα notification.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$link->query ("UPDATE notification SET display=0 WHERE id=".$id);							//ενημέρωση του πίνακα notification
$link->close();														//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Η ειδοποίηση δεν θα εμφανιστεί ξανά.'); location.href = 'notification.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα notification.php
?>
