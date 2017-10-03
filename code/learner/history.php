<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Μάθημα Ιστορίας </title>
	<script>
		function logout() {									//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}

		function do_test(id) {									//με το πάτημα του κουμπιού ανακατεύθυνση στη σελίδα για να κάνει το τεστ
			location.href = "do_test.php?id="+id;
		}
	</script>
</head>
<body>
																								
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menul"> <a href="lhome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menul"> <a href="find_friend.php" class="link_to_page"> Βρες φίλους </a> </span>
		<span class="active"> Ιστορία </span>
		<span class="menul"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menul"> <a href="notification.php" class="link_to_page"> Ειδοποιήσεις </a> </span>
	</div>
	<div class="main">
		<span class="big"> Διάβασμα </span> <br> <br>
<?php
include "if_not_logged_l.php";										//έλεγχος αν έχει συνδεθεί μαθητής
include "../connect_to_database.php";
$link = connect_to_database("../login_register_form.php");						//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM section");							//ανάκτηση ενοτήτων από τον πίνακα section
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {						//για κάθε ενότητα
	echo "<b>".$row["number"].". ".$row["title"]."</b> <br>";					//εμφάνιση τίτλου ενότητας
	$result2 = $link->query ("SELECT * FROM chapter WHERE section_number=".$row["number"]);		//ανάκτηση κεφαλαίων για την δεδομένη ενότητα από τον πίνακα chapter
	while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {					//για κάθε κεφάλαιο
		echo $row2["section_number"].".".$row2["number"]." <a href='show_chapter.php?section=".$row2["section_number"]."&chapter=".$row2["number"]."'>".$row2["title"]."</a> <br>";
													//εμφάνιση τίτλου κεφαλαίου με σύνδεσμο για το κεφάλαιο
	}
	$result2->free();
}
?>
		<br> <span class="big"> Tεστ </span> <br> <br>
<?php
$result = $link->query("SELECT id FROM test WHERE CURDATE()>test_date AND status='pending'");		//ανάκτηση id από πίνακα test που εκκρεμούν και είναι στο παρελθόν 
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {						//για κάθε τεστ
	$link->query("UPDATE test SET status='overdue' WHERE id=".$row["id"]);				//ενημέρωση ότι είναι εκπρόθεσμο στον πίνακα test
}
$result = $link->query("SELECT id FROM test WHERE user='".$_SESSION["session_lusername"]."' AND test_date=CURDATE() AND status='pending'");
													//ανάκτηση id εκκρεμών τεστ για το χρήστη με σημερινή ημερομηνία από τον πίνακα test
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if (empty($row)) {											//αν δεν υπάρχει εκκρεμές τεστ για το χρήστη με σημερινή ημερομηνία
	$result = $link->query("SELECT test_date FROM test WHERE user='".$_SESSION["session_lusername"]."' AND status='pending' ORDER BY test_date");
													//ανάκτηση ημερομηνίας επόμενου εκκρεμούς για το χρήστη από τον πίνακα test
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	if (empty($row)) {										//αν δεν υπάρχει
		echo "Δεν έχεις εκκρεμή τεστ";								//εμφάνιση κατάλληλου μηνύματος
	}
	else {												//αν υπάρχει
		echo "Το επόμενο σου τεστ είναι στις ".date("d-m-Y", strtotime($row["test_date"]));	//εμφάνιση κατάλληλου μηνύματος
	}
}
else {													//αν υπάρχει εκκρεμές τεστ για το χρήστη με σημερινή ημερομηνία
	echo "Σου έχει ανατεθεί τεστ για σήμερα <br>";							//εμφάνιση κατάλληλου μηνύματος
	echo "Αν θες να κάνεις το τεστ τώρα <button onclick='do_test(".$row["id"].")'> Πάτησε εδώ </button>";
}
?>
		<br> <br> <span class="big"> Εργασία </span> <br> <br>
<?php
$result = $link->query("SELECT id FROM project INNER JOIN groups ON project.id=groups.project_id WHERE user='".$_SESSION["session_lusername"]."' AND deadline>CURDATE()");
													//ανάκτηση id εργασιών για το χρήστη που να μην έχει λήξει το deadline από τον πίνακα test
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if (!empty($row)) {											//αν υπάρχει εκκρεμής εργασία
	echo "Σου έχει ανατεθεί εργασία, πήγαινε στην σελίδα της εργασίας πατώντας <a href='project.php?id=".$row["id"]."'> εδώ </a>";
													//εμφάνιση κατάλληλου μηνύματος
}
else {													//αν δεν υπάρχει εκκρεμής εργασία
	echo "Δεν έχεις εκκρεμή εργασία";								//εμφάνιση κατάλληλου μηνύματος
}
$result->free();
$link->close();												//κλείσιμο σύνδεσης με βάση
?>
	</div>
</body>
</html>
