<?php	
	include("Common/icon.php");
		//echo $_REQUEST['opt'];
/*		if ($_REQUEST['opt'] == "export"){//导出的操作
			$file_type = "vnd.ms-excel";
			$file_ending = "xls";
			$default_time = date("Ymd",time());
			$filename = $default_time.rand(1000,9999);
			header("Content-Type: application/$file_type;charset=utf-8");
			header("Content-Disposition: attachment; filename=$filename.$file_ending");
			header("Pragma: no-cache");
			header("Expires: 0");
									
					}
*/
	include("top_hw.html");
	include("Common/mysql.php");
	//include("Public/js/date.js");
	include("Common/page.class.php");
	include("Common/functions_main.php");
	include("Common/functions_hw.php");
	include('Common/outerror.php');
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	//print_r ($_POST);

	$select_department = isset($_POST['department'])?$_POST['department']:''; 
	$select_object = isset($_POST['object'])?$_POST['object']:''; 
	$select_type = isset($_POST['type'])?$_POST['type']:''; 
	$select_area = isset($_POST['hw_area'])?$_POST['hw_area']:''; 
	$select_user= isset($_POST['hw_user'])?$_POST['hw_user']:''; 
	$_SESSION['hw_department']=$select_department;
	$_SESSION['hw_object']=$select_object;
	$_SESSION['hw_type']=$select_type;
	$_SESSION['area']=$select_area;
	$_SESSION['user']=$select_user;



	//print_r($_SESSION);
?>

	<style type="text/css">
		table, th,td {
		text-align:center;
		letter-spacing:1px;
		 }

	</style>
<script src="layui/layui.js" charset="utf-8"></script>
<script>
layui.use('laydate', function(){
  var laydate = layui.laydate;
  //同时绑定多个
  lay('.half').each(function(){
    laydate.render({
      elem: this
      ,trigger: 'click'
    });
  });
}); 
</script>
	<form name='f_export' action="p_list_hw.php" method="post">
		<label class="required" for="start_time">开始日期:</label>
		<input type="text" id="start_time" class="half"  value="<?php echo $start_time?>"  name="start_time"  style='text-align:center' />

		<label class="required" for="end_time">结束日期:</label>
		<input type="text" id="end_time" class="half"  value="<?php echo $end_time?>"  name="end_time"   style='text-align:center' />

		<label for="select1">部门:</label>
		<select  style="height:30px" name="department" >
			<option value="0">-所有-</option>
			<?php readdepartment() ?>
		</select>
		<label for="select1">维护对象:</label>
		<select  style="height:30px" name="object" >
			<option value="0">-所有-</option>
			<?php readobject() ?>
		</select>
		<label for="select1">维护类型:</label>
		<select style="height:30px" name="type">
			<option value="0">--所有--</option>
			<?php readtype() ?>
		</select>
		
		<label for="select1">处理人:</label>
		<select  style="height:30px" name="hw_user" >
			<option value="0">-所有-</option>
			<?php readuserlist_all() ?>
		</select>
		<label for="select1">地区:</label>
		<select  style="height:30px" name="hw_area" >
			<option value="0">-所有-</option>
			<?php readarealist() ?>
		</select>
		<input type='hidden' name='opt' value='export'>
		<input type="submit" name="sub" class="btn btn-green big" value="查&nbsp;&nbsp;询"  />

	</form>
					
<?php
	$department=$_POST['department'];
	$object=$_POST['object'];
	$type=$_POST['type'];
	$hw_area=$_POST['hw_area'];
	$hw_user=$_POST['hw_user'];
	
	if (strtotime($start_time) <= strtotime($end_time)){
		if ($start_time=='' && $end_time=='' && $department==0 && $object==0 && $type==0 && $hw_area==0 && $hw_user==0){
			hw_p_list_default($start_time,$end_time,$department,$object,$type,$hw_area,$hw_user);
		}else{
			hw_p_list($start_time,$end_time,$department,$object,$type,$hw_area,$hw_user);
		}
	} else {
		//echo strtotime($start_time).'----------------'.strtotime($end_time);
		echo "<font color='red' size='4'><b>ERROR(100)非法时间段：开始时间 &nbsp;&nbsp;大于 &nbsp;&nbsp;结束时间</b></font>";
	}

	include("footer_hw.html");
	
?>