
<?php
$mysql_db_hostname = "http://52.53.177.54/";
// $mysql_db_user = "root";
// $mysql_db_password = "12345";
// $mysql_db_database = "school";


$con = @mysqli_connect($mysql_db_hostname, $mysql_db_user, $mysql_db_password,
 $mysql_db_database);

if (!$con) {
 trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
}
$var = array();
 $sql = "SELECT latitude, longitude, time FROM geo";
$result = mysqli_query($con, $sql);

while($obj = mysqli_fetch_object($result)) {
$var[] = $obj;
}
echo '{"geos":'.json_encode($var).'}';
?>
