<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<link rel="shortcut icon" href="logo.png" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title> Μάθημα Ιστορίας Δ' Δημοτικού </title>
	<script>
		function validate_pass() {																		//με το πάτημα του κουμπιού έλεγχος αν ο κωδικός πρόσβασης είναι ίδιος και στα 2 πεδία
			var pass = document.forms["register"]["password"].value;
			var repass = document.forms["register"]["retype"].value;
			if (!(pass === repass)) {
				alert("Ο Κωδικός Πρόσβασης πρέπει να είναι ο ίδιος!");
				return false;
			}
		}	
	</script>	
</head>
<body>
	<img src="banner.png" alt="Ιστορία Δ' Δημοτικού Στα Αρχαία Χρόνια" class="banner">
	<div class="main">
		Καλώς ήρθατε στην ιστοσελίδα η οποία είναι αφιερωμένη στην διδασκαλία του μαθήματος Ιστορία Δ' Δημοτικού. <br> <br>
		<form method="post" action="login.php">
			<span class="red_letters"> Αν έχεις ήδη λογαριασμό: </span> <br>
			Όνομα Χρήστη: <input type="text" name="username"> <br>
			Κωδικός Πρόσβασης: <input type="password" name="password"> <br>
			<button type="submit"> Σύνδεση </button>
		</form> <br>
		<form name="register" onsubmit="return validate_pass()" method="post" action="register.php">
			<span class="red_letters"> Αν δεν έχεις λογαριασμό, φτιάξε: </span> <br>
			Όνομα Χρήστη: <input type="text" name="username" required /> <br>
			Κωδικός Πρόσβασης: <input type="password" name="password" required /> <br>
			Ξαναγράψτε τον Κωδικό Πρόσβασης: <input type="password" name="retype" /> <br>
			Email: <input type="email" name="email" required /> <br>
			<button type="submit"> Εγγραφή </button>
		</form> <br>
<?php
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 			//απόπειρα σύνδεσης στη βάση
if (!$link) {										//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); </script>";				//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$result = $link->query ("SELECT email FROM user WHERE professor=1");			//ανάκτηση email του εκπαιδευτικού
$row = $result->fetch_array();
$result->free();
$link->close();										//κλείσιμο σύνδεσης με βάση
?>
Για τυχόν προβλήματα ή απορίες για την λειτουργία της ιστοσελίδας επικοινωνήστε στο <a href="mailto:<?php echo $row["email"]; ?>" target="_top"> <?php echo $row["email"]; ?> </a>
</body>
</html>
