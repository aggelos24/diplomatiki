<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Εργασίες </title>
	<script>
		function logout() {								//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function show_project(id) {							//με το πάτημα του κουμπιού εμφάνιση εργασίας
			location.href = "project.php?id="+id;
		}
		
		function delete_project(id) {							//με το πάτημα του κουμπιού διαγραφή εργασίας
			location.href = "delete_project.php?id="+id;
		}
		
		function grade_project(id) {							//με το πάτημα του κουμπιού εμφάνιση φόρμας διαγραφής εργασίας
			document.getElementById(id).style.display = "inline";
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="menu">
		<span class="menup"> <a href="phome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menup"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menup"> <a href="content.php" class="link_to_page"> Διδακτικό περιεχόμενο </a> </span>
		<span class="menup"> <a href="group_project.php" class="link_to_page"> Εργασίες </a> </span>
		<span class="menup"> <a href="test.php" class="link_to_page"> Τεστ </a> </span>
	</div>
	<div class="main">
		<a href="group_project.php"> Δημιουργία εργασίας </a> | Προβολή λίστας εργασιών <br> <br>
		<span class="red_letters"> Τυχόν διαγραφή μιας εργασίας θα διαγράψει τον φάκελο της εργασίας και όλα τα έγγραφα που περιέχει </span> <br> <br>
<?php
include "if_not_logged_p.php";									//έλεγχος αν έχει συνδεθεί ο καθηγητής
include "../connect_to_database.php";
$id_array = array();
$link = connect_to_database("../login_register_form.php");					//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT id FROM project");						//ανάκτηση id εργασιών από τον πίνακα project
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {					//για κάθε εργασία
	array_push($id_array, $row["id"]);							//ανάθεση id σε πίνακα
}
for ($i = 0; $i < count($id_array); $i++) {
	$result = $link->query("SELECT * FROM project INNER JOIN groups ON project.id=groups.project_id WHERE project.id=".$id_array[$i]);
												//ανάκτηση στοιχείων εργασιών από πίνακα project και group
	$row_num = mysqli_num_rows($result);							//ανάθεση του αριθμού των επιστρεφόμενων εγγραφών σε μεταβλητή
	for ($j = 0; $row = mysqli_fetch_array($result, MYSQLI_ASSOC); $j++) {			//για κάθε μέλος ομάδας
		if ($j == 0) {									//εμφάνιση πληροφοριών εργασίας και φορμών για διαγραφή και βαθμολόγησή της
			echo "<b>".$row["title"]."</b> <br>";
			echo $row["description"]."<br>";
			echo "Διορία: ".date("d-m-Y", strtotime($row["deadline"])).", ";
			if ($row["grade"] != NULL) {						//αν η εργασία έχει βαθμό
				echo "Βαθμος: ".$row["grade"].", ";				//εμφάνιση βαθμού
			}
			echo "Μέλη Ομάδας: ".$row["user"].", ";
		}
		else if ($j == $row_num-1) {
			echo $row["user"]."<br>";
			echo "<button onclick='show_project(".$row["id"].")'> Προβολή Σελίδας Εργασίας </button> ";
			echo "<button onclick='delete_project(".$row["id"].")'> Διαγραφή Εργασίας </button> ";
			echo "<button onclick='grade_project(".$row["id"].")'> Βαθμολόγηση Εργασίας </button> <br> <br>";
			echo "<div id='".$row["id"]."' class='not_displayed'>";
			echo "<form method='post' action='grade_project.php?id=".$row["id"]."'>  Βαθμός (1 εώς 10): <input type='number' name='grade' min='1' max='10' required /> <button type='submit'> Βαθμολόγηση </button> </form>";
			echo "</div> <br>";
		}
		else {
			echo $row["user"].", ";
		}
	}
}
$result->free();
$link->close();											//κλείσιμο σύνδεσης με βάση
?>
	</div>
</body>
</html>
