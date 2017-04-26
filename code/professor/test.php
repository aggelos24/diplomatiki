<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Τεστ </title>
	<script>
		function logout() {																										//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function show_question_and_answer() {																			//με το πάτημα του κουμπιού εμφάνιση ερωτημάτων και απαντήσεων
			section_number = document.getElementById("section_number").value;
			if (section_number.length != 0) {																			//αν το πεδίο section_number της φόρμας δεν είναι κενό
				location.href = "test.php?section="+section_number;														//εμφάνιση των ερωτημάτων και απαντήσεων της συγκεκριμένης ενότητας
			}
			else {																										//αν το πεδίο section_number της φόρμας είναι κενό
				alert("Ξέχασες να βάλεις αριθμό.");																		//εμφάνιση κατάλληλου μηνύματος
			}
		}
		
		function delete_question_answer(id) {																			//με το πάτημα του κουμπιού διαγραφή ερωτήματος
			location.href = "delete_question_answer.php?id="+id;
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
		<span class="active"> Τεστ </span>
	</div>
	<div class="main">
		Ερωτήσεις και Απαντήσεις | <a href="insert_test_form.php"> Δημιουργία Τεστ </a> | <a href="test_list.php"> Προβολή Λίστας Τεστ </a> <br> <br>
		<form method="post" action="insert_question_answer.php">
			Ενότητα που αναφέρεται η ερώτηση <input type="number" name="section_number" required /> <br>
			<input type="radio" name="difficult" value="1" />Δύσκολη ερώτηση ή <input type="radio" name="difficult" value="0" />Εύκολη ερώτηση <br>
			Κείμενο ερώτησης: <br>
			<textarea name="question" rows="5" cols="55" required ></textarea> <br>
			Σωστή απάντηση: <br>
			<textarea name="correct_answer" rows="2" cols="55" required ></textarea> <br>
			Λάθος απαντήσεις: <br>
			<textarea name="wrong_answer_1" rows="2" cols="55" placeholder="1η λάθος απάντηση" required ></textarea> <br>
			<textarea name="wrong_answer_2" rows="2" cols="55" placeholder="2η λάθος απάντηση" required ></textarea> <br>
			<textarea name="wrong_answer_3" rows="2" cols="55" placeholder="3η λάθος απάντηση" required ></textarea> <br>
			<button type="sumbit"> Εισαγωγή </button>
		</form> <br> <br>
		Προβολή ερωτημάτων και απαντήσεων από ενότητα <input type="text" id="section_number" autofocus /> <button onclick="show_question_and_answer()"> Εμφάνιση </button>
		<br> <br>
<?php
include "if_not_logged_p.php";																							//έλεγχος αν έχει συνδεθεί ο καθηγητής
$link = mysqli_connect ("localhost", "root", "", "diplomatiki");														//απόπειρα σύνδεσης στη βάση
if (!$link) {																											//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'content.php'; </script>";								//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα content.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
if ((isset($_GET["section"]))) {																						//αν υπάρχει η μεταβλητή GET																											
	$section = $_GET["section"];																						//ανάθεσή της σε μεταβλητή
	$result = $link->query ("SELECT * FROM section WHERE number=".$section);											//έλεγχος αν υπάρχει ενότητα με αυτόν τον αριθμό στον πίνακα section
	if ($result->fetch_array() != "") {																					//αν υπάρχει
		$result = $link->query ("SELECT * FROM question_and_answer WHERE section_number=".$section);					//ανάκτηση ερωτημάτων και απαντήσεων από τον πίνακα question_and_answer
		while ($row = $result->fetch_array()) {																			//για κάθε ερώτημα
			if ($row["difficult"] == 1) {																				//αν το ερώτημα είναι δύσκολο
				echo "<span class='red_letters'> Δύσκολη Ερώτηση: </span>";
			}
			else {
				echo "<span class='red_letters'> Εύκολη Ερώτηση: </span>";												//αν το ερώτημα είναι εύκολο
			}
			echo $row["question_text"]."<br>";																			//εμφάνιση ερωτημάτος και απαντήσεων
			echo "Σωστή: ".$row["correct_answer"]."<br>";
			echo "Λάθος: ".$row["wrong_answer_1"]."<br>";
			echo "Λάθος: ".$row["wrong_answer_2"]."<br>";
			echo "Λάθος: ".$row["wrong_answer_3"]."<br>";
			echo "<button onclick='delete_question_answer(".$row["id"].")'> Διαγραφή </button>";
			echo "<br> <br>";
		}
	}
	$result->free();
}
$link->close();																											//κλείσιμο σύνδεσης με βάση
?>
	</div>
</body>
</html>