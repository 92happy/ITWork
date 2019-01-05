<script language="javascript" >  
	var http_request=false;  
  function send_request(url){//初始化，指定处理函数，发送请求的函数  
    http_request=false;  
 //开始初始化XMLHttpRequest对象  
 if(window.XMLHttpRequest){//Mozilla浏览器  
  http_request=new XMLHttpRequest();  
  if(http_request.overrideMimeType){//设置MIME类别  
    http_request.overrideMimeType("text/xml");  
  }  
 }  
 else if(window.ActiveXObject){//IE浏览器  
  try{  
   http_request=new ActiveXObject("Msxml2.XMLHttp");  
  }catch(e){  
   try{  
   http_request=new ActiveXobject("Microsoft.XMLHttp");  
   }catch(e){}  
  }  
    }  
 if(!http_request){//异常，创建对象实例失败  
  window.alert("创建XMLHttp对象失败！");  
  return false;  
 }  
 http_request.onreadystatechange=processrequest;  
 //确定发送请求方式，URL，及是否同步执行下段代码  
    http_request.open("GET",url,true);  
 http_request.send(null);  
  }  
  //处理返回信息的函数  
  function processrequest(){  
   if(http_request.readyState==4){//判断对象状态  
     if(http_request.status==200){//信息已成功返回，开始处理信息  
   document.getElementById(reobj).innerHTML=http_request.responseText;  
  }  
  else{//页面不正常  
   alert("您所请求的页面不正常！");  
  }  
   }  
  }  
  function getclass(obj){  
   var pid=document.form1.select1.value;  
   document.getElementById(obj).innerHTML="<option>loading...</option>";  
   send_request('doclass.php?pid='+pid);  
   reobj=obj;  
  }  
   
</script>  

<form name="form1">
<select name="select1" id="class1" style="width:200;" onChange="getclass('class2');">  
<option selected value="">选择大类</option>  
          <?php readobject()?>

</select>  
<select name="select2" id="class2" style="width:200;"  onChange="getclass('class3');">  
</select> 
</form>

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
