<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "TeacherName": "����ʦ", "TeacherPic": null } ]

//�����ѧ����Ӧ����ʦ��Ϣ�ҳ�������������ݿ�����ȡ��
//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//$link = mysqli_connect("localhost","Kevinzhang","Kevinzhang");
if($link){
    //$Studentid = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ��
    $Studentid = 1;
    
    $sql = "select Teachername,Teacher_wxPic from Teacher where idTeacher=(SELECT Student_belongto_teacherid FROM Student where idStudent=".$Studentid.")";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    class ClassTeacher{
        public $TeacherName;
        public $TeacherPic;
        
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        //$id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $ClassTeacher=new ClassTeacher();
            
            $ClassTeacher->TeacherName=$row["Teachername"];
            $ClassTeacher->TeacherPic=$row["Teacher_wxPic"];
            $data[] = $ClassTeacher;
            
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
