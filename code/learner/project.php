<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="lstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Σελίδα Εργασίας </title>
	<script>
		function logout() {								//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function show_change_description() {						//με το πάτημα του κουμπιού εμφάνιση περιγραφής τελευταίας αλλαγής
			document.getElementById("change_description").style.display = "inline";
			document.getElementById("bchange_description").style.display = "none";
		}
	</script>
</head>
<body>
	<button class="logout" onclick="logout()"> Αποσύνδεση</button>
	<img src="../banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="menu">
		<span class="menul"> <a href="lhome.php" class="link_to_page"> Αρχική </a> </span>
		<span class="menul"> <a href="find_friend.php" class="link_to_page"> Βρες φίλους </a> </span>
		<span class="menul"> <a href="history.php" class="link_to_page"> Ιστορία </a> </span>
		<span class="menul"> <a href="message.php" class="link_to_page"> Μηνύματα </a> </span>
		<span class="menul"> <a href="notification.php" class="link_to_page"> Ειδοποιήσεις </a> </span>
	</div>
	<div class="main">
<?php
include "../connect_to_database.php";
$professor_username = "aggelos24";								//ανάθεση του username του καθηγητή σε μεταβλητή
session_start();										//δημιουργία συνεδρίας
if (isset($_GET["id"])) {									//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];									//ανάθεσή της σε μεταβλητή
}
else {												//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'history.php'; </script>";	//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα history.php
	exit();											//τερματισμός script
}
if (isset($_GET["fail"])) {									//αν ο σύνδεσμος δεν είναι έγκυρος
	echo "<script> alert('Ο σύνδεσμος που εισήγαγες δεν είναι έγκυρος.'); </script>";	//εμφάνιση κατάλληλου μηνύματος
}
$pass = 0;
$link = connect_to_database("../login_register_form.php");					//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query("SELECT groups.user FROM project INNER JOIN groups ON project.id=groups.project_id WHERE project.id=".$id);
												//ανάκτηση username των μελών της ομάδας από τον πίνακα groups
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {					//για κάθε username
	if ($row["user"] == $_SESSION["session_lusername"]) {					//αν το username είναι ίδιο με την μεταβλητή session
		$pass = 1;
	}
}
if (!$pass) {											//αν ο χρήστης δεν είναι μέλος της ομάδας
	$link->close();										//κλείσιμο σύνδεσης με βάση
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'history.php'; </script>";
												//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα history.php
	exit();											//τερματισμός script
}
$result = $link->query("SELECT * FROM project INNER JOIN groups ON project.id=groups.project_id WHERE project.id=".$id);
												//ανάκτηση στοιχείων εργασιών από πίνακα project και groups
$row_num = mysqli_num_rows($result);								//ανάθεση του αριθμού των επιστρεφόμενων εγγραφών σε μεταβλητή
for ($i = 0; $row = mysqli_fetch_array($result, MYSQLI_ASSOC); $i++) {				//για κάθε μέλος της ομάδας
	$user = $row["user"];
	if ($i == 0) {										//εμφάνιση πληροφοριών εργασίας και φορμών για διαγραφή και βαθμολόγησή της
		echo "<p class='big center'> <b> Τίτλος: </b> ".$row["title"].", Διορία μέχρι ".date("d-m-Y", strtotime($row["deadline"]))."</p> <br>";
		echo "Εκφώνηση: <br>";
		echo $row["description"]."<br>";
		$result2 = $link->query("SELECT * FROM friendship WHERE user1='".$_SESSION["session_lusername"]."' AND user2='".$user."'");
		if (!empty(mysqli_fetch_array($result2, MYSQLI_ASSOC))) {			//αν το μέλος της ομάδας είναι φίλος
			echo "Μέλη Ομάδας: "."<a href='view_profile.php?username=".$user."&friend=1&id=".$id."'>".$user."</a>, ";
		}
		else if ($user == $_SESSION["session_lusername"]) {				//αν το μέλος της ομάδας είναι ο χρήστης
			echo "Μέλη Ομάδας: ".$user.", ";
		}
		else {										//αν το μέλος της ομάδας δεν είναι φίλος
			echo "Μέλη Ομάδας: "."<a href='view_profile.php?username=".$user."&friend=0&id=".$id."'>".$user."</a>, ";
		}
	}
	else if ($i == $row_num-1) {
		$document = $row["document"];
		$result2 = $link->query("SELECT * FROM friendship WHERE user1='".$_SESSION["session_lusername"]."' AND user2='".$user."'");
		if (!empty(mysqli_fetch_array($result2, MYSQLI_ASSOC))) {			//αν το μέλος της ομάδας είναι φίλος
			echo "<a href='view_profile.php?username=".$user."&friend=1&id=".$id."'>".$user."</a>"."<br>";
		}
		else if ($user == $_SESSION["session_lusername"]) {				//αν το μέλος της ομάδας είναι ο χρήστης
			echo $user."<br>";
		}
		else {										//αν το μέλος της ομάδας δεν είναι φίλος
			echo "<a href='view_profile.php?username=".$user."&friend=0&id=".$id."'>".$user."</a>"."<br>";
		}
		if ($document) {								//αν κάποιος έχει ανέβασει την εργασία
			echo "<a href='../projects/project_".$id."/project.doc' target='_blank'> Αρχείο εργασίας </a>, ";
		}
		else {										//αν κανένας δεν έχει ανεβάσει ακόμα την εργασία
			echo "Δεν έχει ανέβει ακόμα κάποια εργασία";
		}
	}
	else {
		$result2 = $link->query("SELECT * FROM friendship WHERE user1='".$_SESSION["session_lusername"]."' AND user2='".$user."'");
		if (!empty(mysqli_fetch_array($result2, MYSQLI_ASSOC))) {			//αν το μέλος της ομάδας είναι φίλος
			echo "<a href='view_profile.php?username=".$user."&friend=1&id=".$id."'>".$user."</a>, ";
		}
		else if ($user == $_SESSION["session_lusername"]) {				//αν το μέλος της ομάδας είναι ο χρήστης
			echo $user.", ";
		}
		else {										//αν το μέλος της ομάδας δεν είναι φίλος
			echo "<a href='view_profile.php?username=".$user."&friend=0&id=".$id."'>".$user."</a>, ";
		}
	}
}
if ($document) {										//αν κάποιος έχει ανέβασει την εργασία
	$result = $link->query("SELECT * FROM project_change WHERE project_id=".$id." ORDER BY id DESC LIMIT 1");
												//ανάκτηση στοιχείων τελευταίας αλλαγής από πίνακα project_change
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	echo "Τελευταία αλλαγή από ".$row["user"].", στις ".date("d-m-Y", strtotime($row["date"]))." <button id='bchange_description' onclick='show_change_description()'> Εμφάνιση Αλλαγών </button>";
												//εμφάνιση πληροφοριών τελευταίας αλλαγής
	echo "<br> <div id='change_description' class='not_displayed'>".$row["change_description"]."</div>";
}
?>
		<form method="post" action="upload_project.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
			<input type="file" name="project_document" required /> <br>
			<textarea name="changelog_text" rows="2" cols="40" placeholder="Γράψε για τις αλλαγές που έκανες" required ></textarea>
			<button type="submit"> Ανέβασμα Εργασίας </button>
		</form>
		<br> <br> <p class="big center"> Σύνδεσμοι σχετικοί με την εργασία </p> <br>
		<form method="post" action="insert_link.php?id=<?php echo $id; ?>">
			Διεύθυνση URL <input type="text" name="link" required />
			Περιγραφή <input type="text" name="description" required />
			<button type="submit"> Εισαγωγή Συνδέσμου </button>
		</form> <br>
		<div class="source">
<?php
$result = $link->query("SELECT * FROM link WHERE project_id=".$id." ORDER BY id DESC");		//ανάκτηση στοιχείων συνδέσμων από τον πίνακα link
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {					//για κάθε σύνδεσμο
	if ($row["user"] == $professor_username) {						//αν αυτός που προσέθεσε τον σύνδεσμο είναι ο καθηγητής
		$user = "Καθηγητής";
	}
	else {											//αν όχι
		$user = $row["user"];
	}
	echo "Σύνδεσμος: <a href='".$row["url"]."' target='_blank'>".$row["description"]."</a>, "."Χρήστης: ".$user."<br>";
												//εμφάνιση στοιχείων συνδέσμου
}
?>
		</div>
		<br> <br> <p class="big center"> Αρχεία σχετικά με την εργασία </p> <br> <br>
		<form method="post" action="upload_source_file.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
			<input type="file" name="file" required />
			Περιγραφή <input type="text" name="description" required />
			<button type="submit"> Ανέβασμα Αρχείου </button>
		</form>
		<div class="source">
<?php
$result = $link->query("SELECT * FROM source_file WHERE project_id=".$id." ORDER BY id DESC");	
												//ανάκτηση στοιχείων αρχείων από τον πίνακα source_file
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {					//για κάθε αρχείο
	if ($row["user"] == $professor_username) {						//αν αυτός που ανέβασε το αρχείο είναι ο καθηγητής
		$user = "Καθηγητής";
	}
	else {											//αν όχι
		$user = $row["user"];
	}
	echo "Αρχείο: <a href='".$row["path"]."' target='_blank'>".$row["description"]."</a>, "."Χρήστης: ".$user."<br>";
												//εμφάνιση στοιχείων αρχείου
}
?>
		</div>
		<br> <br> <p class="big center"> Chat Ομάδας </p> <br> <br>
		<form method="post" action="send_group_message.php?id=<?php echo $id; ?>">
			Κείμενο: <br>
			<textarea id="group_message" name="message_text" rows="3" cols="55" required ></textarea> <br>
			<button type="submit"> Αποστολή </button>
		</form>
		<div class="group_chat">
<?php
$result = $link->query("SELECT * FROM group_chat WHERE project_id=".$id." ORDER BY group_chat.id DESC");
												//ανάκτηση μηνυμάτων από τον πίνακα group_chat
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {					//για κάθε μήνυμα
	if ($row["user"] == $professor_username) {						//αν ο αποστολέας είναι ο καθηγητής
		$user = "Καθηγητής";
	}
	else {											//αν όχι
		$user = $row["user"];
	}
	echo "<b>".$user."</b>: ".str_replace("\n", "\n<br>", $row["text"])."<br>";		//εμφάνιση στοιχείων μηνύματος
}
$result->free();
$result2->free();
$link->close();											//κλείσιμο σύνδεσης με βάση
?>
		</div>
	</div>
<script>
	if (window.innerWidth < 1100){								//προσαρμογή αριθμού στηλών ανάλογα με το μέγεθος οθόνης
			document.getElementById("group_message").setAttribute("cols", "35");
	}
</script>
</body>
</html>
