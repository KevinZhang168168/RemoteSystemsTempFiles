<?php
//�û������κ�ʫ���ҳ�棬С����˸��Ҵ�����idStu and idPoetry��
//���ڷ������˼�¼��
//ִ��sql��INSERT INTO mp_wx_zxj_demo_mysql.Student_log_PL SET Student_log_PLStudentid_FK=1,Student_log_PLtime='2018-09-16 20:52:54',Student_log_PLPoetryid_FK=1;

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ��
    //$Poetryid = $_GET['idPoetry'];//��ȡ��С���򴫵ݹ�����idֵ��
    $Studentid = 1;
    $Poetryid = 1;
        
    //���¼������ֵ��һ�����ȥ��
    $sql_insert = "INSERT INTO Student_log_PL SET Student_log_PLStudentid_FK=" .$Studentid."" . ",Student_log_PLtime='".date('Y-m-d H:i:s',time())."'" . ",Student_log_PLPoetryid_FK=".$Poetryid."";
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