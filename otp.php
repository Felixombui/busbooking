<?php
include 'headers/headers.php';
$phonenumber = $_GET['phone'];
if ( isset( $_POST['submit'] ) ) {
    $otp = md5( $_POST['otp'], false );
    $confirmotp = mysqli_query( $config, "SELECT * FROM recoverytokens WHERE phonenumber='$phonenumber' AND token='$otp' AND status='Waiting'" );
    if ( mysqli_num_rows( $confirmotp )>0 ) {
        $otprow = mysqli_fetch_assoc( $confirmotp );
        $token = $otprow['token'];
        if ( mysqli_query( $config, "UPDATE recoverytokens SET `status`='Used' WHERE token='$otp' AND phonenumber='$phonenumber'" ) ) {
            header( 'location:changepassword.php?token='.$token );
        }
    } else {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Error! Wrong otp! <a href="recover.php" style="color:white;">Send new OTP</a>';
    }
}
?>
<form action = '' method = 'post'>
<table align = 'center' width = '80%'>
<tr><td><div style = 'color:orange'><h3>Password Recovery.</h3></div></td></tr>
<tr><td>
<table width = '30%' align = 'center'>
<tr><td><input type = 'text' name = 'otp' placeholder = 'Enter OTP you received' style = 'width: 100%;'><input type = 'submit'  name = 'submit' value = 'Confirm' style = 'width:100%'></td></tr>

<tr><td><?php echo $info ?></td></tr>
</table>
</td></tr>
</table>
</form>
<div class = 'footer'>Created and maintained by <a href = 'macrasystems.com'>Macra Systems</a> | Read our <a href = 'termsandconditions.html'>Terms and conditions</a> | <a href = 'privacy.html'>Privacy Policy</a></div>
<?php
include 'styles/styles.html';
?>