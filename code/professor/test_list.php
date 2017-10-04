<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Λίστα Τεστ </title>
	<script>
		function logout() {								//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function delete_test(id) {							//με το πάτημα του κουμπιού διαγραφή τεστ
			location.href = "delete_test.php?id="+id;
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menup"> <a href="phome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menup"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menup"> <a href="content.php" class="link_to_page"> Διδακτικό περιεχόμενο </a> </span>
		<span class="menup"> <a href="group_project.php" class="link_to_page"> Εργασίες </a> </span>
		<span class="menup"> <a href="test.php" class="link_to_page"> Τεστ </a> </span>
	</div>
	<div class="main">
		<span class="big"> <a href="test.php"> Ερωτήσεις και Απαντήσεις </a> | <a href="insert_test_form.php"> Δημιουργία Τεστ </a> | Προβολή Λίστας Τεστ </span> <br> <br>
		<span class="red_letters"> Αν διαγραφεί κάποιο τεστ, δεν επηρεάζεται το επίπεδο του μαθητή </span> <br> <br>
<?php
include "if_not_logged_p.php";									//έλεγχος αν έχει συνδεθεί ο καθηγητής
include "../connect_to_database.php";
$to_greek = array("pending" => "Εκκρεμεί", "completed" => "Ολοκληρωμένο", "overdue" => "Εκπρόθεσμο");
$link = connect_to_database("../login_register_form.php");					//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT id FROM test WHERE CURDATE()>test_date AND status='pending'");	//ανάκτηση id από πίνακα test που εκκρεμούν και είναι στο παρελθόν 
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {					//για κάθε τεστ
	$link->query("UPDATE test SET status='overdue' WHERE id=".$row["id"]);			//ενημέρωση ότι είναι εκπρόθεσμο στον πίνακα test
}
$result = $link->query("SELECT * FROM test ORDER BY test_date DESC");
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {					//για κάθε τεστ
	$status = $row["status"];
	echo "<b>".$to_greek["$status"]."</b> <br>";						//εμφάνιση πληροφοριών
	echo $row["user"].", ".date("d-m-Y", strtotime($row["test_date"])).", ";
	if ($row["section_number"] == NULL) {							//αν το τεστ είναι εφ' όλης της ύλης
		echo "Εφ' όλης της ύλης";
	}
	else {											//αν είναι συγκεκριμένης ενότητας
		echo "Ενότητα ".$row["section_number"];
	}
	if ($status == "completed") {								//αν το τεστ έχει ολοκληρωθεί
		echo ", ".$row["score"]." βαθμοί";						//εμφάνιση βαθμολογίας
	}
	$id = $row["id"];
	echo "<br> <button onclick='delete_test(".$id.")'> Διαγραφή </button> <br> <br>";
}
$result->free();
$link->close();											//κλείσιμο σύνδεσης με βάση
?>
	</div>
</body>
</html>
