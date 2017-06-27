<meta charset="utf-8" />
<?php
include "../connect_to_database.php";
$link = connect_to_database("group_project.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$search = array("'", '"');
$replace = array("\'", '\"');
$description_text = str_replace($search, $replace, $_POST["description_text"]);					//για αποφυγή σφάλματος βάσης
$users = $_POST["users"];											//ανάθεση επιλεγμένων χρηστών σε μεταβλητή πίνακα
if (empty($users)) {												//αν ο πίνακας είναι άδειος
    echo "<script> alert('Δεν έβαλες κανένα μαθητή στην ομάδα.'); location.href = 'group_project.php'; </script>";
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα group_project.php
}
else if (count($users) == 1) {
    echo "<script> alert('Μια ομάδα θα πρέπει να αποτελείται από τουλάχιστον 2 άτομα.'); location.href = 'group_project.php'; </script>";
														//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα group_project.php
}
$link->query ("INSERT INTO project (id, title, description, deadline, document, grade) VALUES (DEFAULT, '".$_POST["title"]."', '".$description_text."', '".$_POST["deadline"]."', DEFAULT, DEFAULT)");
														//εισαγωγή εργασίας στον πίνακα project
$project_id = $link->insert_id;											//ανάθεση του id της εργασίας σε μεταβλητή
$path = "../projects/project_".$project_id;
if(!mkdir($path, 0777)) {
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'group_project.php'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα group_project.php
	$link->close();												//κλείσιμο σύνδεσης με βάση
}
$notification_text = "Σου έχει ανατεθεί εργασία, για περισσότερες πληροφορίες πάτησε <a href=\'project.php?id=".$project_id."\'> εδώ </a>";
for ($i = 0; $i < count($users); $i++) {									//για κάθε επιλεγμένο χρήστη
	$link->query ("INSERT INTO groups (project_id, user) VALUES (".$project_id.", '".$users[$i]."')");	//εισαγωγή χρήστη στον πίνακα groups
	$link->query ("INSERT INTO notification (id, to_user, text, seen, display) VALUES (DEFAULT, '".$users[$i]."', '".$notification_text."', DEFAULT, DEFAULT)");
														//δημιουργία ειδοποίησης για το χρήστη
}
$link->close();													//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Η εργασία προστέθηκε.'); location.href = 'group_project.php'; </script>";			//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα group_project.php
?>
