<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "coursename": "����" }, { "id": 2, "coursename": "��ѧ" }, { "id": 3, "coursename": "Ӣ��" }, { "id": 4, "coursename": "˼��Ʒ��" }, { "id": 5, "coursename": "����" }, { "id": 6, "coursename": "����" }, { "id": 7, "coursename": "����" }, { "id": 8, "coursename": "��ҽ" }, { "id": 9, "coursename": "��ģ" }, { "id": 10, "coursename": "������" } ]

//�����ݿ��������Ѿ�����õĿγ�չʾ�������������ںͿ���ģ���������ȡ��9����¼����������ݿ�����ȡ��
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
    //$Studentid = 1;
    
    $sql = "SELECT CourseName FROM Course_in";//
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    
    
    class StuCourse{
        public $id;
        public $coursename;
       
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $StuCourse=new StuCourse();
            
            $StuCourse->id=$id++;
            $StuCourse->coursename=$row["CourseName"];
            $data[] = $StuCourse;
           
        }
        
        $sql1 = "SELECT Course_outName FROM Course_out";//
        mysqli_query($link, "set names 'utf8'");
        $result1 = mysqli_query($link, $sql1);
        while($row1 = mysqli_fetch_assoc($result1)) {
            $StuCourse=new StuCourse();
            
            $StuCourse->id=$id++;
            $StuCourse->coursename=$row1["Course_outName"];
            $data[] = $StuCourse;
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
