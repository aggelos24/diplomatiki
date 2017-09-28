<?php
$professor_username = "aggelos24";					//ανάθεση του username του καθηγητή σε μεταβλητή
include "../connect_to_database.php";
$link = connect_to_database("../login_register_form.php");		//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT count(*) AS unseen FROM message WHERE to_user='".$professor_username."' AND seen=0 GROUP BY to_user");
									//ανάκτηση αριθμού αδιάβαστων μηνυμάτων από τον πίνακα message
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row["unseen"] == 1) {						//αν υπάρχουν μηνύματα
	echo "Έχεις <span class='red_letters'>1</span> νέο μήνυμα";	//εμφάνιση κατάλληλων μηνυμάτων
}
else if ($row["unseen"] > 1) {
	echo "Έχεις <span class='red_letters'>".$row["unseen"]."</span> νέα μηνύματα";
}
$result->free();
$link->close();								//κλείσιμο σύνδεσης με βάση
?>
