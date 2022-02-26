<?php
include 'headers/headers.php';
$token = $_GET['token'];
$checktoken = mysqli_query( $config, "SELECT * FROM recoverytokens WHERE token='$token'" );
$tokenrow = mysqli_fetch_assoc( $checktoken );
$phonenumber = $tokenrow['phonenumber'];
$checkuser = mysqli_query( $config, "SELECT * FROM users WHERE phonenumber='$phonenumber'" );
$userRow = mysqli_fetch_assoc( $checkuser );
$fullnames = $userRow['fullnames'];
if ( isset( $_POST['submit'] ) ) {
    $newpassword = addslashes( $_POST['newpassword'] );
    $condifrmpassword = addslashes( $_POST['confirmpassword'] );
    if ( empty( $newpassword ) ) {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">You must create a new password!';
    } elseif ( !$newpassword == $condifrmpassword ) {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Your passwords do not match!';
    } else {
        $password = md5( $newpassword, false );
        if ( mysqli_query( $config, "UPDATE users SET `password`='$password' WHERE phonenumber='$phonenumber'" ) ) {
            $info = '<div class="success"><img src="images/success.png" width="20" height="20" align="left">Your password was changed successfully. <a href="signin.php" style="color:white;">Sign in now</a>';
        }
    }
}
?>
<form action = '' method = 'post'>
<table align = 'center' width = '80%'>
<tr><td><div style = 'color:orange'><h3>Password Recovery.</h3></div></td></tr>
<tr><td>
<table width = '30%' align = 'center'>
<tr><td style = 'color:orange; font-weight:bold;'><?php echo $fullnames ?></td></tr>
<tr><td><input type = 'password' name = 'newpassword' placeholder = 'Enter new password' style = 'width: 100%;'>
<input type = 'password' name = 'confirmpassword' style = 'width:100%' placeholder = 'Confirm password'>
<input type = 'submit'  name = 'submit' value = 'Change Password' style = 'width:100%'></td></tr>

<tr><td><?php echo $info ?></td></tr>
</table>
</td></tr>
</table>
</form>
<div class = 'footer'>Created and maintained by <a href = 'macrasystems.com'>Macra Systems</a> | Read our <a href = 'termsandconditions.html'>Terms and conditions</a> | <a href = 'privacy.html'>Privacy Policy</a></div>
<?php
include 'styles/styles.html';
?>