<?php
	function readuserlist(){
		include("mysql.php");
		$sql = "select id,name from user where status='1';";
		$result=$mysqli->query($sql);	
			if ($result->num_rows>0){
				
				while ($rows = $result->fetch_assoc()){
					if($rows['id']==$_SESSION['user']){
						echo "<option value='{$rows['id']}' selected='selected'>".$rows['name']."</option>";
					}else{
						echo "<option value='{$rows['id']}'>".$rows['name']."</option>";
					}
				}
			} else {
				echo "<option value=''>无</option>";
			}
	}

	function readuserlist_all(){
		include("mysql.php");
		$sql = "select id,name,a_id,status from user order by status desc;";
		$result=$mysqli->query($sql);	
			if ($result->num_rows>0){
				while ($rows = $result->fetch_assoc()){
					if($rows['id']==$_SESSION['user'] && $rows['status']==0){
						echo "<option value='{$rows['id']}' selected='selected' style='color:#C0C0C0'>".$rows['name']."</option>";
					}elseif($rows['id']==$_SESSION['user']){
						echo "<option value='{$rows['id']}' selected='selected'>".$rows['name']."</option>";
					}elseif( $rows['status']==0){
						echo "<option value='{$rows['id']}' style='color:#C0C0C0'>".$rows['name']."</option>";
					}else{
						echo "<option value='{$rows['id']}'>".$rows['name']."</option>";
					}
				}
			} else {
				echo "<option value=''>无</option>";
			}
	}



	function readarealist(){
		include("mysql.php");
		$sql = "select a_id,area from area ";
		$result=$mysqli->query($sql);	
			if ($result->num_rows>0){
				
				while ($rows = $result->fetch_assoc()){
					if($rows['a_id']==$_SESSION['area']){
						echo "<option value='{$rows['a_id']}' selected='selected'>".$rows['area']."</option>";
					}else{
						echo "<option value='{$rows['a_id']}'>".$rows['area']."</option>";
					}
				}
			} else {
				echo "<option value=''>无</option>";
			}
	}
