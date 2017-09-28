<meta charset="utf-8" />
<?php
session_start();                                                      //δημιουργία συνεδρίας
session_unset();                                                      //διαγραφή μεταβλητών συνεδρίας
session_destroy();                                                    //διαγραφή συνεδρίας
echo "<script> alert('Αποσυνδέθηκες.'); location.href = '../login_register_form.php'; </script>";
                                                                      //εμφάνιση κατάλληλου μηνύματος και ανακατεύθυνση στη σελίδα login_register_form.php
?>
