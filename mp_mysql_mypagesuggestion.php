<?php
//�û������κ������
//���ڷ������˼�¼��
//ִ��sql��INSERT INTO Student_log_suggestion SET Student_log_suggestionStuid_FK=1,Student_log_suggestionname='kdjaf���ֺ���',Student_log_suggestionnote='ddkskfkjdjfsdaklfjdskflds���ֺ���',Student_log_suggestiontime='2018-09-24 17:51:02'

header("Content-Type:text/html;charset=utf-8");//���û�ã�ʹ������ķ�����mb_convert_encoding

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['idStu'];//��ȡ��С���򴫵ݹ�����idֵ��
    //$SugName = $_GET['SugName'];//��ȡ��С���򴫵ݹ�����idֵ��
    //$SugNote = $_GET['SugNote'];//��ȡ��С���򴫵ݹ�����idֵ��
    $Studentid = 1;
    $SugName = mb_convert_encoding('kdjaf���ֺ���','UTF-8','GBK');
    $SugNote = mb_convert_encoding('ddkskfkjdjfsdaklfjdskflds���ֺ���','UTF-8','GBK');
    
    //���¼������ֵ��һ�����ȥ��
    //INSERT INTO mp_wx_zxj_demo_mysql.Student_log_suggestion SET Student_log_suggestionStuid_FK=1,Student_log_suggestionname='kdjaf',Student_log_suggestionnote='',Student_log_suggestiontime='2018-09-24 17:40:03';
    $sql_insert = "INSERT INTO Student_log_suggestion SET Student_log_suggestionStuid_FK=" .$Studentid."" . ",Student_log_suggestionname='".$SugName."'" . ",Student_log_suggestionnote='".$SugNote."'" . ",Student_log_suggestiontime='".date('Y-m-d H:i:s',time())."'";
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