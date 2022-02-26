<?php
include 'headers/headers.php';
if ( !$_SESSION['user'] ) {
    header( 'location:signin.php?ms=1' );
}
$token = $_GET['s'];
$tktqry = mysqli_query( $config, "SELECT * FROM booking WHERE token='$token'" );
$tktrow = mysqli_fetch_assoc( $tktqry );
$ticketno = $tktrow['id'];
$customer = $tktrow['passengername'];
$vehicle = $tktrow['regplate'];
$customerphone = $tktrow['passengerphone'];
$journey = $tktrow['from'].'-'.$tktrow['to'];
$cost = $tktrow['cost'];
$date = $tktrow['date'];
$time = $tktrow['departuretime'];
$seat = $tktrow['seat'];
?>
<table width = '80%' align = 'center' ><tr><td align = 'center'>
<table width = '50%'style = 'border-collapse: collapse; border:1px solid pink; margin-top:50px; border-radius:5px;' ><tr><td>
<div style = 'background-color: orange; color:white; margin-top:0px;'><img src = 'images/success.png' width = '30' height = '30' align = 'left'><h2>Booking successful</h2></div>
</td></tr>
<tr><td>
<?php echo '<div style="background-color:cyan;"><a href="pdfticket.php?pdf='.$token.'" style="color:blue;"><img src="images/pdf.png" width="23" height="23" align="left">Download Ticket</a></div>' ?>
</td></tr>
<tr><td>
<table width = '100%'><tr><td>Ticket No#: <?php echo $ticketno ?></td><td>Passenger: <?php echo $customer ?></td></tr>
<tr><td>Vehicle Registration: <?php echo $vehicle ?></td></tr>
<tr><td>Seat Number: <?php echo $seat ?></td></tr>
<tr><td>Customer Phone: <?php echo $customerphone ?></td><td>Journey: <?php echo $journey ?></td></tr>
<tr><td>Fare Paid: Ksh.<?php echo number_format( $cost, 2 ) ?></td></tr>
<tr><td>Date of Journey: <?php echo $date ?></td><td>Departure Time: <?php echo $time ?></td></tr>
</table>
<table width = '100%'><tr><td style = 'background-color: red; color:white'><b>Note: </b>Please be at the stage 30 minutes before departure time.</td></tr></table>
</td></tr>
</table>
</td></tr></table>
<?php
include 'styles/styles.html';
?>