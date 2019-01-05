<?php
  $pid=$_GET['pid'];  
include("mysql.php");
  $sql="select t_id,type from hardware_type where o_id='$pid'";  
  $result=$mysqli->query($sql);
  while($rows=$result->fetch_assoc()){  
   echo "<option value=".$rows['t_id'].">";  
      echo $rows['type'];  
   echo "</option>n";  
  }  
?>  




<?php
	function readobject() {
		include("mysql.php");
		$sql = "select o_id,object from hardware_object ";
		$result=$mysqli->query($sql);	
			if ($result->num_rows>0){
				while ($rows = $result->fetch_assoc()){
					if($rows['o_id']==$_SESSION['hw_object']){
						echo "<option value='{$rows['o_id']}' selected='selected'>".$rows['object']."</option>";
					} else {
						echo "<option value='{$rows['o_id']}'>".$rows['object']."</option>";
					}
				}
			} else {
				echo "<option value=''>无</option>";
			}
	}

?>
