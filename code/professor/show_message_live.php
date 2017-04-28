<?php
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 	//απόπειρα σύνδεσης στη βάση
if (!$link) {								//αν αποτυχία
	echo "Κάτι πήγε στραβά";					//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα phome.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT count(*) AS unseen FROM message WHERE to_user='aggelos24' AND seen=0 GROUP BY to_user");
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
