<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idCourse_in": "1", "CourseName": "����" }, { "idCourse_in": "2", "CourseName": "��ѧ" }, { "idCourse_in": "3", "CourseName": "Ӣ��" }, { "idCourse_in": "4", "CourseName": "˼��Ʒ��" }, { "idCourse_in": "5", "CourseName": "����" }, { "idCourse_in": "6", "CourseName": "����" } ] 

//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
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

		//echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
		echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
		//echo json_encode($data);
		//echo sizeof($data);
	}

}
else{
echo "db connect failed!";
}

?> 