<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Ειδοποιήσεις </title>
	<script>
		function logout() {							//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function not_display_notification(id) {					//με το πάτημα του κουμπιού να μην εμφανίζεται η ειδοποίηση
			location.href = "not_display_notification.php?id="+id;
		}
		
		function accept_friend_request(id) {					//με το πάτημα του κουμπιού αποδοχή αιτήματος φιλίας
			location.href = "accept_friend_request.php?id="+id;
		}
		
		function reject_friend_request(id) {					//με το πάτημα του κουμπιού απόρριψη αιτήματος φιλίας
			location.href = "reject_friend_request.php?id="+id;
		}
	</script>
</head>
<body>																									
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="big menu">
		<span class="menul"> <a href="lhome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menul"> <a href="find_friend.php" class="link_to_page"> Βρες φίλους </a> </span>
		<span class="menul"> <a href="history.php" class="link_to_page"> Ιστορία </a> </span>
		<span class="menul"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="active"> Ειδοποιήσεις </span>
	</div>
	<div class="main">
		<span class="big"> Λίστα ειδοποιήσεων <span class="red_letters"> (οι καινούργιες ειδοποιήσεις έχουν πιο σκούρο φόντο)</span>: </span> <br>
<?php
include "if_not_logged_l.php";								//έλεγχος αν έχει συνδεθεί μαθητής
include "../connect_to_database.php";
$link = connect_to_database("../login_register_form.php");				//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT * FROM notification WHERE to_user='".$_SESSION["session_lusername"]."' AND display=1 ORDER BY id DESC");
											//ανάκτηση δεδομένων από τον πίνακα notification		
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {				//για κάθε ενημέρωση που πρέπει να προβληθεί
	if ($row["seen"]) {								//αν την έχει δει ο χρήστης
		echo "<div class='seen_notification'>".$row["text"];
	}
	else {										//αν δεν την έχει δει ο χρήστης
		echo "<div class='not_seen_notification'>".$row["text"];
	}
echo "<br>"."<button onclick='not_display_notification(".$row["id"].")'> Αγνόησε αυτή την ειδοποίηση </button>"."</div>";
$link->query("UPDATE notification SET seen=1 WHERE id=".$row["id"]);			//ενημέρωση του πίνακα notification ότι ο χρήστης είδε τις ενημερώσεις
}
$result->free();
$link->close();										//κλείσιμο σύνδεσης με βάση
?>
	</div>
</body>
</html>
