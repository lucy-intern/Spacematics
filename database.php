<!DOCTYPE html>
<html>
<head>
 <title>Table with database</title>
</head>

<body>
<table border="5" cellspacing="5" cellpadding="5">
<tr >
  <th bgcolor=#3399FF>Time Stamp</th> 
  <th bgcolor=#3399FF>Eating</th> 
  <th bgcolor=#3399FF>Idle</th>
  <th bgcolor=#3399FF>TOP</th>
  <th bgcolor=#3399FF>Reading</th>
  <th bgcolor=#3399FF>Raspi-ID</th>
  <th bgcolor=#3399FF>Junta</th>
  <th bgcolor=#3399FF>People Reading</th>
  <th bgcolor=#3399FF>People TOP</th>
  <th bgcolor=#3399FF>No. of People</th>
 </tr>
 <?php
 $threshold = 0.6;
$timestamp = time();

$date = gmdate("Y-m-d H:i:s", $timestamp);
$offset = 7200;

$formselector = htmlspecialchars($_POST['formselector']);

if ( $formselector == 1) {
  $startdate = $timestamp - (24*60*60);
  $enddate = $timestamp;
  echo "Showing the database of last 24 hours";
}
elseif ($formselector == 2) {
  $startdate = $timestamp - (24*60*60*31);
  $enddate = $timestamp;
  echo "Showing the database of last month";
}
elseif ($formselector == 3) {
  $startdate = $timestamp - (24*60*60*30*12);
  $enddate = $timestamp;
  echo "Showing the database of last year";
}
elseif ($formselector == 4) {
  $start_date = htmlspecialchars($_POST['startdate']);
  $startdate = strtotime($start_date)+7200;
  $end_date = htmlspecialchars($_POST['enddate']);
  $enddate = strtotime($end_date)+7200;
  echo ("Showing the database from  " . gmdate("d-m-Y", $startdate) . " to " . gmdate("d-m-Y", $enddate) );
}
#echo $startdate;

$cam1 = 0;
$cam2 = 0;
$cam3 = 0;
if (isset($_POST['cam1'])) {
  $cam1 = htmlspecialchars($_POST['cam1']);
}
if (isset($_POST['cam2'])) {
  $cam2 = htmlspecialchars($_POST['cam2']);
}
if (isset($_POST['cam3'])) {
  $cam3 = htmlspecialchars($_POST['cam3']);
}

$cameraselector =  $cam1+$cam3+$cam2;
#echo $cameraselector;



$conn = mysqli_connect("35.226.147.71", "root", "", "lucy");
$action = 'NULL';
$i = 0;
  // Check connection
	if ($conn->connect_error)
   	echo "Connection error";
	else
    $sql = "SELECT ID, Eating, Idle, Phone, Reading, RID, USERS, Readno, TOP, Headn FROM Jarvis2";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) { #output data of each row
      while($row = $result->fetch_assoc()) {
        
        $data = strtotime($row["ID"]);
        $data_time = $data+$offset;

        if ( $data_time >= $startdate and $data_time <= $enddate) {

        switch ($cameraselector) {

          case 1:
          if ( $row["RID"] == '0') {
            echo "<tr>";
        echo "<td>" . $row["ID"]. "</td>";
        if($row["Eating"] <= $threshold) {
          echo "<td>" . $row["Eating"] . "</td>";
        }
        else {
          echo ("<td bgcolor=#DC143C >" . $row["Eating"] . "</td>"); 
        }
        if($row["Idle"] <= $threshold) {
          echo "<td>" . $row["Idle"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Idle"] . "</td>";
        }
        if($row["Phone"] <= $threshold) {
          echo "<td>" . $row["Phone"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Phone"] . "</td>";
        }
        if($row["Reading"] <= $threshold) {
          echo "<td>" . $row["Reading"] . "</td>";
        }
        else{
          echo "<td bgcolor=#DC143C >" . $row["Reading"] . "</td>";
        }
        echo "<td>" . $row["RID"] . "</td>";
        echo "<td>" . $row["USERS"] . "</td>";
        echo "<td>" . $row["Readno"] . "</td>";
        echo "<td>" . $row["TOP"] . "</td>";
        echo "<td>" . $row["Headn"] . "</td>";
        echo "</tr>";
          }
        break;
          case 2:
           if ( $row["RID"] == 'A') {
            echo "<tr>";
        echo "<td>" . $row["ID"]. "</td>";
        if($row["Eating"] <= $threshold) {
          echo "<td>" . $row["Eating"] . "</td>";
        }
        else {
          echo ("<td bgcolor=#DC143C >" . $row["Eating"] . "</td>"); 
        }
        if($row["Idle"] <= $threshold) {
          echo "<td>" . $row["Idle"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Idle"] . "</td>";
        }
        if($row["Phone"] <= $threshold) {
          echo "<td>" . $row["Phone"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Phone"] . "</td>";
        }
        if($row["Reading"] <= $threshold) {
          echo "<td>" . $row["Reading"] . "</td>";
        }
        else{
          echo "<td bgcolor=#DC143C >" . $row["Reading"] . "</td>";
        }
        echo "<td>" . $row["RID"] . "</td>";
        echo "<td>" . $row["USERS"] . "</td>";
        echo "<td>" . $row["Readno"] . "</td>";
        echo "<td>" . $row["TOP"] . "</td>";
        echo "<td>" . $row["Headn"] . "</td>";
        echo "</tr>";
          }
          break;
          case 3:
           if ( $row["RID"] == '0' or $row["RID"] == 'A' ) {
            echo "<tr>";
        echo "<td>" . $row["ID"]. "</td>";
        if($row["Eating"] <= $threshold) {
          echo "<td>" . $row["Eating"] . "</td>";
        }
        else {
          echo ("<td bgcolor=#DC143C >" . $row["Eating"] . "</td>"); 
        }
        if($row["Idle"] <= $threshold) {
          echo "<td>" . $row["Idle"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Idle"] . "</td>";
        }
        if($row["Phone"] <= $threshold) {
          echo "<td>" . $row["Phone"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Phone"] . "</td>";
        }
        if($row["Reading"] <= $threshold) {
          echo "<td>" . $row["Reading"] . "</td>";
        }
        else{
          echo "<td bgcolor=#DC143C >" . $row["Reading"] . "</td>";
        }
        echo "<td>" . $row["RID"] . "</td>";
        echo "<td>" . $row["USERS"] . "</td>";
        echo "<td>" . $row["Readno"] . "</td>";
        echo "<td>" . $row["TOP"] . "</td>";
        echo "<td>" . $row["Headn"] . "</td>";
        echo "</tr>";
          }
          break;
          case 4:
           if ( $row["RID"] == 'B') {
            echo "<tr>";
        echo "<td>" . $row["ID"]. "</td>";
        if($row["Eating"] <= $threshold) {
          echo "<td>" . $row["Eating"] . "</td>";
        }
        else {
          echo ("<td bgcolor=#DC143C >" . $row["Eating"] . "</td>"); 
        }
        if($row["Idle"] <= $threshold) {
          echo "<td>" . $row["Idle"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Idle"] . "</td>";
        }
        if($row["Phone"] <= $threshold) {
          echo "<td>" . $row["Phone"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Phone"] . "</td>";
        }
        if($row["Reading"] <= $threshold) {
          echo "<td>" . $row["Reading"] . "</td>";
        }
        else{
          echo "<td bgcolor=#DC143C >" . $row["Reading"] . "</td>";
        }
        echo "<td>" . $row["RID"] . "</td>";
        echo "<td>" . $row["USERS"] . "</td>";
        echo "<td>" . $row["Readno"] . "</td>";
        echo "<td>" . $row["TOP"] . "</td>";
        echo "<td>" . $row["Headn"] . "</td>";
        echo "</tr>";
          }
          break;
          case 5:
           if ( $row["RID"] == '0' or $row["RID"] == 'B') {
            echo "<tr>";
        echo "<td>" . $row["ID"]. "</td>";
        if($row["Eating"] <= $threshold) {
          echo "<td>" . $row["Eating"] . "</td>";
        }
        else {
          echo ("<td bgcolor=#DC143C >" . $row["Eating"] . "</td>"); 
        }
        if($row["Idle"] <= $threshold) {
          echo "<td>" . $row["Idle"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Idle"] . "</td>";
        }
        if($row["Phone"] <= $threshold) {
          echo "<td>" . $row["Phone"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Phone"] . "</td>";
        }
        if($row["Reading"] <= $threshold) {
          echo "<td>" . $row["Reading"] . "</td>";
        }
        else{
          echo "<td bgcolor=#DC143C >" . $row["Reading"] . "</td>";
        }
        echo "<td>" . $row["RID"] . "</td>";
        echo "<td>" . $row["USERS"] . "</td>";
        echo "<td>" . $row["Readno"] . "</td>";
        echo "<td>" . $row["TOP"] . "</td>";
        echo "<td>" . $row["Headn"] . "</td>";
        echo "</tr>";
          }
          break;
          case 6:
           if ( $row["RID"] == 'A' or $row["RID"] == 'B') {
            echo "<tr>";
        echo "<td>" . $row["ID"]. "</td>";
        if($row["Eating"] <= $threshold) {
          echo "<td>" . $row["Eating"] . "</td>";
        }
        else {
          echo ("<td bgcolor=#DC143C >" . $row["Eating"] . "</td>"); 
        }
        if($row["Idle"] <= $threshold) {
          echo "<td>" . $row["Idle"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Idle"] . "</td>";
        }
        if($row["Phone"] <= $threshold) {
          echo "<td>" . $row["Phone"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Phone"] . "</td>";
        }
        if($row["Reading"] <= $threshold) {
          echo "<td>" . $row["Reading"] . "</td>";
        }
        else{
          echo "<td bgcolor=#DC143C >" . $row["Reading"] . "</td>";
        }
        echo "<td>" . $row["RID"] . "</td>";
        echo "<td>" . $row["USERS"] . "</td>";
        echo "<td>" . $row["Readno"] . "</td>";
        echo "<td>" . $row["TOP"] . "</td>";
        echo "<td>" . $row["Headn"] . "</td>";
        echo "</tr>";
          }
          break;
          case 7:
           if ( $row["RID"] == '0' or $row["RID"] == 'A' or $row["RID"] == 'B') {
            echo "<tr>";
        echo "<td>" . $row["ID"]. "</td>";
        if($row["Eating"] <= $threshold) {
          echo "<td>" . $row["Eating"] . "</td>";
        }
        else {
          echo ("<td bgcolor=#DC143C >" . $row["Eating"] . "</td>"); 
        }
        if($row["Idle"] <= $threshold) {
          echo "<td>" . $row["Idle"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Idle"] . "</td>";
        }
        if($row["Phone"] <= $threshold) {
          echo "<td>" . $row["Phone"] . "</td>";
        }
        else {
          echo "<td bgcolor=#DC143C >" . $row["Phone"] . "</td>";
        }
        if($row["Reading"] <= $threshold) {
          echo "<td>" . $row["Reading"] . "</td>";
        }
        else{
          echo "<td bgcolor=#DC143C >" . $row["Reading"] . "</td>";
        }
        echo "<td>" . $row["RID"] . "</td>";
        echo "<td>" . $row["USERS"] . "</td>";
        echo "<td>" . $row["Readno"] . "</td>";
        echo "<td>" . $row["TOP"] . "</td>";
        echo "<td>" . $row["Headn"] . "</td>";
        echo "</tr>";
          }
          break;
        }

        }} }
    else { echo "0 results"; }

$conn->close();
?>
</table>
</body>
</html>