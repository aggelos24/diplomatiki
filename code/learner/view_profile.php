<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<script>
		function send_friend_request(username) {				//με το πάτημα του κουμπιού αποστολή αιτήματος φιλίας
			location.href = "send_friend_request.php?username="+username;
		}
	
		function logout() {							//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
	</script>
</head>
<body>
<?php
include "if_not_logged_l.php";								//έλεγχος αν έχει συνδεθεί μαθητής
include "../connect_to_database.php";
$link = connect_to_database("find_friend.php");						//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
if ((isset($_GET["username"])) and (isset($_GET["friend"]))) {				//αν υπάρχουν οι μεταβλητές GET
	$username = $_GET["username"];							//ανάθεση σε μεταβλητές
	$friend = $_GET["friend"];
	echo "<title>Προφίλ ".$username,"</title>";
}
else {											//αν όχι
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'find_friend.php'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα find_friend.php
}
if (isset($_GET["id"])) {
	$go_to = "project.php?id=".$_GET["id"];
}
else {
	$go_to = "lhome.php";
}
$result = $link->query ("SELECT * FROM user WHERE username='".$username."'");		//ανάκτηση στοιχείων χρήστη
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if (empty($row)) {									//αν δεν υπάρχει ο χρήστης
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'find_friend.php'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα find_friend.php
	$result->free();
	$link->close();									//κλείσιμο σύνδεσης με βάση
}
else {											//αλλιώς
	if (isset($row["photo"])) {							//αν ο χρήστης έχει ανεβάσει φωτογραφία
		$path = $row["photo"];							//εμφάνιση φωτογραφία του
		$style = "profile_photo";
	}
	else {										//αν όχι
		$path = "photos/profile.png";						//εμφάνιση default εικόνας
		$style = "default_profile_photo";
	}
}
?>
	<button class="logout" onclick="logout()"> Αποσύνδεση </button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="menu">
		<span class="menul"> <a href="lhome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menul"> <a href="find_friend.php" class="link_to_page"> Βρες φίλους </a> </span>
		<span class="menul"> <a href="history.php" class="link_to_page"> Ιστορία </a> </span>
		<span class="menul"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menul"> <a href="notification.php" class="link_to_page"> Ειδοποιήσεις </a> </span>
	</div>
	<div class="main">
		<div class="container">
			<img src="<?php echo $path; ?>" alt="Φωτογραφία Προφίλ" class="<?php echo $style; ?>">
			<div class="profile_details">	
				<p class="center">
<?php
echo $username;
$result2 = $link->query ("SELECT * FROM friend_request WHERE from_user='".$_SESSION["session_lusername"]."' AND to_user='".$username."'");
											//ανάκτηση στοιχείων χρήστη
$i = 1;
while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
	if ($row2["status"] == "pending") {
		$i = 0;
	}
}
if (($i) and ($friend == 0)) {
	echo " <button onclick=\"send_friend_request('".$username."')\"> Προσθήκη στους φίλους </button>";
}
?>
				</p> <br>
<?php
if (isset($row["description"])) {
	 echo $row["description"]."<br>";
}
if ($friend){
	echo "email: <a href='mailto:".$row["email"]."' target='_top'>".$row["email"]."</a>";
}
$result2->free();
$result->free();
$link->close();										//κλείσιμο σύνδεσης με βάση
?>
			</div>
		</div> <br>
		<p class="center"> <a href="<?php echo $go_to; ?>"> Επιστροφή </a> </p>
	</div>	
</body>
</html>
