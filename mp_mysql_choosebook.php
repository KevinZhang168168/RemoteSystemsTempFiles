<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idPubHouse": "1", "idCoursein": "1", "semester": "10" }, { "idPubHouse": "1", "idCoursein": "1", "semester": "11" }, { "idPubHouse": "1", "idCoursein": "1", "semester": "20" }, { "idPubHouse": "1", "idCoursein": "1", "semester": "21" } ]

//�û������������Լ�ѡ��α���ȱʡΪСѧ���Ķ��꼶�²ᣬ��������ݿ�����ȡ�������ϣ���ʾΪ��
//��һ�У��汾�������ݿ�����ȡ
//�ڶ��У��꼶��һ�꼶�����꼶�����꼶�����꼶�����꼶�����꼶������ʾ������������ݿ���û�д����ݣ������һ�����
//�����У�ѧ�ڣ���ѧ�ڣ���ѧ�ڣ�����ʾ���������û�����ݣ������һ�����
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['Studentid'];//��ȡ��С���򴫵ݹ�����idֵ��
    //$idCourse_in_FK = $_GET['idCourse_in_FK']
    //$idCourse_in_grade_PubHouse_FK = $_GET['idCourse_in_grade_PubHouse_FK']
    $idCourse_in_FK=1;//�������ģ�
    $idCourse_in_grade_PubHouse_FK=1;//������̲�
    
    //idStudent=1��ʱ����1���棬ʵ��΢��С������$Studentid
    //����ֶδ����꼶��ѧ�ڣ���һ�����ִ����꼶���ڶ������ִ���ѧ�ڣ�0Ϊ��ѧ�ڣ�1Ϊ��ѧ�ڣ�
    //����21����Сѧ���꼶��ѧ�ڣ������ֵ����view�㣬�������Լ��ж��ĸ��ط�Ҫ���һ�����
    //Ŀǰֱ���ڳ�����д��ΪidCourse_in_FK=1�������ģ�
    //д��idCourse_in_grade_PubHouse_FK=1������̲�
    $sql = "select idCourse_in_grade_PubHouse_FK,idCourse_in_FK,Course_in_grade_semester from Course_in_grade where idCourse_in_FK=".$idCourse_in_FK." and idCourse_in_grade_PubHouse_FK=".$idCourse_in_grade_PubHouse_FK."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class ChooseBook{
        public $idPubHouse;
        public $idCoursein;
        public $semester;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $ChooseBook=new ChooseBook();
            $ChooseBook->idPubHouse=$row["idCourse_in_grade_PubHouse_FK"];
            $ChooseBook->idCoursein=$row["idCourse_in_FK"];
            $ChooseBook->semester=$row["Course_in_grade_semester"];
            $data[] = $ChooseBook;
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
