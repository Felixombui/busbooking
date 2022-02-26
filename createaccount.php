<?php
include 'headers/headers.php';
if ( isset( $_POST['signup'] ) ) {
    $fullnames = addslashes( $_POST['fullnames'] );
    $emailaddress = addslashes( $_POST['emailaddress'] );
    $phonenumber = $_POST['phonenumber'];
    $cpassword = addslashes( $_POST['cpassword'] );
    $rpassword = addslashes( $_POST['rpassword'] );
    $regdate = date( 'm/d/Y' );
    if ( empty( $fullnames ) ) {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Enter your full names! <a href="createaccount.php" style="float:right; font-size:12; font-weight:bold; text-decoration:none;">X</a> </div>';
    } elseif ( empty( $emailaddress ) ) {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Enter your email address! <a href="createaccount.php" style="float:right; font-size:12; font-weight:bold; text-decoration:none;">X</a> </div>';
    } elseif ( empty( $phonenumber ) ) {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Enter your phone number! <a href="createaccount.php" style="float:right; font-size:12; font-weight:bold; text-decoration:none;">X</a> </div>';
    } elseif ( empty( $cpassword ) ) {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Create a password! <a href="createaccount.php" style="float:right; font-size:12; font-weight:bold; text-decoration:none;">X</a> </div>';
    } elseif ( !$cpassword == $rpassword ) {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Your passwords do not match! <a href="createaccount.php" style="float:right; font-size:12; font-weight:bold; text-decoration:none;">X</a> </div>';
    } else {
        $chkqry = mysqli_query( $config, "SELECT * FROM users WHERE emailaddress='$emailaddress'" );
        if ( mysqli_num_rows( $chkqry )>0 ) {
            $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">An account using this email address exists. Did you <a href="recover.php">forget your password?</a> <a href="createaccount.php" style="float:right; font-size:12; font-weight:bold; text-decoration:none;">X</a> </div>';
        } else {
            $password = md5( $cpassword, false );
            if ( mysqli_query( $config, "INSERT INTO users(fullnames,emailaddress,phonenumber,`password`,regdate) VALUES('$fullnames','$emailaddress','$phonenumber','$password','$regdate' )" ) ) {
                $info = '<div class="success"><img src="images/success.png" width="20" height="20" align="left">Your account has been created successfully. <a href="signin.php" style="float:right; font-size:12; font-weight:bold; text-decoration:none;">X</a> </div>';
            }
        }
    }
}
?>
<form action = '' method = 'post'>
<table align = 'center' width = '80%'>
<tr><td><div style = 'color:orange'><h3>Sign up.</h3></div></td></tr>
<tr><td>
<table width = '30%' align = 'center' style = 'border-collapse: collapse; border:1px solid pink; box-shadow:2px 2px cyan'>
<tr><td style = 'padding:8px;'><?php echo $info ?></td></tr>
<tr><td style = 'padding:8px;'><input type = 'text' name = 'fullnames' placeholder = 'Enter your full names' style = 'width:100%;'></td></tr>
<tr><td style = 'padding:8px;'><input type = 'email' name = 'emailaddress' placeholder = 'Enter your emailaddress'></td></tr>
<tr><td style = 'padding:8px;'><input type = 'text' name = 'phonenumber' placeholder = 'Enter your phone number' style = 'width:100%;'></td></tr>
<tr><td style = 'padding:8px;'><input type = 'password' name = 'cpassword' placeholder = 'Create a password'></td></tr>
<tr><td style = 'padding:8px;'><input type = 'password' name = 'rpassword' placeholder = 'Confirm password'></td></tr>
<tr><td style = 'padding:8px;'><input type = 'submit' name = 'signup' value = 'Create Account' style = 'width:100%;'></td></tr>
<tr><td style = 'padding:8px;'>Already have an account?<a href = 'signin.php' style = 'color:blue;'> Sign in</a></td></tr>
<tr><td style = 'padding:3px;'>By clicking 'Create Account' you agree to our <a href = 'termsandconditions.html' style = 'color:blue;
'>terms and conditions</a></td></tr>

</table>
</td></tr>
</table>
</form>
<div class = 'footer'>Created and maintained by <a href = 'macrasystems.com'>Macra Systems</a> | Read our <a href = 'termsandconditions.html'>Terms and conditions</a> | <a href = 'privacy.html'>Privacy Policy</a></div>
<?php
include 'styles/styles.html';
?>