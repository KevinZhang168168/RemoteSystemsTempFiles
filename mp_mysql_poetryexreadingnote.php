<?php

//Kevin Zhang �����������Գɹ���δ����С����
//��ʫ�����չ�Ķ�������һ��table���ҳ���������չ�Ķ��������չʾȫ�����ݡ������ʶ���
//PHP+MySQL���Խ����[ { "Poetryexid": "1", "Poetryexname": "��ӵ���չ�Ķ�1", "Poetryexdynasty": "�Ƴ�", "Poetryexauthor": "���", "Poetryexcontent": null, "Poetryexnote": "��ӵ���չ�Ķ�4��ӵ���չ�Ķ�4��ӵ���չ�Ķ�4��ӵ���չ�Ķ�4��ӵ���չ�Ķ�4" } ] 

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
    $sql = "SELECT idPoetry_extended_reading,Poetry_extended_readingname,Poetry_extended_readingdynasty,Poetry_extended_readingauthor,Poetry_extended_readingcentent,Poetry_extended_readingnote FROM Poetry_extended_reading where idPoetry_extended_reading=".$Poetryexid."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetryexreading{
        public $Poetryexid;
        public $Poetryexname;
        public $Poetryexdynasty;
        public $Poetryexauthor;
        public $Poetryexcontent;
        public $Poetryexnote;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetryexreading=new poetryexreading();
            $poetryexreading->Poetryexid=$row["idPoetry_extended_reading"];
            $poetryexreading->Poetryexname=$row["Poetry_extended_readingname"];
            $poetryexreading->Poetryexdynasty=$row["Poetry_extended_readingdynasty"];
            $poetryexreading->Poetryexauthor=$row["Poetry_extended_readingauthor"];
            $poetryexreading->Poetryexcontent=$row["Poetry_extended_readingcentent"];
            $poetryexreading->Poetryexnote=$row["Poetry_extended_readingnote"];
            
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