<?php

//Kevin Zhang �����������Գɹ���δ����С����
//��ʫ�����չ�Ķ��ʶ���ȡ������
//PHP+MySQL���Խ����[ { "Poetryexid": "1", "PoetryexAuURI1": "/image/voice/lou.png", "PoetryexAuURI2": "/image/voice/lou.png", "PoetryexAuURI3": "/image/voice/lou.png" }, { "Poetryexid": "2", "PoetryexAuURI1": "/image/voice/lou.png", "PoetryexAuURI2": "/image/voice/lou.png", "PoetryexAuURI3": "/image/voice/lou.png" }, { "Poetryexid": "3", "PoetryexAuURI1": "/image/voice/lou.png", "PoetryexAuURI2": "/image/voice/lou.png", "PoetryexAuURI3": "/image/voice/lou.png" }, { "Poetryexid": "4", "PoetryexAuURI1": "/image/voice/lou.png", "PoetryexAuURI2": "/image/voice/lou.png", "PoetryexAuURI3": "/image/voice/lou.png" } ] 

//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//��ȡһ��ʫ�����Ƶ����
if($link){
    //$Poetryexid = $_GET['Poetryexid'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //idPoetry=1��ʱ����1���棬ʵ��΢��С������idPoetry
    $Poetryexid=1;
    $sql = "SELECT idPoetry_extended_reading,Poetry_extended_readingAudioURI1,Poetry_extended_readingAudioURI2,Poetry_extended_readingAudioURI3 FROM Poetry_extended_reading where Poetry_extended_readingPoetryid_FK=".$Poetryexid."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetryexreading{
        public $Poetryexid;
        public $PoetryexAuURI1;
        public $PoetryexAuURI2;
        public $PoetryexAuURI3;
       
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetryexreading=new poetryexreading();
            $poetryexreading->Poetryexid=$row["idPoetry_extended_reading"];
            $poetryexreading->PoetryexAuURI1=$row["Poetry_extended_readingAudioURI1"];
            $poetryexreading->PoetryexAuURI2=$row["Poetry_extended_readingAudioURI2"];
            $poetryexreading->PoetryexAuURI3=$row["Poetry_extended_readingAudioURI3"];
          
            
            $data[] = $poetryexreading;
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