<?php
     // state options
   require_once "database.php";
   $state_id = $_POST["state"];
 //  print_r($state_id); die;
   $result = mysqli_query($conn,"SELECT * FROM ms_district_master where state_id = $state_id");
?>
<option value="">Select City</option> 

<?php 
while($row = mysqli_fetch_array($result)) {
?>
<option value="<?php echo $row["district_id"];?>" ><?php echo $row["district_name"];?></option>
<?php
} 
?>