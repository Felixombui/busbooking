<?php
include 'headers/headers.php';
if ( !$_SESSION['user'] ) {
    header( 'location:signin.php?ms=1' );
}
$id = $_GET['id'];
$s = $_GET['s'];
$tripqry = mysqli_query( $config, "SELECT * FROM trips WHERE id='$id'" );
$triprow = mysqli_fetch_assoc( $tripqry );
$cost = $triprow['cost'];
$regplate = $triprow['regplate'];
$vhqry = mysqli_query( $config, "SELECT * FROM vehicles WHERE regplate='$regplate'" );
$vhrow = mysqli_fetch_assoc( $vhqry );
$seats = $vhrow['noofseats'];
if ( !empty( $s ) ) {
    $form = '<form method="POST">
    <table>
    <tr><th>Payments</th></tr>
    <tr><td>To make payments<br>
    1. Go to MPesa<br>
    2. Lipa na MPesa<br>
    3. Buy goods<br>
    4. Enter Till Number 5354881<br>
    5. Enter Amount: '.$cost.'<br>
    6. Enter your pin and confirm<br>
    <input type="text" name="tripid" value="'.$id.'" hidden>
    <input type="text" name="transactionid" placeholder="Enter Payment Transaction Code" style="width:100%"><input type="submit" name="submit" value="Submit" style="width:100%;">
    </table>
    </form>';
}
if ( isset( $_POST['submit'] ) ) {
    $transactionid = addslashes( $_POST['transactionid'] );
    $pmtqry = mysqli_query( $config, "SELECT * FROM payments WHERE transactionid='$transactionid'" );
    if ( mysqli_num_rows( $pmtqry )>0 ) {
        $pmtrow = mysqli_fetch_assoc( $pmtqry );
        $status = $pmtrow['status'];
        if ( $status == 'Unused' ) {
            $id = $_POST['tripid'];
            mysqli_query( $config, "UPDATE payments SET `status`='Used' WHERE transactionid='$transactionid'" );
            header( 'location:seatassignment.php?s='.$s.'&t='.$id );
        } else {
            $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left"> The transaction has been used already!</div>';
        }
    } else {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left"> Your payment has not been received!</div>';
    }
}
?>
Select your prefered seat please.
<?php
if ( $seats == 14 ) {
    echo "<div style = 'float: left; width:200px; margin-top:150px; background-color:cyan; border:1px solid pink; box-shadow:4px 4px solid silver;'>";
} else {
    echo "<div style = 'float: left; width:262px; margin-top:150px; background-color:cyan; border:1px solid pink; box-shadow:4px 4px solid silver;'>";
}
echo "<div style = 'width: 50px; border:1px solid white; float:right; margin:5px; color:white;'>Driver</div>";
$seat = 0;
for ( $i = 0; $i < $seats ; $i++ ) {
    $seat = $seat+1;
    //if ( $i == 2 ) {
    //  echo "<div style = 'width: 50px; border:1px solid cyan; float:left; margin:5px;'>Driver</div>";
    // $i = 3;
    //} else {
    $checkseat = mysqli_query( $config, "SELECT * FROM booking WHERE tripid='$id' AND seat='$seat'" );
    if ( mysqli_num_rows( $checkseat )>0 ) {
        echo "<div class='seats' style = 'width: 52px; border:1px solid cyan; float:left; margin:5px; background-color:grey;'>$seat</div>";

    } else {
        echo "<a href='book.php?s=".$seat.'&id='.$id."'><div class='seats' style = 'width: 52px; border:1px solid cyan; float:left; margin:5px;'>$seat</div></a>";
    }

}
?>
</div>
<table style = 'float:right; width:50%'>
<tr><td><?php echo $form ?></td></tr>
<tr><td><?php echo $info ?></td></tr>
</table>
<?php include 'styles/styles.html' ?>