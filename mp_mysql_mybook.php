<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idStudentBook": "4", "StudentBookNote": "Сѧ���꼶���²ᣬ���ģ������" } ]

//��ʫ����ҳ�·������û�Ŀǰ�Ŀα���ȱʡΪСѧ���Ķ��꼶�²ᣬ��������ݿ�����ȡ������û�����ѡ���������ʾ�û���ѡ��
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['Studentid'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //idStudent=1��ʱ����1���棬ʵ��΢��С������$Studentid
    $Studentid=1;
    $sql = "select idCourse_in_grade,Course_in_gradeNote from Course_in_grade where idCourse_in_grade=(select class_Course_in_gradeFK from class where idclass=(SELECT Student_belongto_classid_FK FROM mp_wx_zxj_demo_mysql.Student where idStudent=".$Studentid."))";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class StudentBook{
        public $idStudentBook;
        public $StudentBookNote;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $StudentBook=new StudentBook();
            $StudentBook->idStudentBook=$row["idCourse_in_grade"];
            $StudentBook->StudentBookNote=$row["Course_in_gradeNote"];
            $data[] = $StudentBook;
            //echo($coursein);
        }
        
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?>
