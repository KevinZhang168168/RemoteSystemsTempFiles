<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "Wordorder": "/image/media/lou.png,/image/media/lou.png,/image/media/lou.png,/image/media/lou.png,/image/media/lou.png,/image/media/lou.png,/image/media/lou.png" } ] 
//�����˳������ȡ��

//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//��ȡһ��ʫ�����Ƶ����
if($link){
    //$idword = $_GET['idword'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //idword=1��ʱ����1���棬ʵ��΢��С������idword
    $idword=1;
    $sql = "SELECT Word_order_of_strokescontent FROM Word_order_of_strokes where idWord_order_of_strokes=".$idword."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class wordcontent{
        public $Wordorder;
        
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $wordcontent=new wordcontent();
            $wordcontent->Wordorder=$row["Word_order_of_strokescontent"];
           
            
            
            $data[] = $wordcontent;
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