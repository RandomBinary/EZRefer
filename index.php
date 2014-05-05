<html>
<head>
<title>Referral program</title>
<link rel="stylesheet" type="text/css" href="css.css">
</head>
<Body>
<?php
include("./incl/config.php");
$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
$ip = $_SERVER['REMOTE_ADDR'];
$result = mysqli_query($link,"SELECT * FROM users WHERE ip = '$ip'");
$row = mysqli_fetch_array( $result );
$count=mysqli_num_rows($result);

if($count !== 0){
    echo "Welcome back, " . $row['ip'] . "!<br>";
    echo "You have " . $row['points'] . " points.<br>";
    echo "Your refferal link: " . $installdir . "/index.php?u=" . $row['id'];
	include("./incl/rewards.php");
} else {
    if (isset($_GET['u'])) {
        $refid = $_GET['u'];
        $ref = mysqli_query($link,"SELECT * FROM users WHERE id = '" . $refid . "'");
        $refrow = mysqli_fetch_array( $ref );
        $refpts = $refrow['points'] + 1;
        mysqli_query($link,"UPDATE users SET points='" . $refpts . "' WHERE id='" . $refid . "'");
    }
    $ip = $_SERVER['REMOTE_ADDR'];
    mysqli_query($link,"INSERT INTO users (ip, points) VALUES ('" . $ip . "', '0')");
    header("Location:index.php");
}
?>
</body>
</html>