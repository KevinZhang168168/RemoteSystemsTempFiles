<?php
//����ҾͲ���¼�ˣ�С�����̨�����ݷ������Ѿ���ȫ�ˣ�������߼�Ҳû��д����ʱ���ϡ�
//�û���¼�͵ǳ���ʱ�䣬С����˸��Ҵ�����idStu and logintime and logouttime��
//���ڷ������˼�¼��
//ִ��sql��

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ��
    //$logintime = $_GET['logintime'];//��ȡ��С���򴫵ݹ�����idֵ��
    //$logouttime = $_GET['logouttime'];//��ȡ��С���򴫵ݹ�����idֵ��
    $Studentid = 1;
    
    
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