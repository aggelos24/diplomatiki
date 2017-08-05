<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="pstyles.css" />
	<link rel="shortcut icon" href="../logo.png" />
	<meta charset="utf-8" />
	<title> Σελίδα Εργασίας </title>
	<script>
		function logout() {										//με το πάτημα του κουμπιού αποσύνδεση χρήστη
			location.href = "logout.php";
		}
		
		function show_changelog() {									//με το πάτημα του κουμπιού εμφάνιση περιγραφών αλλαγών
			document.getElementById("changelog").style.display = "inline";
			document.getElementById("bchangelog").style.display = "none";
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
<?php
include "if_not_logged_p.php";											//έλεγχος αν έχει συνδεθεί ο καθηγητής
include "../connect_to_database.php";
if (isset($_GET["id"])) {											//αν υπάρχει η μεταβλητή GET
	$id = $_GET["id"];											//ανάθεσή της σε μεταβλητή
}
else {														//αν δεν υπάρχει
	echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'project_list.php'; </script>";		//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα project_list.php
	exit();													//τερματισμός script
}
if (isset($_GET["fail"])) {											//αν ο σύνδεσμος δεν είναι έγκυρος
	echo "<script> alert('Ο σύνδεσμος που εισήγαγες δεν είναι έγκυρος.'); </script>";			//εμφάνιση κατάλληλου μηνύματος
}
$link = connect_to_database("project_list.php");								//κλήση συνάρτησης για σύνδεση στη βάση δεδομένων
$result = $link->query ("SELECT * FROM project INNER JOIN groups ON project.id=groups.project_id WHERE project.id=".$id);
														//ανάκτηση στοιχείων εργασιών από τον πίνακα project και groups
$row_num = mysqli_num_rows($result);										//ανάθεση του αριθμού των επιστρεφόμενων εγγραφών σε μεταβλητή
for ($i=0; $row = mysqli_fetch_array($result, MYSQLI_ASSOC); $i++) {						//για κάθε μέλος ομάδας
	if ($i == 0) {												//εμφάνιση πληροφοριών εργασίας και φορμών για διαγραφή και βαθμολόγησή της
		echo "<p class='center'> <b> Τίτλος: </b> ".$row["title"].", Διορία μέχρι ".date("d-m-Y", strtotime($row["deadline"]))."</p> <br>";
		echo "Εκφώνηση:<br>";
		echo $row["description"]."<br>";
		echo "Μέλη Ομάδας: ".$row["user"].", ";
	}
	else if ($i == $row_num-1) {
		echo $row["user"]."<br>";
		if ($row["document"]) {										//αν κάποιος έχει ανέβασει την εργασία
			echo "<a href='../projects/project_".$id."/project.doc' target='_blank'> Αρχείο εργασίας </a>";
		}
		else {												//αν κανένας δεν έχει ανεβάσει ακόμα την εργασία
			echo "Δεν έχει ανέβει ακόμα κάποια εργασία";
		}
	}
	else {
		echo $row["user"].", ";
	}
}
?>
		<br> <button id="bchangelog" onclick="show_changelog()"> Εμφάνιση Ιστορικού Αλλαγών της Εργασίας </button>
		<div id="changelog" class="not_displayed">
<?php
$result = $link->query("SELECT * FROM project_change WHERE project_id=".$id." ORDER BY date DESC");		//ανάκτηση στοιχείων αλλαγών από τον πίνακα project_change
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {							//για κάθε αλλαγή
	echo "Χρήστης: ".$row["user"].", Ημερομηνία: ".date("d-m-Y", strtotime($row["date"]))."<br>Περιγραφή αλλαγής: ".$row["change_description"]."<br>";
}
?>
		</div>
		<br> <br> <p class="center"> Σύνδεσμοι σχετικοί με την εργασία </p> <br>
		<form method="post" action="insert_link.php?id=<?php echo $id; ?>">
			Διεύθυνση URL <input type="text" name="link" required />
			Περιγραφή <input type="text" name="description" required />
			<button type="submit"> Εισαγωγή Συνδέσμου </button>
		</form> <br>
		<div class="source_container">
<?php
$result = $link->query("SELECT * FROM link WHERE project_id=".$id." ORDER BY id DESC");				//ανάκτηση στοιχείων συνδέσμων από τον πίνακα link
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {							//για κάθε σύνδεσμο
	echo "Χρήστης: ".$row["user"].", Σύνδεσμος: <a href='".$row["url"]."' target='_blank'>".$row["description"]."</a> <br>";
														//εμφάνιση στοιχείων συνδέσμου
}
?>
		</div>
		<br> <br> <p class="center"> Αρχεία σχετικά με την εργασία </p> <br> <br>
		<form method="post" action="upload_source_file.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
			<input type="file" name="file" required />
			Περιγραφή <input type="text" name="description" required />
			<button type="submit"> Ανέβασμα Αρχείου </button>
		</form>
		<div class="source_container">
<?php
$result = $link->query("SELECT * FROM source_file WHERE project_id=".$id." ORDER BY id DESC");			//ανάκτηση στοιχείων αρχείων από τον πίνακα source_file
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {							//για κάθε αρχείο
	echo "Αρχείο: <a href='".$row["path"]."' target='_blank'>".$row["description"]."</a>, "."Χρήστης: ".$row["user"]."<br>";
														//εμφάνιση στοιχείων αρχείου
}
?>
		</div>
		<br> <br> <p class="center"> Chat Ομάδας </p> <br> <br>
		<form method="post" action="send_group_message.php?id=<?php echo $id; ?>">
		Κείμενο: <br>
		<textarea name="message_text" rows="3" cols="55" required ></textarea> <br>
		<button type="submit"> Αποστολή </button>
		</form>
		<div class="group_chat">
<?php
$result = $link->query("SELECT * FROM group_chat WHERE project_id=".$id." ORDER BY group_chat.id DESC");	//ανάκτηση μηνυμάτων από τον πίνακα group_chat
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {							//για κάθε μήνυμα
	echo "<b>".$row["user"]."</b>: ".str_replace("\n", "\n<br>", $row["text"])."<br>";			//εμφάνιση στοιχείων μηνύματος
}
$result->free();
$link->close();													//κλείσιμο σύνδεσης με βάση
?>
		</div>
	</div>
</body>
</html>
