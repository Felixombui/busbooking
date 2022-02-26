<?php
include 'headers/headers.php';
if ( isset( $_POST['submit'] ) ) {
    //check if email exists in the system
    $phonenumber = addslashes( $_POST['phonenumber'] );
    $checkqry = mysqli_query( $config, "SELECT * FROM users WHERE phonenumber='$phonenumber'" );
    if ( mysqli_num_rows( $checkqry )>0 ) {
        $qryrow = mysqli_fetch_assoc( $checkqry );
        $names = $qryrow['fullnames'];
        $fullnames = explode( ' ', $names );
        $firstname = $fullnames[0];
        $permitted_chars = '0123456789';
        $randomstring = substr( str_shuffle( $permitted_chars ), 0, 4 ).'';
        //create link for password reset
        $newpassword = md5( $randomstring, false );
        mysqli_query( $config, "INSERT INTO recoverytokens(phonenumber,token) VALUES('$phonenumber','$newpassword')" );
        $chars = strlen( $phonenumber );
        if ( $chars<11 ) {
            $trimphone = ltrim( $phonenumber, '0' );
            $newphonenumber = '254'.$trimphone;
        }
        $message = urlencode( 'OTP:'.$randomstring );
        $url = 'https://sms.macrasystems.com/sendsms/index.php?username=Macra&senderid=SMARTLINK&phonenumber='.$newphonenumber.'&message='.$message;
        file_get_contents( $url );
        header( 'location:otp.php?phone='.$phonenumber );
    } else {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Phone number does not exist in our systems! <a href="recover.php" style="color:white;">Send new OTP</a>';
    }
}
?>
<form action = '' method = 'post'>
<table align = 'center' width = '80%'>
<tr><td><div style = 'color:orange'><h3>Password Recovery.</h3></div></td></tr>
<tr><td>
<table width = '30%' align = 'center'>
<tr><td><input type = 'text' name = 'phonenumber' placeholder = 'Enter your phonenumber' style = 'width: 100%;'><input type = 'submit'  name = 'submit' value = 'Send OTP' style = 'width:100%'></td></tr>

<tr><td><?php echo $info ?></td></tr>
</table>
</td></tr>
</table>
</form>
<div class = 'footer'>Created and maintained by <a href = 'macrasystems.com'>Macra Systems</a> | Read our <a href = 'termsandconditions.html'>Terms and conditions</a> | <a href = 'privacy.html'>Privacy Policy</a></div>
<?php
include 'styles/styles.html';
?>