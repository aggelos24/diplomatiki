<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Μηνύματα </title>
	<script>
		function logout() {																										//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
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
		<a href="message.php"> Εισερχόμενα Μηνύματα </a> | Εξερχόμενα Μηνύματα
		<div> <br>
			<div class="message_header"> Στον χρήστη </div>
			<div class="message_header"> Θέμα </div>
			<div class="message_header"> Ημερομηνία που στάλθηκε </div>
		</div>
<?php
include "if_not_logged_p.php";																									//έλεγχος αν έχει συνδεθεί ο καθηγητής
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 																//απόπειρα σύνδεσης στη βάση
if (!$link) {																													//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'lhome.php'; </script>";											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα login_register_form.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT count(*) AS sent FROM message WHERE from_user='aggelos24' GROUP BY from_user");					//ανάκτηση αριθμού εξερχόμενων μηνυμάτων καθηγητή από τον πίνακα message
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$count = $row["sent"];
if (isset($_GET["pagenum"])) {																									//αν υπάρχει η μεταβλητή GET
	$pagenum = $_GET["pagenum"];																								//ανάθεσή της σε μεταβλητή
}
else{																															//αλλιώς
	$pagenum = 1;																												//θέσε τη μεταβλητή, 1
}
$limit = ($pagenum - 1) * 10;
$result = $link->query ("SELECT * FROM message WHERE from_user='aggelos24' ORDER BY id DESC LIMIT ".$limit.",10");				//ανάκτηση 10 το πολύ εξερχόμενων μηνυμάτων καθηγητή από τον πίνακα message
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {																		//για κάθε εξερχόμενο μήνυμα
	echo "<a href='show_sent_message.php?id=".$row["id"]."' class='link_to_page'> <div class='message_box'>";
	echo "<div class='message_info'>".$row["to_user"]."</div>"."<div class='message_info'> ".$row["subject"]."</div>"."<div class='message_info'>".date("H:i:s | d-m-Y", strtotime($row["date"]))."</div>";
	echo "</div> </a>";
}
if ($pagenum < ceil($count/10)) {																								//αν δεν είμαστε στην τελευταία σελίδα
	$pagenum++;
	echo "<a href='sent_message.php?pagenum=".$pagenum."'> Επόμενη Σελίδα </a>";												//δημιουργία συνδέσμου για να δει τα επόμενα
	$pagenum--;
}
if ($pagenum > 1) {																												//αν δεν είμαστε στην πρώτη σελίδα
	$pagenum--;
	echo "<a href='sent_message.php?pagenum=".$pagenum."'> Προηγούμενη Σελίδα </a>";											//δημιουργία συνδέσμου για να δει τα προηγούμενα
}
$result->free();
$link->close();																													//κλείσιμο σύνδεσης με βάση
?>
	</div>
</body>
</html>