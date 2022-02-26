<?php
include 'headers/headers.php';
$ms = $_GET['ms'];
if ( $ms == 1 ) {
    $notice = '<div style="color:red; background-color:cyan; width:100%;"><img src="images/error.png" width="20" height="20" align="left">You must be signed in!</div>';
}
$locationredirect = $_GET['loc'];
if ( !$locationredirect ) {
    $locationredirect = 'index.php';
}
if ( isset( $_POST['signin'] ) ) {
    $emailaddress = addslashes( $_POST['emailaddress'] );
    $password = addslashes( $_POST['password'] );
    if ( empty( $emailaddress ) ) {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Enter your email address! <a href="signin.php" style="float:right; font-size:12; font-weight:bold; text-decoration:none;">X</a> </div>';
    } elseif ( empty( $password ) ) {
        $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Enter your password! <a href="signin.php" style="float:right; font-size:12; font-weight:bold; text-decoration:none;">X</a> </div>';
    } else {
        $password = md5( $password, false );
        $loginqry = mysqli_query( $config, "SELECT * FROM users WHERE emailaddress='$emailaddress' AND password='$password'" );
        if ( mysqli_num_rows( $loginqry )>0 ) {
            $loginrow = mysqli_fetch_assoc( $loginqry );
            $_SESSION['user'] = $loginrow['fullnames'];
            $_SESSION['emailaddress'] = $loginrow['emailaddress'];
            $_SESSION['phonenumber'] = $loginrow['phonenumber'];
            if ( isset( $_POST['keepsignin'] ) ) {
                setcookie( 'user', $_SESSION['emailaddress'], 11352960000 );
            }
            header( 'location:'.$locationredirect );
        } else {
            $info = '<div class="error"><img src="images/error.png" width="20" height="20" align="left">Login failed! Wrong user credentials. <a href="signin.php" style="float:right; font-size:12; font-weight:bold; text-decoration:none;">X</a> </div>';
        }
    }
}
?>
<form action = '' method = 'post'>
<table align = 'center' width = '80%'>
<tr><td><div style = 'color:orange'><h3>Sign in.</h3></div></td></tr>
<tr><td>
<table width = '30%' align = 'center'>
<tr><td><?php echo $notice ?></td></tr>
<tr><td><input type = 'email' name = 'emailaddress' placeholder = 'Enter your email address'></td></tr>
<tr><td><input type = 'password' name = 'password' placeholder = 'Enter your password'></td></tr>
<tr><td><input type = 'submit' name = 'signin' value = 'Sign in' style = 'width:100%;'></td></tr>
<tr><td><a href = 'recover.php' style = 'color:blue;'>Forgot your password?</a></td></tr>
<tr><td><input type = 'checkbox' name = 'keepsignin'> Keep me signed in</td></tr>
<tr><td><?php echo $info ?></td></tr>
</table>
</td></tr>
</table>
</form>
<div class = 'footer'>Created and maintained by <a href = 'macrasystems.com'>Macra Systems</a> | Read our <a href = 'termsandconditions.html'>Terms and conditions</a> | <a href = 'privacy.html'>Privacy Policy</a></div>
<?php
include 'styles/styles.html';
?>