<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "firstclass": "��ѧ�����ģ������ѧ������", "secondclass": "��ѧ�����ģ������ѧ������", "thirdclass": "��ѧ�����ģ������ѧ������", "fourthclass": "��ѧ�����ģ������ѧ������", "addamclass": "��ѧ�����ģ������ѧ������", "fifthclass": "��ѧ�����ģ������ѧ������", "sixthclass": "��ѧ�����ģ������ѧ������", "addpm1class": "��ѧ�����ģ������ѧ������", "addpm2class": "��ѧ�����ģ������ѧ������" } ]

//��ѧ���Ŀα�����ݿ�����ȡ������ȱʡû�У�����У���������ȡ��9����¼����������ݿ�����ȡ��
//��һ����¼�ǵ�һ�ڿε�˳���Ǵ���һ�����壻�Դ����ƣ�
//��������Զ������ڿΣ�Ҳ��ȡ�������յľͿյģ�С����ҳ���Լ��жϣ�
//Ҳ����˵��������������ڿΣ�
//���������ڿΣ��û������Զ������ڿΣ�Ҳ��������������ĽڿΣ�
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
    
    $sql = "SELECT Student_log_CSchedulefirstclass,Student_log_CSchedulesecondclass,Student_log_CSchedulethirdclass,Student_log_CSchedulefourthclass,Student_log_CScheduleaddam,Student_log_CSchedulefifthclass,Student_log_CSchedulesixthclass,Student_log_CScheduleaddpm1,Student_log_CScheduleaddpm2 FROM Student_log_CSchedule where Student_log_CSchedulestuid_FK=".$Studentid."";//
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class StuCSchedule{
        public $id;
        public $firstclass;
        public $secondclass;
        public $thirdclass;
        public $fourthclass;
        public $addamclass;//����ļӿ�
        public $fifthclass;
        public $sixthclass;
        public $addpm1class;//����ĵ�һ�ڼӿ�
        public $addpm2class;//����ĵڶ��ڼӿ�
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $StuCSchedule=new StuCSchedule();
            
            $StuCSchedule->id=$id++;
            $StuCSchedule->firstclass=$row["Student_log_CSchedulefirstclass"];
            $StuCSchedule->secondclass=$row["Student_log_CSchedulesecondclass"];
            $StuCSchedule->thirdclass=$row["Student_log_CSchedulethirdclass"];
            $StuCSchedule->fourthclass=$row["Student_log_CSchedulefourthclass"];
            $StuCSchedule->addamclass=$row["Student_log_CScheduleaddam"];
            $StuCSchedule->fifthclass=$row["Student_log_CSchedulefifthclass"];
            $StuCSchedule->sixthclass=$row["Student_log_CSchedulesixthclass"];
            $StuCSchedule->addpm1class=$row["Student_log_CScheduleaddpm1"];
            $StuCSchedule->addpm2class=$row["Student_log_CScheduleaddpm2"];
            $data[] = $StuCSchedule;
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
