<?php 
	include("Common/icon.php");
	include("top_sys.html");
	include("Common/mysql.php");
	//include("Public/js/date.js");
	include("Public/js/erjiliandong.js");
	include("Common/functions_main.php");
	include("Common/functions_sys.php");
	include('Common/outerror.php');
	$default_time = date("Y-m-d",time());

?>
<script src="layui/layui.js" charset="utf-8"></script>
<script>
layui.use('laydate', function(){
  var laydate = layui.laydate;
  //常规用法
  laydate.render({
    elem: '#input-date'
  });
}); 
</script>
	<div id="mian">
		<div id="mian-content">
			<form action="post_sys.php" name="myform" method="post">
				<table border="0">
					<tr>
						<th style='text-align:center'><b>地区</b></th>
						<th style='text-align:center'><b>日期</b></th>
						<th style='text-align:center'><b>模块</b></th>
						<th style='text-align:center'><b>系统类型</b></th>
						<th style='text-align:center'><b>提报人</b></th>
						<th style='text-align:center'><b>具体问题</b></th>
						<th style='text-align:center'><b>处理办法</b></th>
						<th style='text-align:center'><b>问题接收人</b></th>
						
						<th>&nbsp;</td>
					</tr>
					<tr>
						<td>
							<!--<select  style="height:30px" name="area" id="area"  onChange="to_area('user');">-->
							<select  style="height:30px" name="area" id="area">
								<option value="0">-请选择-</option>
								<?php readarealist() ?>
							</select>
						</td>
						<td><input type="text" id="input-date"  style="text-align:center"  value="<?php echo $default_time?>" name="date" ></td>
						<td>
							<select  style="height:30px" name="system_module">
								<option value="0">-请选择-</option>
								<?php readmodulelist() ?>
							</select>
						</td>
						<td>
							<select style="height:30px" name="system_types">
								<option value="0">--请选择--</option>
								<?php readtypeslist() ?>
							</select>
						</td>
						<td><input type="text"  name="submit_user"  maxlength="5"></td>
						<td><input id="index-input" type="text"  name="problem"  maxlength="50"></td>
						<td><input  id="index-input" type="text"  name="method"  value="MDM、SS、SAP" maxlength="50"></td>
						<td>
							<select style="height:30px" name="user" id="user">
										<option value="0">--请选择--</option>
										<?php readuserlist() ?>
										
										
							</select>
						</td>

						<td><input id="" type="submit" name="submit" value="提  交"></td>
					</tr>
				</table>
			</form>
				
		</div>
	</div>
	<br>
	<?php include("footer_sys.html") ?>