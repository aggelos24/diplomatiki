<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Τεστ </title>
</head>
	<script>
		function validate_answer_5() {														//με το πάτημα του κουμπιού έλεγχος απαντήσεων
			var question_1 = document.getElementsByName("question_1");									//ανάθεση τιμών φόρμας σε μεταβλητές
			var question_2 = document.getElementsByName("question_2");
			var question_3 = document.getElementsByName("question_3");
			var question_4 = document.getElementsByName("question_4");
			var question_5 = document.getElementsByName("question_5");
			var i;
			var check_counter = 0;
			for (i = 0; i < 4; i++) {													//επανάληψη for για μέτρηση τσεκαρισμένων κουμπιών
				if (question_1[i].checked) { check_counter++; }
				if (question_2[i].checked) { check_counter++; }
				if (question_3[i].checked) { check_counter++; }
				if (question_4[i].checked) { check_counter++; }
				if (question_5[i].checked) { check_counter++; }
			}
			if (check_counter < 5) {													//αν τα τσεκαρισμένα κουμπιά είναι μικρότερα από 5
				alert("Συμπλήρωσε όλες τις ερωτήσεις");											//εμφάνιση κατάλληλου μηνύματος
				return false;
			}
		}
		
		function validate_answer_10() {														//με το πάτημα του κουμπιού έλεγχος απαντήσεων
			var question_1 = document.getElementsByName("question_1");									//ανάθεση τιμών φόρμας σε μεταβλητές
			var question_2 = document.getElementsByName("question_2");
			var question_3 = document.getElementsByName("question_3");
			var question_4 = document.getElementsByName("question_4");
			var question_5 = document.getElementsByName("question_5");
			var question_6 = document.getElementsByName("question_6");
			var question_7 = document.getElementsByName("question_7");
			var question_8 = document.getElementsByName("question_8");
			var question_9 = document.getElementsByName("question_9");
			var question_10 = document.getElementsByName("question_10");
			var i;
			var check_counter = 0;
			for (i = 0; i < 4; i++) {													//επανάληψη for για μέτρηση τσεκαρισμένων κουμπιών
				if (question_1[i].checked) { check_counter++; }
				if (question_2[i].checked) { check_counter++; }
				if (question_3[i].checked) { check_counter++; }
				if (question_4[i].checked) { check_counter++; }
				if (question_5[i].checked) { check_counter++; }
				if (question_6[i].checked) { check_counter++; }
				if (question_7[i].checked) { check_counter++; }
				if (question_8[i].checked) { check_counter++; }
				if (question_9[i].checked) { check_counter++; }
				if (question_10[i].checked) { check_counter++; }
			}
			if (check_counter < 10) {													//αν τα τσεκαρισμένα κουμπιά είναι μικρότερα από 10
				alert("Συμπλήρωσε όλες τις ερωτήσεις");											//εμφάνιση κατάλληλου μηνύματος
				return false;
			}
		}
	</script>
<body>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="main">
		Το Τεστ περιλαμβάνει ερωτήσεις πολλαπλής επιλογής, τσέκαρε τη σωστή απάντηση σε κάθε ερώτηση και πάτα το κουμπί υποβολής μόλις τελειώσεις, <br> <br>
<?php
include "if_not_logged_l.php";																//έλεγχος αν έχει συνδεθεί μαθητής
include "../connect_to_database.php";
if (isset($_GET["id"])) {																//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];																//ανάθεση της σε μεταβλητή
}
else {																			//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'history.php'; </script>";								//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα history.php
	exit();																		//τερματισμός script
}
$question_number = 1;
$link = connect_to_database("history.php");														//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query ("SELECT * FROM test WHERE id=".$id);												//ανάκτηση στοιχείων τεστ από τον πίνακα test
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if (empty(($row)) or ($row["user"] != $_SESSION["session_lusername"]) or ($row["status"] != "pending")) {						//αν δεν υπάρχει τεστ με το συγκεκριμένο id, ή υπάρχει αλλά δεν είναι για τον συνδεδεμένο χρήστη ή δεν εκκρεμεί
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'history.php'; </script>";								//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα history.php
	exit();																		//τερματισμός script
}
if ($row["section_number"] != NULL) {															//αν το τεστ είναι σε κάποια συγκεκριμένη ενότητα
	echo "<form name='submit_result' method='post' action='submit_result.php?id=".$id."' onsubmit='return validate_answer_5()'>";
	$section_number = $row["section_number"];													//ανάθεση αριθμού ενότητας σε μεταβλητή
	if ($_SESSION["session_llevel"] == 1) {														//αν το επίπεδο χρήστη είναι 1
		$difficult_question_num = 1;														//1 δύσκολο ερώτημα
		$easy_question_num = 4;															//4 εύκολα ερωτήματα
	}
	else if (($_SESSION["session_llevel"] == 2) or ($_SESSION["session_llevel"] == 3)) {								//αν το επίπεδο χρήστη είναι 2 ή 3
		$difficult_question_num = 2;														//2 δύσκολα ερωτήματα
		$easy_question_num = 3;															//3 εύκολα ερωτήματα
	}
	else if (($_SESSION["session_llevel"] == 4) or ($_SESSION["session_llevel"] == 5)) {								//αν το επίπεδο χρήστη είναι 4 ή 5
		$difficult_question_num = 3;														//2 δύσκολα ερωτήματα
		$easy_question_num = 2;															//3 εύκολα ερωτήματα
	}
	else if ($_SESSION["session_llevel"] == 6) {													//αν το επίπεδο χρήστη είναι 6
		$difficult_question_num = 4;														//4 δύσκολα ερωτήματα
		$easy_question_num = 1;															//1 εύκολο ερώτημα
	}
	$array_id = array();
	$result = $link->query ("SELECT id FROM question_and_answer WHERE difficult=0 AND section_number=".$section_number);				//ανάκτηση id εύκολων ερωτημάτων
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {											//για κάθε εύκολο ερώτημα
		array_push($array_id, $row["id"]);													//εισαγωγή του id του ερωτήματος στον πίνακα
	}
	for ($i = 0; $i < $easy_question_num; $i++) {
		$selected_position = rand(0, count($array_id)-1);											//τυχαία επιλογή ερωτήματος
		for ($j = 0 ; $j < $selected_position-1 ; $j++) {											//σκοπός του for να έρθει το ζητούμενο id στην πρώτη θέση
			$temp = array_shift($array_id);
			array_push($array_id, $temp);
		}
		$selected_id = array_shift($array_id);													//εξαγωγή ζητούμενου id από τον πίνακα
		$result = $link->query ("SELECT * FROM question_and_answer WHERE id=".$selected_id);							//ανάκτηση των στοιχείων του επιλεγμένου ερωτήματος από τον πίνακα question_and_answer
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo $row["question_text"]."<br>";													//εμφάνιση κειμένου ερωτήματος
		$correct_answer_position = rand(1, 4);													//τυχαία της σωστής απάντησης
		if ($correct_answer_position == 1) {													//αν η θέση της σωστής απάντησης στο 1
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 2) {													//αν η θέση της σωστής απάντησης στο 2
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 3) {													//αν η θέση της σωστής απάντησης στο 3
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 4) {													//αν η θέση της σωστής απάντησης στο 1
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
		}
		echo "<br>";
		$question_number++;
	}
	
	$array_id = array();
	$result = $link->query ("SELECT id FROM question_and_answer WHERE difficult=1 AND section_number=".$section_number);				//ανάκτηση id δύσκολων ερωτημάτων
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {											//για κάθε δύσκολο ερώτημα
		array_push($array_id, $row["id"]);													//εισαγωγή του id του ερωτήματος στον πίνακα
	}
	for ($i = 0; $i < $difficult_question_num; $i++) {
		$selected_position = rand(0, count($array_id)-1);											//τυχαία επιλογή ερωτήματος
		for ($j = 0 ; $j < $selected_position-1 ; $j++) {											//σκοπός του for να έρθει το ζητούμενο id στην πρώτη θέση
			$temp = array_shift($array_id);
			array_push($array_id, $temp);
		}
		$selected_id = array_shift($array_id);													//εξαγωγή ζητούμενου id από τον πίνακα
		$result = $link->query ("SELECT * FROM question_and_answer WHERE id=".$selected_id);							//ανάκτηση των στοιχείων του επιλεγμένου ερωτήματος από τον πίνακα question_and_answer
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo $row["question_text"]."<br>";													//εμφάνιση κειμένου ερωτήματος
		$correct_answer_position = rand(1, 4);													//τυχαία η θέση της σωστης απάντησης
		if ($correct_answer_position == 1) {													//αν η θέση της σωστής απάντησης στο 1
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 2) {													//αν η θέση της σωστής απάντησης στο 2
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 3) {													//αν η θέση της σωστής απάντησης στο 3
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 4) {													//αν η θέση της σωστής απάντησης στο 1
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
		}
		echo "<br>";
		$question_number++;
	}
	
}
else {																			//αν το τεστ είναι εφ' όλης της ύλης
	echo "<form name='submit_result' method='post' action='submit_result.php?id=".$id."' onsubmit='return validate_answer_10()'>";
	if ($_SESSION["session_llevel"] == 1) {														//αν το επίπεδο χρήστη είναι 1
		$difficult_question_num = 1;														//1 δύσκολο ερώτημα
		$easy_question_num = 9;															//9 εύκολα ερωτήματα
	}
	else if ($_SESSION["session_llevel"] == 2) {													//αν το επίπεδο χρήστη είναι 2
		$difficult_question_num = 3;														//3 δύσκολα ερωτήματα
		$easy_question_num = 7;															//7 εύκολα ερωτήματα
	}
	else if ($_SESSION["session_llevel"] == 3) {													//αν το επίπεδο χρήστη είναι 3
		$difficult_question_num = 5;														//5 δύσκολα ερωτήματα
		$easy_question_num = 5;															//5 εύκολα ερωτήματα
	}
	else if ($_SESSION["session_llevel"] == 4) {													//αν το επίπεδο χρήστη είναι 4
		$difficult_question_num = 5;														//5 δύσκολα ερωτήματα
		$easy_question_num = 5;															//5 εύκολα ερωτήματα
	}
	else if ($_SESSION["session_llevel"] == 5) {													//αν το επίπεδο χρήστη είναι 5
		$difficult_question_num = 7;														//7 δύσκολα ερωτήματα
		$easy_question_num = 3;															//3 εύκολα ερωτήματα
	}
	else if ($_SESSION["session_llevel"] == 6) {													//αν το επίπεδο χρήστη είναι 6
		$difficult_question_num = 9;														//9 δύσκολα ερωτήματα
		$easy_question_num = 1;															//1 εύκολο ερώτημα
	}
	$array_id = array();
	$result = $link->query ("SELECT id FROM question_and_answer WHERE difficult=0");								//ανάκτηση id εύκολων ερωτημάτων
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {											//για κάθε εύκολο ερώτημα
		$array_id[] = $row["id"];														//εισαγωγή του id του ερωτήματος στον πίνακα
	}
	for ($i = 0; $i < $easy_question_num; $i++) {
		$selected_position = rand(0, count($array_id)-1);											//τυχαία επιλογή ερωτήματος
		$selected_id = $array_id[$selected_position];												//ανάθεση id επιλεγμένου ερωτήματος σε μεταβλητή
		unset($array_id[$selected_position]);													//διαγραφή id επιλεγμένου ερωτήματος από τον πίνακα
		$array_id = array_values($array_id);
		$result = $link->query ("SELECT * FROM question_and_answer WHERE id=".$selected_id);							//ανάκτηση των στοιχείων του επιλεγμένου ερωτήματος από τον πίνακα question_and_answer
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo $row["question_text"]."<br>";													//εμφάνιση κειμένου ερωτήματος
		$correct_answer_position = rand(1, 4);													//τυχαία η θέση της σωστης απάντησης
		if ($correct_answer_position == 1) {													//αν η θέση της σωστής απάντησης στο 1
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 2) {													//αν η θέση της σωστής απάντησης στο 2
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 3) {													//αν η θέση της σωστής απάντησης στο 3
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 4) {													//αν η θέση της σωστής απάντησης στο 1
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση απαντήσεων με ανάλογη σειρά
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
		}
		echo "<br>";
		$question_number++;
	}
	
	$array_id = array();
	$result = $link->query ("SELECT id FROM question_and_answer WHERE difficult=1");								//ανάκτηση id δύσκολων ερωτημάτων
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {											//για κάθε δύσκολο ερώτημα
		array_push($array_id, $row["id"]);													//εισαγωγή του id του ερωτήματος στον πίνακα
	}
	for ($i = 0; $i < $difficult_question_num; $i++) {
		$selected_position = rand(0, count($array_id)-1);											//τυχαία επιλογή ερωτήματος
		$selected_id = $array_id[$selected_position];												//ανάθεση id επιλεγμένου ερωτήματος σε μεταβλητή
		unset($array_id[$selected_position]);													//διαγραφή id επιλεγμένου ερωτήματος από τον πίνακα
		$array_id = array_values($array_id);													//εξαγωγή ζητούμενου id από τον πίνακα
		$result = $link->query ("SELECT * FROM question_and_answer WHERE id=".$selected_id);							//ανάκτηση των στοιχείων του επιλεγμένου ερωτήματος από τον πίνακα question_and_answer
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo $row["question_text"]."<br>";													//εμφάνιση κειμένου ερωτήματος
		$correct_answer_position = rand(1, 4);													//τυχαία η θέση της σωστης απάντησης
		if ($correct_answer_position == 1) {													//αν η θέση της σωστής απάντησης στο 1
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";			//εμφάνιση με ανάλογη σειρά τις απαντήσεις
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 2) {													//αν η θέση της σωστής απάντησης στο 2
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση με ανάλογη σειρά τις απαντήσεις
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 3) {													//αν η θέση της σωστής απάντησης στο 3
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση με ανάλογη σειρά τις απαντήσεις
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
		}
		if ($correct_answer_position == 4) {													//αν η θέση της σωστής απάντησης στο 1
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_1"]."<br>";			//εμφάνιση με ανάλογη σειρά τις απαντήσεις
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_2"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='0' /> ".$row["wrong_answer_3"]."<br>";
			echo "<input type='radio' name='question_".$question_number."' value='1' /> ".$row["correct_answer"]."<br>";
		}
		echo "<br>";
		$question_number++;
	}
	
}
$result->free();
$link->close();																		//κλείσιμο σύνδεσης με βάση
?>
		<button type="submit"> Υποβολή </button>
		</form>
	</div>
</body>
</html>
