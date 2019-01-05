<?php
	function readdepartment() {
		include("mysql.php");
		$sql = "select d_id,department from hardware_department ";
		$result=$mysqli->query($sql);	
			if ($result->num_rows>0){		
				while ($rows = $result->fetch_assoc()){
					if($rows['d_id']==$_SESSION['hw_department']){
						echo "<option value='{$rows['d_id']}' selected='selected'>".$rows['department']."</option>";
					} else {
						echo "<option value='{$rows['d_id']}'>".$rows['department']."</option>";
					}
				}
			} else {
				echo "<option value=''>无</option>";
			}
	}

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

	function readtype() {
		include("mysql.php");
		$sql = "select t_id,type from hardware_type order by o_id ";
		$result=$mysqli->query($sql);	
			if ($result->num_rows>0){
				
				while ($rows = $result->fetch_assoc()){
					if($rows['t_id']==$_SESSION['hw_type']){
						echo "<option value='{$rows['t_id']}' selected='selected'>".$rows['type']."</option>";
					} else {
						echo "<option value='{$rows['t_id']}'>".$rows['type']."</option>";
					}
				}
			} else {
				echo "<option value=''>无</option>";
			}
	}


	function hw_p_list_default($start_time,$end_time,$department,$object,$type,$hw_area,$hw_user){
		include("mysql.php");
		$o_start_time = $start_time != '' ? $o_start_time = " p_date >= '{$start_time}' " : '1=1';
		$o_end_time = $end_time != '' ? $o_end_time = " p_date <= '{$end_time}' " : '1=1';
		$o_department = $department != 0 ? $o_department = " d_id='{$department}' " : '1=1';
		$o_object = $object != 0 ? $o_object = " o_id = '{$object}' " : '1=1';
		$o_type = $type != 0 ? $o_type = " t_id = '{$type}' " : '1=1';
		$o_hw_area = $hw_area != 0 ? $o_hw_area = " a_id = '{$hw_area}' " : '1=1';
		$o_hw_user = $hw_user != 0 ? $o_hw_user = " u_id = '{$hw_user}' " : '1=1';

		$sql = "select ho.object object,ifnull (cnt,0) num  from hardware_object ho left join (select o_id,count(*) cnt,p_date from hardware_problem  where {$o_start_time} and {$o_end_time} and {$o_department}  and {$o_object} and {$o_type} and {$o_hw_area}  and  {$o_hw_user} group by o_id) hp on hp.o_id=ho.o_id";
		
		$result=$mysqli->query($sql);
		if ($result->num_rows >0) {
			echo "<div style='height:18px'></div>";
			echo "<table id='report' class='stylized full' width='85%'>";
			echo "<tr><th><b>维护对象</b></th><th><b>电脑</b></th><th><b>电话</b></th><th><b>打印机</b></th><th><b>服务器</b></th><th><b>机器人</b></th><th><b>网络</b></th><th><b>监控</b></th><th><b>布线施工</b></th><th><b>其他</b></th><th><b>订餐系统</b></th><th><b>总数量</b></th></tr>";
			echo "<tr><td  id='td-bj'><b>问题数量</b></td>";
			while ($row = $result->fetch_assoc()){
				echo "<td  style='text-align:center'>".$row['num'].'</td>';
			}
			$sql="select sum(cnt) p_nums from hardware_object ho left join (select o_id,count(*) cnt,p_date from hardware_problem where {$o_start_time} and {$o_end_time} and {$o_department}  and {$o_object} and {$o_type} and {$o_hw_area}  and  {$o_hw_user}  group by o_id) hp on hp.o_id=ho.o_id";
			$result2=$mysqli->query($sql);
			$p_nums=$result2->fetch_assoc();
			echo "<td><font color='blue' ><b>".$p_nums['p_nums'] =$p_nums['p_nums'] =='' ? 0 : $p_nums['p_nums']."</b></font></td>";
			echo "</tr>";
			echo "</table>";
			echo "<br>";


		} else {
			echo "<br><br><br>无统计信息<br><br>";
		}
		

		$o_start_time = $start_time != '' ? $o_start_time = " hp.p_date >= '{$start_time}' " : '1=1';
		$o_end_time = $end_time != '' ? $o_end_time = " hp.p_date <= '{$end_time}' " : '1=1';
		$o_department = $department != 0 ? $o_department = " hp.d_id='{$department}' " : '1=1';
		$o_object = $object != 0 ? $o_object = " hp.o_id = '{$object}' " : '1=1';
		$o_type = $type != 0 ? $o_type = " hp.t_id = '{$type}' " : '1=1';
		$o_hw_area = $hw_area != 0 ? $o_hw_area = " hp.a_id = '{$hw_area}' " : '1=1';
		$o_hw_user = $hw_user != 0 ? $o_hw_user = " hp.u_id = '{$hw_user}' " : '1=1';

		$sql = "select hp.p_id from hardware_problem hp where {$o_start_time} and {$o_end_time} and {$o_department} and {$o_object} and {$o_type} and {$o_hw_area} and {$o_hw_user}";
		$result = $mysqli->query($sql);
		$total = $result->num_rows;
		$num = 10;
		$page=new Page($total, $num, "");


		$sql2="select hp.p_id,hp.p_date,hd.department,hp.submit_user,ho.object,ht.type,hp.problem,hp.method,u.name,a.area from hardware_problem hp left join  hardware_department hd on hd.d_id=hp.d_id  left join hardware_object ho  on hp.o_id=ho.o_id left join  hardware_type ht on hp.t_id=ht.t_id left join user u on hp.u_id=u.id left join area a on hp.a_id=a.a_id where {$o_start_time} and {$o_end_time} and {$o_department} and {$o_object} and {$o_type}  and {$o_hw_area} and {$o_hw_user} order by p_id desc {$page->limit}";
		//echo $sql2;
		$result2 = $mysqli->query($sql2);
		if ($result2->num_rows > 0){
			echo "<table border='1'  cellspacing='0' cellpadding='0' width='85%'>";
			echo "<tr><th width='5%'><b>编号</b></th><th width='10%'><b>日期</b></th><th width='11%'><b>部门</b></th><th width='6%'><b>提报人</b></th><th width='7%'><b>维护对象</b></th><th width='12%'><b>维护类型</b></th><th><b>问题</b></th><th width='18%'><b>处理方法</b></th><th width='6%'><b>处理人</b></th><th width='6%'><b>地区</b></th></tr>";					
			while ($row2 = $result2->fetch_assoc()){
				echo "<tr>";
				echo "<td style='text-align:center'>".$row2['p_id'].'</td>';
				echo '<td>'.$row2['p_date'].'</td>';
				echo '<td>'.$row2['department'].'</td>';
				echo '<td>'.$row2['submit_user'].'</td>';
				echo '<td>'.$row2['object'].'</td>';
				echo '<td>'.$row2['type'].'</td>';
				echo '<td id="p_stytle">'.$row2['problem'].'</td>';
				echo '<td id="p_stytle">'.$row2['method'].'</td>';
				echo '<td>'.$row2['name'].'</td>';
				echo '<td>'.$row2['area'].'</td>';
				//echo '<td>'.$row2['status']=$row2['status']==1 ? '完成' : '未完成'.'</td>';
				echo "</tr>";
			}
			echo '<tr><td colspan="10" style="text-align:center">'.$page->fpage(array(3,4,5,6,7,0,1,2,8)).'</td></tr>';
			echo "</table>";
		} else {
			echo"<center><font size=4 color=blue>查询完成，没有找到相关信息！</font></center>";
		}



	}




	function hw_p_list($start_time,$end_time,$department,$object,$type,$hw_area,$hw_user){
		include("mysql.php");
		$o_start_time = $start_time != '' ? $o_start_time = " p_date >= '{$start_time}' " : '1=1';
		$o_end_time = $end_time != '' ? $o_end_time = " p_date <= '{$end_time}' " : '1=1';
		$o_department = $department != 0 ? $o_department = " d_id='{$department}' " : '1=1';
		$o_object = $object != 0 ? $o_object = " o_id = '{$object}' " : '1=1';
		$o_type = $type != 0 ? $o_type = " t_id = '{$type}' " : '1=1';
		$o_hw_area = $hw_area != 0 ? $o_hw_area = " a_id = '{$hw_area}' " : '1=1';
		$o_hw_user = $hw_user != 0 ? $o_hw_user = " u_id = '{$hw_user}' " : '1=1';

		$sql = "select ho.object object,ifnull (cnt,0) num  from hardware_object ho left join (select o_id,count(*) cnt,p_date from hardware_problem  where {$o_start_time} and {$o_end_time} and {$o_department}  and {$o_object} and {$o_type} and {$o_hw_area}  and  {$o_hw_user} group by o_id) hp on hp.o_id=ho.o_id";
		
		$result=$mysqli->query($sql);
		if ($result->num_rows >0) {
			echo "<div style='height:18px'></div>";
			echo "<table id='report' class='stylized full' width='85%'>";
			echo "<tr><th><b>维护对象</b></th><th><b>电脑</b></th><th><b>电话</b></th><th><b>打印机</b></th><th><b>服务器</b></th><th><b>机器人</b></th><th><b>网络</b></th><th><b>监控</b></th><th><b>布线施工</b></th><th><b>其他</b></th><th><b>订餐系统</b></th><th><b>总数量</b></th></tr>";
			echo "<tr><td  id='td-bj'><b>问题数量</b></td>";
			while ($row = $result->fetch_assoc()){
				echo "<td  style='text-align:center'>".$row['num'].'</td>';
			}
			$sql="select sum(cnt) p_nums from hardware_object ho left join (select o_id,count(*) cnt,p_date from hardware_problem where {$o_start_time} and {$o_end_time} and {$o_department}  and {$o_object} and {$o_type} and {$o_hw_area}  and  {$o_hw_user}  group by o_id) hp on hp.o_id=ho.o_id";
			$result2=$mysqli->query($sql);
			$p_nums=$result2->fetch_assoc();
			echo "<td><font color='blue' ><b>".$p_nums['p_nums'] =$p_nums['p_nums'] =='' ? 0 : $p_nums['p_nums']."</b></font></td>";
			echo "</tr>";
			echo "</table>";
			echo "<br>";


		} else {
			echo "<br><br><br>无统计信息<br><br>";
		}
		

		$o_start_time = $start_time != '' ? $o_start_time = " hp.p_date >= '{$start_time}' " : '1=1';
		$o_end_time = $end_time != '' ? $o_end_time = " hp.p_date <= '{$end_time}' " : '1=1';
		$o_department = $department != 0 ? $o_department = " hp.d_id='{$department}' " : '1=1';
		$o_object = $object != 0 ? $o_object = " hp.o_id = '{$object}' " : '1=1';
		$o_type = $type != 0 ? $o_type = " hp.t_id = '{$type}' " : '1=1';
		$o_hw_area = $hw_area != 0 ? $o_hw_area = " hp.a_id = '{$hw_area}' " : '1=1';
		$o_hw_user = $hw_user != 0 ? $o_hw_user = " hp.u_id = '{$hw_user}' " : '1=1';

		//$tj1 = " 1=1 ";
		//if(!empty($_POST["key"])){
		//	$tj1 = " {$o_start_time} and {$o_end_time} and {$o_department} and {$o_object} and {$o_type} and {$o_hw_area} and {$o_hw_user}";
		//}


		//$sql = "select hp.p_id from hardware_problem hp where {$o_start_time} and {$o_end_time} and {$o_department} and {$o_object} and {$o_type} and {$o_hw_area} and {$o_hw_user}";
		//$result = $mysqli->query($sql);
		//$total = $result->num_rows;
		//$num = 10;
		//$page=new Page($total, $num, "");

		$sql2="select hp.p_id,hp.p_date,hd.department,hp.submit_user,ho.object,ht.type,hp.problem,hp.method,u.name,a.area from hardware_problem hp left join  hardware_department hd on hd.d_id=hp.d_id  left join hardware_object ho  on hp.o_id=ho.o_id left join  hardware_type ht on hp.t_id=ht.t_id left join user u on hp.u_id=u.id left join area a on hp.a_id=a.a_id where {$o_start_time} and {$o_end_time} and {$o_department} and {$o_object} and {$o_type}  and {$o_hw_area} and {$o_hw_user} order by p_id desc {$page->limit}";
		//echo $sql2;
		$result2 = $mysqli->query($sql2);
		if ($result2->num_rows > 0){
			echo "<table border='1'  cellspacing='0' cellpadding='0' width='85%'>";
			echo "<tr><th width='5%'><b>编号</b></th><th width='10%'><b>日期</b></th><th width='11%'><b>部门</b></th><th width='6%'><b>提报人</b></th><th width='7%'><b>维护对象</b></th><th width='12%'><b>维护类型</b></th><th><b>问题</b></th><th width='18%'><b>处理方法</b></th><th width='6%'><b>处理人</b></th><th width='6%'><b>地区</b></th></tr>";					
			while ($row2 = $result2->fetch_assoc()){
				echo "<tr>";
				echo "<td style='text-align:center'>".$row2['p_id'].'</td>';
				echo '<td>'.$row2['p_date'].'</td>';
				echo '<td>'.$row2['department'].'</td>';
				echo '<td>'.$row2['submit_user'].'</td>';
				echo '<td>'.$row2['object'].'</td>';
				echo '<td>'.$row2['type'].'</td>';
				echo '<td id="p_stytle">'.$row2['problem'].'</td>';
				echo '<td id="p_stytle">'.$row2['method'].'</td>';
				echo '<td>'.$row2['name'].'</td>';
				echo '<td>'.$row2['area'].'</td>';
				//echo '<td>'.$row2['status']=$row2['status']==1 ? '完成' : '未完成'.'</td>';
				echo "</tr>";
			}
			//echo '<tr><td colspan="10" style="text-align:center">'.$page->fpage(array(3,4,5,6,7,0,1,2,8)).'</td></tr>';
			echo "</table>";
		} else {
			echo"<center><font size=4 color=blue>查询完成，没有找到相关信息！</font></center>";
		}



	}
