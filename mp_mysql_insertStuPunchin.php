<?php
//�û������κμ�¼��С����˸��Ҵ�����idStu and idMedia and idPunchin��
//���ڷ������˼�¼��
//ִ��sql��INSERT INTO Student_log_Punchin SET Student_log_PunchinidStu_FK=1,Student_log_Punchindate='2018-09-24 16:47:58',Student_log_PunchinShortVideoid_FK=1,Student_log_Punchinid_FK=1

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ��
    //$Mediaid = $_GET['idMedia'];//��ȡ��С���򴫵ݹ�����idֵ��
    //$Punchinid = $_GET['idPunchin'];//��ȡ��С���򴫵ݹ�����idֵ��
    $Studentid = 1;
    $Mediaid = 1;
    $Punchinid = 1;
    
    //���¼������ֵ��һ�����ȥ��
    $sql_insert = "INSERT INTO Student_log_Punchin SET Student_log_PunchinidStu_FK=" .$Studentid."" . ",Student_log_Punchindate='".date('Y-m-d H:i:s',time())."'" . ",Student_log_PunchinShortVideoid_FK=".$Mediaid."".",Student_log_Punchinid_FK=".$Punchinid."";
    //echo($sql_insert);
    mysqli_query($link, "set names 'utf8'");
    $result_insert = mysqli_query($link, $sql_insert);
    
    //$data[] = $media_top3service;
    echo( $sql_insert);
    
    
    //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
    //echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
    //echo json_encode($data);
    //echo sizeof($data);
    
    
}
else{
    echo "db connect failed!";
}


?>