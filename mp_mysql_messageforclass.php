<?php
//Kevin Zhang �����������Գɹ���δ����С��������ֻ����ʾ����Ϣ��û���û���ȡ��Ϣ��洢���ݿ�Ĺ��ܣ��������php��ʵ�֡�
//PHP+MySQL���Խ����[ { "idmessage_for_stu": 1, "messageid_for_stu": "1", "message_name": "������ҵ֪ͨ", "massage_detail": "������ҵ֪ͨ" }, { "idmessage_for_stu": 2, "messageid_for_stu": "2", "message_name": "����Ԥϰ֪ͨ", "massage_detail": "������ҵ֪ͨ" }, { "idmessage_for_stu": 3, "messageid_for_stu": "3", "message_name": "�κ󻥶�֪ͨ", "massage_detail": "������ҵ֪ͨ" } ]

//��ҳ�ϳ���3�����ѧ�������༶����Ϣ֪ͨ����������ݿ�����ȡ��ʱ�������3���������ڲ鿴��������ʾ
//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //echo "db connect success!";
    //$Studentid = $_GET['Studentid'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //Studentid��ʱ����1���棬ʵ��΢��С������$Studentid
    $Studentid=1;
    $sql1 = "SELECT Student_belongto_classid_FK FROM mp_wx_zxj_demo_mysql.Student where idStudent=".$Studentid."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result1 = mysqli_query($link, $sql1);
    
    class student_classid{
        public $idclass;
    }
    
    $data1 = array();
    if (mysqli_num_rows($result1) > 0) {
        while($row = mysqli_fetch_assoc($result1)) {
            
            $student_classid=new student_classid();
            $student_classid->idclass=$row["Student_belongto_classid_FK"];
            $data1[] = $student_classid;
        }
    }
    
    class sys_mes_class{
        public $idmessage_for_stu;
        public $messageid_for_stu;
        public $message_name;
        public $massage_detail;
    }
    
    $sql = "select idmessage_for_class,message_for_classname,message_for_classdetail from mp_wx_zxj_demo_mysql.message_for_class where message_for_classid_FK = " .$data1[0]->idclass."";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $idmessage_for_stu = 1;
        for ($x=0; $x<=2; $x++) {
            while($row = mysqli_fetch_assoc($result)) {
                $sys_mes_class=new sys_mes_class();
                $sys_mes_class->idmessage_for_stu=$idmessage_for_stu++;//����+1������û��ʵ�����壬ֻ��΢��С������ʾ������˳��
                $sys_mes_class->messageid_for_stu=$row["idmessage_for_class"];//�õ����message��idֵ,��Ϣ������Ҫ��ɫ��ϵͳҪ�м�¼
                $sys_mes_class->message_name=$row["message_for_classname"];
                $sys_mes_class->massage_detail=$row["message_for_classdetail"];
                $data[] = $sys_mes_class;
            }
            
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
        
    }
    
}
else{
    echo "db connect failed!";
}

?>
