<?php
error_reporting(E_ERROR);
$link = $link = mysqli_connect("localhost", "root", "", "diplomatiki");		//απόπειρα σύνδεσης στη βάση
if (!$link) {									//αν αποτυχία
    echo "<br> <span class='red_letters'> Σφάλμα βάσης δεδομένων </span>";	//εμφάνιση κατάλληλου μηνυματος
    exit();									//τερματισμός script
}
$result = $link->query("SELECT count(*) AS unseen FROM message WHERE to_user='".PROFESSOR_USERNAME."' AND seen=0 GROUP BY to_user");
										//ανάκτηση αριθμού αδιάβαστων μηνυμάτων από τον πίνακα message
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row["unseen"] == 1) {							//αν υπάρχουν μηνύματα
	echo "Έχεις <span class='red_letters'>1</span> νέο μήνυμα";		//εμφάνιση κατάλληλων μηνυμάτων
}
else if ($row["unseen"] > 1) {
	echo "Έχεις <span class='red_letters'>".$row["unseen"]."</span> νέα μηνύματα";
}
$result->free();
$link->close();									//κλείσιμο σύνδεσης με βάση
?>
