<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "idCourse_in": "1", "CourseName": "语文" }, { "idCourse_in": "2", "CourseName": "数学" }, { "idCourse_in": "3", "CourseName": "英语" }, { "idCourse_in": "4", "CourseName": "思想品德" }, { "idCourse_in": "5", "CourseName": "美术" }, { "idCourse_in": "6", "CourseName": "音乐" } ] 

//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//$link = mysqli_connect("localhost","Kevinzhang","Kevinzhang");
if($link){
    //echo "db connect success!";

    $sql = "SELECT *FROM course_in";

 	mysqli_query($link, "set names 'utf8'");

	$result = mysqli_query($link, $sql);

	class coursein{
		public $idCourse_in;
		public $CourseName;
	}

	$data = array();
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {

			$coursein=new coursein();
			$coursein->idCourse_in=$row["idCourse_in"];
			$coursein->CourseName=$row["CourseName"];
			$data[] = $coursein;
			//echo($coursein);
		}

		//echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
		echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
		//echo json_encode($data);
		//echo sizeof($data);
	}

}
else{
echo "db connect failed!";
}

?> 