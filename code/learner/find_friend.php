<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Βρες Φίλους </title>
	<script>
		function logout() {												//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
	</script>
</head>
<body>																									
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="menu">
		<span class="menul"> <a href="lhome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="active"> Βρες φίλους </span>
		<span class="menul"> <a href="history.php" class="link_to_page"> Ιστορία </a> </span>
		<span class="menul"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menul"> <a href="notification.php" class="link_to_page"> Ειδοποιήσεις </a> </span>
	</div>
	<div class="main">
		Φίλοι
		<div>
<?php
include "if_not_logged_l.php";													//έλεγχος αν έχει συνδεθεί μαθητής
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 								//απόπειρα σύνδεσης στη βάση
if (!$link) {															//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'lhome.php'; </script>";						//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT friendship.user2, user.photo FROM friendship INNER JOIN user ON friendship.user2=user.username WHERE friendship.user1='".$_SESSION["session_lusername"]."'");
																//ανάκτηση πληροφοριών φίλων του χρήστη
$friends = array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {									//για κάθε φίλο του χρήστη
	if (isset($row["photo"])) {												//αν ο φίλος έχει ανεβάσει φωτογραφία
		$fpath=$row["photo"];												//εμφάνιση φωτογραφίας του
	}
	else {															//αν όχι
		$fpath="photos/profile.png";											//εμφάνιση default εικόνας
	}
array_push($friends, $row["user2"]);												//προσθήκη του username του φίλου στον πίνακα friends
echo "<div class='view_users'>"."<a href='view_profile.php?username=".$row["user2"]."&friend=1'><img src='".$fpath."' alt='Φωτογραφία Προφίλ' class='user_profile_photo'>"."</a>"."<p class='center'>".$row["user2"]."</p>"."</div>";
																//εμφάνιση εικόνας προφιλ του
}
?>
		</div>
		Υπόλοιποι Χρήστες
		<div>
<?php
$result = $link->query ("SELECT * FROM user WHERE professor=0");								//ανάκτηση πληροφοριών χρηστών πλην του καθηγητή
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {									//για κάθε χρήστη πλην του καθηγητή
	if (!(in_array($row["username"], $friends)) and ($row["username"] != $_SESSION["session_lusername"])) {			//αν δεν είναι ο συνδεδεμένος χρήστης ή φίλος του χρήστη
		if (isset($row["photo"])) {											//ομοίως
			$fpath = $row["photo"];
		}
		else {
			$fpath = "photos/profile.png";
		}
	echo "<div class='view_users'>"."<a href='view_profile.php?username=".$row["username"]."&friend=0'><img src='".$fpath."' alt='Φωτογραφία Προφίλ' class='user_profile_photo'>"."</a>"."<p class='center'>".$row["username"]."</p>"."</div>";
	}
}
$result->free();
$link->close();															//κλείσιμο σύνδεσης με βάση
?>
		</div>
	</div>
</body>
</html>
