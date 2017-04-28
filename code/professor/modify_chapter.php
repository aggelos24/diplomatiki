<meta charset="utf-8" />
<?php
$search = array("'", '"');
$replace = array("\'", '\"');
$chapter_text = str_replace($search, $replace, $_POST["chapter_text"]);			//για αποφυγή σφάλματος βάσης
if (!empty($_POST["youtube"])) {							//αν δεν έχει αφήσει το πεδίο youtube κενό
	$youtube = str_replace($search, $replace, $_POST["youtube"]);
}
$link = mysqli_connect ("localhost", "root", "", "diplomatiki"); 			//απόπειρα σύνδεσης στη βάση
if (!$link) {										//αν αποτυχία
    echo "<script> alert('Κάτι πήγε στραβά.'); location.href = 'show_chapter.php?section=".$_POST["section_number"]."&chapter=".$_POST["chapter_number"]."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα show_chapter.php
}
$link->query ("SET CHARACTER SET utf8");
$link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
$link->query ("UPDATE chapter SET title='".$_POST["title"]."', text='".$chapter_text."', image=DEFAULT, youtube=DEFAULT WHERE section_number=".$_POST["section_number"]." AND number=".$_POST["chapter_number"]);
											//ενημέρωση του πίνακα chapter
if (!empty($_POST["image"])) {								//αν δεν έχει αφήσει το πεδίο image κενό
	$link->query ("UPDATE chapter SET image='".$_POST["image"]."' WHERE section_number=".$_POST["section_number"]." AND number=".$_POST["chapter_number"]);
											//ενημέρωση πεδίου image του πίνακα chapter
}
if (!empty($_POST["youtube"])) {							//αν δεν έχει αφήσει το πεδίο youtube κενό
	$link->query ("UPDATE chapter SET youtube='".$youtube."' WHERE section_number=".$_POST["section_number"]." AND number=".$_POST["chapter_number"]);
											//ενημέρωση πεδίου youtube του πίνακα chapter
}
$link->close();										//κλείσιμο σύνδεσης με βάση
echo "<script> alert('Το κεφάλαιο επεξεργάστηκε.'); location.href = 'show_chapter.php?section=".$_POST["section_number"]."&chapter=".$_POST["chapter_number"]."'; </script>";
											//εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα show_chapter.php
?>
