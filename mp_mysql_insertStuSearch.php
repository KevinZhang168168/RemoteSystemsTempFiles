<?php
//�û��������κιؼ��ʣ�С����˸��Ҵ�����idStu and KeyWord��
//���ڷ������˼�¼��
//ִ��sql��INSERT INTO search_log SET search_logStudentid_FK=1,search_logtime='2018-09-17 11:55:41',search_logkeyword='���'

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ��
    //$KeyWord = $_GET['KeyWord'];//��ȡ��С���򴫵ݹ�����idֵ��
    $Studentid = 1;
    $KeyWord = mb_convert_encoding('���','UTF-8','GBK');
    
    //���¼������ֵ��һ�����ȥ��
    $sql_insert = "INSERT INTO search_log SET search_logStudentid_FK=" .$Studentid."" . ",search_logtime='".date('Y-m-d H:i:s',time())."'" . ",search_logkeyword='".$KeyWord."'";
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