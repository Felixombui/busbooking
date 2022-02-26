<?php
include 'headers/headers.php';
if ( !$_SESSION['user'] ) {
    header( 'location:signin.php?ms=1' );
}
$seat = $_GET['s'];
$trip = $_GET['t'];
$checktrip = mysqli_query( $config, "SELECT * FROM trips WHERE id='$trip'" );
$triprow = mysqli_fetch_assoc( $checktrip );
$regplate = $triprow['regplate'];
$from = $triprow['from'];
$to = $triprow['to'];
$departuretime = $triprow['departuretime'];
$date = $triprow['tripdate'];
$cost = $triprow['fare'];
$passengername = $_SESSION['user'];
$passengerphone = $_SESSION['phonenumber'];
echo 'Trip: '.$trip.'<br>';
echo 'Seat: '.$seat.'<br>';
$token = md5( $trip.''.$seat );
if ( mysqli_query( $config, "INSERT INTO booking(tripid,regplate,passengername,passengerphone,seat,`from`,`to`,cost,`date`,departuretime,token) VALUES('$trip','$regplate','$passengername','$passengerphone','$seat','$from','$to','$cost','$date','$departuretime','$token')" ) ) {

    header( 'location:payments.php?s='.$token );
}

?>