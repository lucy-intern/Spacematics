<!DOCTYPE html>
<html>
<head>
 <title>Table with database</title>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
</head>
<body>
  <canvas id="myChart" width="200" height="100"></canvas>
 <?php
 $threshold = 0.6;
$timestamp = time();
$date = gmdate("Y-m-d H:i:s", $timestamp);
$offset = 7200;

$formselector = htmlspecialchars($_POST['formselector']);

if ( $formselector == 1) {
  $startdate = $timestamp - (24*60*60);
  $enddate = $timestamp;
  echo "Showing the database of last 24 hours" . "</br>" . "</br>";
}
elseif ($formselector == 2) {
  $startdate = $timestamp - (24*60*60*31);
  $enddate = $timestamp;
  echo "Showing the database of last month" ."</br>" . "</br>";
}
elseif ($formselector == 3) {
  $startdate = $timestamp - (24*60*60*30*12);
  $enddate = $timestamp;
  echo "Showing the database of last year" ."</br>" . "</br>";
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

$Eating_count = 0;
$Reading_count = 0;
$TOP_count = 0;
$Head = array();
$Head_count = 0;


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
            if($row["Eating"] >= $threshold) {
          $Eating_count++;
        }
        if($row["Phone"] >= $threshold) {
          $TOP_count++;
        }
        if($row["Reading"] >= $threshold) {
          $Reading_count++;
        }
        $Head_count = $Head_count + $row["Headn"];
        if( $row["Headn"] == NULL){
        array_push($Head, 0);
        }
        else{
        array_push($Head, $row["Headn"]);
      }
          }
        break;
          case 2:
           if ( $row["RID"] == 'A') {
             if($row["Eating"] >= $threshold) {
          $Eating_count++;
        }
        if($row["Phone"] >= $threshold) {
          $TOP_count++;
        }
        if($row["Reading"] >= $threshold) {
          $Reading_count++;
        }
        $Head_count = $Head_count + $row["Headn"];
        if( $row["Headn"] == NULL){
        array_push($Head, 0);
        }
        else{
        array_push($Head, $row["Headn"]);
      }
          }
          break;
          case 3:
           if ( $row["RID"] == '0' or $row["RID"] == 'A' ) {
             if($row["Eating"] >= $threshold) {
          $Eating_count++;
        }
        if($row["Phone"] >= $threshold) {
          $TOP_count++;
        }
        if($row["Reading"] >= $threshold) {
          $Reading_count++;
        }
        $Head_count = $Head_count + $row["Headn"];
        if( $row["Headn"] == NULL){
        array_push($Head, 0);
        }
        else{
        array_push($Head, $row["Headn"]);
      }
          }
          break;
          case 4:
           if ( $row["RID"] == 'B') {
             if($row["Eating"] >= $threshold) {
          $Eating_count++;
        }
        if($row["Phone"] >= $threshold) {
          $TOP_count++;
        }
        if($row["Reading"] >= $threshold) {
          $Reading_count++;
        }
        $Head_count = $Head_count + $row["Headn"];
        if( $row["Headn"] == NULL){
        array_push($Head, 0);
        }
        else{
        array_push($Head, $row["Headn"]);
      }
          }
          break;
          case 5:
           if ( $row["RID"] == '0' or $row["RID"] == 'B') {
             if($row["Eating"] >= $threshold) {
          $Eating_count++;
        }
        if($row["Phone"] >= $threshold) {
          $TOP_count++;
        }
        if($row["Reading"] >= $threshold) {
          $Reading_count++;
        }
        $Head_count = $Head_count + $row["Headn"];
        if( $row["Headn"] == NULL){
        array_push($Head, 0);
        }
        else{
        array_push($Head, $row["Headn"]);
      }
          }
          break;
          case 6:
           if ( $row["RID"] == 'A' or $row["RID"] == 'B') {
             if($row["Eating"] >= $threshold) {
          $Eating_count++;
        }
        if($row["Phone"] >= $threshold) {
          $TOP_count++;
        }
        if($row["Reading"] >= $threshold) {
          $Reading_count++;
        }
        $Head_count = $Head_count + $row["Headn"];
        if( $row["Headn"] == NULL){
        array_push($Head, 0);
        }
        else{
        array_push($Head, $row["Headn"]);
      }
          }
          break;
          case 7:
           if ( $row["RID"] == '0' or $row["RID"] == 'A' or $row["RID"] == 'B') {
             if($row["Eating"] >= $threshold) {
          $Eating_count++;
        }
        if($row["Phone"] >= $threshold) {
          $TOP_count++;
        }
        if($row["Reading"] >= $threshold) {
          $Reading_count++;
        }
        $Head_count = $Head_count + $row["Headn"];
        if( $row["Headn"] == NULL){
        array_push($Head, 0);
        }
        else{
        array_push($Head, $row["Headn"]);
      }
          }
          break;
        }

        }} }
        echo '---------Activty Counter--------' . "</br>";
        echo 'Eating ->' . $Eating_count."</br>";
        echo 'TOP ->' . $TOP_count . "</br>";
        echo 'Reading ->' . $Reading_count ."</br>". "</br>" ."</br>";

        $Eating_count_percentage = ($Eating_count*100) / ($Eating_count + $Reading_count +$TOP_count);
        $Reading_count_percentage = ($Reading_count*100) / ($Eating_count + $Reading_count +$TOP_count);
        $TOP_count_percentage = ($TOP_count*100) / ($Eating_count + $Reading_count +$TOP_count);
       
        echo '---------Activty Percentage--------' . "</br>";
        echo 'Eating ->' . round($Eating_count_percentage) . '%' ."</br>";
        echo 'TOP ->' . round($TOP_count_percentage) . '%'. "</br>";
        echo 'Reading ->' . round($Reading_count_percentage) . '%'."</br>" . "</br>" ."</br>";
        #echo 'Head Counter ->' . $Head_count . "</br>";

$conn->close();
?>

<script>
var Eating_count = "<?php echo $Eating_count ?>";
var Reading_count = "<?php echo $Reading_count ?>";
var TOP_count = "<?php echo $TOP_count ?>";

var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
          type: 'pie',
          data: {
              labels: ["Eating", "Reading", "Talking on phone"],
              datasets: [{
                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                data: [Eating_count,Reading_count,TOP_count]
             }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
                title: {
                    display: true,
                    text: 'Predicted Actions'
      }
    }
});

</script>
</table>
</body>
</html>