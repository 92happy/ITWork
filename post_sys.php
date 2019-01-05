<?php
	include("Common/icon.php");	
	include("Common/mysql.php");
	include('Common/outerror.php');
			
	$ip = $_SERVER["REMOTE_ADDR"];
	$area  = $_POST["area"];
	$date = $_POST["date"];
	$system_module = $_POST["system_module"];
	$system_types = $_POST["system_types"];
	$submit_user = trim($_POST["submit_user"]);
	$problem = trim($_POST["problem"]);
	$method = trim($_POST["method"]);
	$user = $_POST["user"];
	$week = date('W',strtotime($date));

	if ( $area == 0 || $system_types == 0 || $system_module == 0 ||  $problem == '' ||  $method == '' || $submit_user == '' || $user == 0  ){
		echo "<script>alert('提交失败,提交内容不完整');location.href='http://10.128.112.3/itwork/system.php'</script>"; 
	} else {
		$sql = "INSERT INTO system_problem(a_id,p_date,m_id,s_id,submit_user,problem,method,u_id,week,ip_address) VALUES('{$area}','{$date}','{$system_module}','{$system_types}','{$submit_user}','{$problem}','{$method}','{$user}','{$week}','{$ip}')";
		//echo $sql;exit;
		$mysqli->query($sql);
		echo "<script>alert('提交成功');location.href='http://10.128.112.3/itwork/p_list_sys.php'</script>"; 
	}


?>

