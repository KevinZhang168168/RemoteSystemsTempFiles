<?php

//Kevin Zhang �����������Գɹ���δ����С����
//��ʫ�����չ�Ķ�������һ��table���ҳ���������ֻҪ�г�id�����־Ϳ����ˡ�����չ�Ķ��������չʾȫ�����ݡ�
//PHP+MySQL���Խ����[ { "Poetryexid": "1", "Poetryexname": "��ӵ���չ�Ķ�1" }, { "Poetryexid": "2", "Poetryexname": "��ӵ���չ�Ķ�2" }, { "Poetryexid": "3", "Poetryexname": "��ӵ���չ�Ķ�3" }, { "Poetryexid": "4", "Poetryexname": "��ӵ���չ�Ķ�4" } ] 

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
    $sql = "SELECT idPoetry_extended_reading,Poetry_extended_readingname FROM Poetry_extended_reading where Poetry_extended_readingPoetryid_FK=".$idPoetry."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetryexreading{
        public $Poetryexid;
        public $Poetryexname;
       
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetryexreading=new poetryexreading();
            $poetryexreading->Poetryexid=$row["idPoetry_extended_reading"];
            $poetryexreading->Poetryexname=$row["Poetry_extended_readingname"];
           
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