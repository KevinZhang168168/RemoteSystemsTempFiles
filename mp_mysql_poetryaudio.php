<?php

//Kevin Zhang �����������Գɹ���δ����С����
//��ʫ��������ʶ���ȡ������
//PHP+MySQL���Խ����[ { "Poetryaudio1URI": "/image/media/lou.png", "Poetryaudio2URI": "/image/media/lou.png", "Poetryaudio3URI": "/image/media/lou.png" } ] 

//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//��ȡһ��ʫ�����Ƶ����
if($link){
    //idPoetry = $_GET['idPoetry'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //idPoetry=1��ʱ����1���棬ʵ��΢��С������idPoetry
    $idPoetry=1;
    $sql = "SELECT Poetryaudio1URI,Poetryaudio2URI,Poetryaudio3URI FROM Poetry where idPoetry=".$idPoetry."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetryaudio{
        public $Poetryaudio1URI;
        public $Poetryaudio2URI;
        public $Poetryaudio3URI;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetryaudio=new poetryaudio();
            $poetryaudio->Poetryaudio1URI=$row["Poetryaudio1URI"];
            $poetryaudio->Poetryaudio2URI=$row["Poetryaudio2URI"];
            $poetryaudio->Poetryaudio3URI=$row["Poetryaudio3URI"];
           
            $data[] = $poetryaudio;
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