<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Λίστα μαθητών </title>
	<script>
		function logout() {									//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function sort(SortBy) {									//συνάρτηση για την εμφάνιση της λίστας μαθητών
			if (SortBy == "name") {								//αν ταξινόμηση κατά όνομα χρήστη
				document.getElementById("name").classList.remove("not_displayed");
				document.getElementById("level").classList.add("not_displayed");
				document.getElementById("date").classList.add("not_displayed");
			}
			else if (SortBy == "level") {							//αν ταξινόμηση κατά επίπεδο μαθητή
				document.getElementById("name").classList.add("not_displayed");
				document.getElementById("level").classList.remove("not_displayed");
				document.getElementById("date").classList.add("not_displayed");
			}
			else {										//αν ταξινόμηση κατά ημερομηνία τελευταίας σύνδεσης
				document.getElementById("name").classList.add("not_displayed");
				document.getElementById("level").classList.add("not_displayed");
				document.getElementById("date").classList.remove("not_displayed");
			}
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					var obj= JSON.parse(this.responseText);				//κάνε parse την απάντηση, η οποία είναι σε JSON κωδικοποίηση, από τη σελίδα get_learner_list.php
					var text = "";
					for (var row of obj) {
						text+="<div class='list_container'>";
						text+="<div class='list'>"+row.username+"</div>"+"<div class='list'> "+row.email+"</div>"+"<div class='list'>"+row.level+"</div>"+"<div class='list'>"+row.last_login+"</div>";
						text+="</div>";
					}
					document.getElementById("sorted").innerHTML = text;		//προβολή δεδομένων
				}
			}
			xmlhttp.open("GET","get_learner_list.php?sort="+SortBy, true);
			xmlhttp.send();
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση </button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menup"> <a href="phome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menup"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menup"> <a href="content.php" class="link_to_page"> Διδακτικό περιεχόμενο </a> </span>
		<span class="menup"> <a href="group_project.php" class="link_to_page"> Εργασίες </a> </span>
		<span class="menup"> <a href="test.php" class="link_to_page"> Τεστ </a> </span>
	</div>
	<div class="main">
<?php
include "if_not_logged_p.php";										//έλεγχος αν έχει συνδεθεί ο καθηγητής
?>
		<div id="name"> Ταξινόμηση κατά <b> Όνομα Χρήστη </b> ή κατά <button onclick="sort('level')"> Επίπεδο μαθητή </button> ή κατά <button onclick="sort('date')"> Ημερομηνία τελευταίας σύνδεσης </button> </div>
		<div id="level"> Ταξινόμηση κατά <button onclick="sort('name')"> Όνομα Χρήστη </button> ή κατά <b> Επίπεδο μαθητή </b> ή κατά <button onclick="sort('date')"> Ημερομηνία τελευταίας σύνδεσης </button> </div>
		<div id="date"> Ταξινόμηση κατά <button onclick="sort('name')"> Όνομα Χρήστη </button> ή κατά <button onclick="sort('level')"> Επίπεδο μαθητή </button> ή κατά <b> Ημερομηνία τελευταίας σύνδεσης </b> </div>
		<br>
		<div class="big list_container">
			<div class="list"> <b> Όνομα Χρήστη </b> </div>
			<div class="list"> <b> Email </b> </div>
			<div class="list"> <b> Επίπεδο (1-6) </b> </div>
			<div class="list"> <b> Τελευταία Είσοδος </b> </div>
		</div>
		<div id="sorted"></div>
	</div>
	<script>
		sort("name");
	</script>
</body>
</html>
