<meta charset="utf-8" />
<?php
if ((isset($_GET["username"]))) {																												//αν υπάρχει η μεταβλητή GET
	$username = $_GET["username"];																												//ανάθεσή της σε μεταβλητή
}
else {																																			//αν όχι
echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'view_profile.php?username=".$username."&friend=0'; </script>";						//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα view_profile.php
}
session_start();																																//δημιουργία συνεδρίας
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 																				//απόπειρα σύνδεσης στη βάση
if (!$link) {																																	//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'view_profile.php?username=".$username."&friend=0'; </script>";					//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα view_profile.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$link->query ("INSERT INTO notification (id, to_user, text, seen, display) VALUES (DEFAULT, '".$username."', '', DEFAULT, DEFAULT)");			//δημιουργία ειδοποίησης για τον παραλήπτη του μηνύματος
$notification_id = $link->insert_id;
$link->query ("INSERT INTO friend_request (id, from_user, to_user, status, notification_id) VALUES (DEFAULT, '".$_SESSION["session_lusername"]."', '".$username."', DEFAULT, ".$notification_id.")");
																																				//προσθήκη αιτήματος φιλίας στη βάση
$friend_request_id = $link->insert_id;
$text = "Ο χρήστης <a href=\'view_profile.php?username=".$_SESSION["session_lusername"]."&friend=0\'>".$_SESSION["session_lusername"]."</a> θέλει να γίνετε φίλοι. <br>".
		"<button onclick=\'accept_friend_request(".$friend_request_id.")\'> Ναι, θέλω κι εγώ </button> <br>".
		"<button onclick=\'reject_friend_request(".$friend_request_id.")\'> Όχι </button>";
$link->query ("UPDATE notification SET text='".$text."' WHERE id=".$notification_id);															//προσθήκη κατάλληλου κειμένου στην ειδοποίηση
$link->close();																																	//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το αίτημα φιλίας στάλθηκε.'); location.href = 'view_profile.php?username=".$username."&friend=0'; </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα view_profile.php
?>