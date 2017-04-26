<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Τεστ </title>
	<script>
		function logout() {																				//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function show_hint(str) {																		//με το πάτημα του κουμπιού στο πεδίο για το όνομα χρήστη
			if (str.length==0) { 
				document.getElementById("hint").innerHTML="";
				return;
			}
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					document.getElementById("hint").innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET","get_hint.php?input="+str,true);											//προβολή υπόδειξης
			xmlhttp.send();
		}
	</script>
</head>
<body>
<?php
include "if_not_logged_p.php";																			//έλεγχος αν έχει συνδεθεί ο καθηγητής
?>
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
		<a href="test.php"> Ερωτήσεις και Απαντήσεις </a> | Δημιουργία Τεστ | <a href="test_list.php"> Προβολή Λίστας Τεστ </a> <br> <br>
		<form method="post" action="insert_test.php"> <br>
			Εξεταζόμενη Ενότητα <span class="red_letters"> (για εξέταση εφ' όλης ύλης πάτησε 0) </span> <input type="number" name="section_number" required /> <br>
			Mαθητής <input type="text" name="user" onkeyup="show_hint(this.value)" /> Μαθητές: <span id="hint"></span> <br>
			Ημερομηνία Τεστ	<input type="date" name="test_date" /> <br>
			<button type="submit"> Εισαγωγή </button>
		</form>
	</div>
</body>
</html>