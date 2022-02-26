<?php
include 'headers/headers.php';
if ( isset( $_COOKIE['user'] ) ) {
    $emailaddress = $_COOKIE['user'];
    $loginqry = mysqli_query( $config, "SELECT * FROM users WHERE emailaddress='$emailaddress'" );
    if ( mysqli_num_rows( $loginqry )>0 ) {
        $loginrow = mysqli_fetch_assoc( $loginqry );
        $_SESSION['user'] = $loginrow['fullnames'];
        $_SESSION['emailaddress'] = $loginrow['emailaddress'];
        $_SESSION['phonenumber'] = $loginrow['phonenumber'];
    }
}
if ( isset( $_POST['check'] ) ) {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];
    $tripqry = mysqli_query( $config, "SELECT * FROM trips WHERE `from`='$from' AND `to`='$to' AND tripdate='$date'" );
    $tripsfound = mysqli_num_rows( $tripqry );
    if ( $tripsfound>0 ) {
        $tableheader = "<tr style = 'text-align: left; background-color:orange; color:white;'><th>Company</th><th>Registration</th><th>Departure Time</th><th>Fare</th><th>Seats remaining</th><th></th></tr>";
    }
    $info = $tripsfound. ' trip(s) found for the date '.$_POST['date'];
}
?>
<form action = '' method = 'post'>
<table align = 'center' width = '80%'>
<tr><td><div style = 'color:orange'><h3>Book your ticket now.</h3></div></td></tr>
<tr><td>From:
<select name = 'from'>
<option selected><?php echo $_POST['from'] ?></option>
<option>Nairobi</option>
<option>Mombasa</option>
</select>
To:
<select name = 'to'>
<option selected><?php echo $_POST['to'] ?></option>
<option>Nairobi</option>
<option>Mombasa</option>
</select>
Date
<input type = 'date' name = 'date' value = "<?php echo $_POST['date'] ?>">
<input type = 'submit' name = 'check' value = 'Check'>
</td></tr>
</table>
</form>
<table width = '80%' align = 'center'>
<tr><td style = 'background-color: cyan;'><?php echo $info ?> </td></tr>
<tr><td>
<table width = '100%'><?php echo $tableheader ?>
<?php
while( @$triprow = mysqli_fetch_assoc( $tripqry ) ) {
    $id = $triprow['id'];
    $company = $triprow['buscompany'];
    $registration = $triprow['regplate'];
    $departure = $triprow['departuretime'];
    $fare = $triprow['cost'];
    $vquery = mysqli_query( $config, "SELECT * FROM vehicles WHERE regplate='$registration'" );
    $vrow = mysqli_fetch_assoc( $vquery );
    $passengers = $vrow['noofseats'];
    $seats = mysqli_query( $config, "SELECT * FROM booking WHERE tripid='$id'" );
    $usedseats = mysqli_num_rows( $seats );
    $unusedseats = $passengers-$usedseats;
    if ( $unusedseats>0 ) {
        echo '<tr style="background-color:cyan;"><td>'.$company.'</td><td>'.$registration.'</td><td>'.$departure.'</td><td>'.number_format( $fare, 2 ).'</td><td>'.$unusedseats.'</td><td><a href="book.php?id='.$id.'" style="color:blue;">Book Now</a><tr>';
    }
}
?>
</table>
</td></tr>
</table>

<div class = 'footer'>Created and maintained by <a href = 'macrasystems.com'>Macra Systems</a> | Read our <a href = 'termsandconditions.html'>Terms and conditions</a> | <a href = 'privacy.html'>Privacy Policy</a></div>
<?php
include 'styles/styles.html';
?>