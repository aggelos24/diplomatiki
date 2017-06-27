<?php
function connect_to_database($destination) {                                //συνάρτηση για σύνδεση στη βάση
    $link = mysqli_connect ("localhost", "root", "", "diplomatiki");        //απόπειρα σύνδεσης στη βάση
    if (!$link) {                                                           //αν αποτυχία
        echo "<script> alert('Κάτι πήγε στραβά.'); location.href = '".$destination."'; </script>";
                                                                            //εμφάνιση κατάλληλου μηνύματος και επιστροφή στη σελίδα lhome.php
    }
    $link->query ("SET CHARACTER SET utf8");
    $link->query ("SET COLLATION_CONNECTION=utf8_general_ci");
    return $link;
}
