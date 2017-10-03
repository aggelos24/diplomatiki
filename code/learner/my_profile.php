<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Το προφίλ μου </title>
	<script>
		function logout() {						//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
	</script>
</head>
<body>
<?php
include "if_not_logged_l.php";							//έλεγχος αν έχει συνδεθεί μαθητής
if (isset($_SESSION["session_lphoto"])) {					//αν ο χρήστης έχει ανεβάσει φωτογραφία
	$path = $_SESSION["session_lphoto"];					//εμφάνιση της φωτογραφίας του
	$style = "profile_photo";
}
else {										//αν όχι
	$path = "photos/profile.png";						//θα εμφανίσει την default εικόνα
	$style = "default_profile_photo";
}	
?>
	<button class="logout" onclick="logout()"> Αποσύνδεση </button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menul"> <a href="lhome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menul"> <a href="find_friend.php" class="link_to_page"> Βρες φίλους </a> </span>
		<span class="menul"> <a href="history.php" class="link_to_page"> Ιστορία </a> </span>
		<span class="menul"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menul"> <a href="notification.php" class="link_to_page"> Δες τις ειδοποιήσεις σου </a> </span>
	</div>
	<div class="main">
		<div class="container">
			<img src="<?php echo $path; ?>" alt="Φωτογραφία Προφίλ" class="<?php echo $style; ?>">
			<div class="profile_details">	
				<p class="center"> <?php echo "<span class='big'>".$_SESSION["session_lusername"]."</span>"; ?> </p><br>
<?php
if (isset($_SESSION["session_ldescription"])) {
	 echo $_SESSION["session_ldescription"]."<br>";
}
?>
				email: <a href="mailto:<?php echo $_SESSION["session_lemail"]; ?>" target="_top"> <?php echo $_SESSION["session_lemail"]; ?> </a>
			</div>
		</div> <br> <br>
		<p class="center"> <a href="lhome.php"> Επιστροφή στην Αρχική Σελίδα </a> </p>
	</div>	
</body>
</html>
