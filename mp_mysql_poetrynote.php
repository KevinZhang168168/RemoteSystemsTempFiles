<?php

//Kevin Zhang �����������Գɹ���δ����С����
//��ʫ���м䲿�ֶ���ȡ����������֪ʶ��ը���֣�
//PHP+MySQL���Խ����[ { "PoetryAuthorNote": "����һ���ƣ����������ס�", "PoetryZonglan": "����һ���ƣ����������ס�", "PoetryFJSY": "����һ���ƣ����������ס�", "PoetrySFDB": "����һ���ƣ����������ס�", "PoetrySFDB1": "����һ���ƣ����������ס�" } ] 

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
    $sql = "SELECT PoetryAuthorNote,PoetryZonglan,PoetryFJSY,PoetrySFDB,PoetrySFDB1 FROM Poetry where idPoetry=".$idPoetry."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetrynote{
        public $PoetryAuthorNote;
        public $PoetryZonglan;
        public $PoetryFJSY;
        public $PoetrySFDB;
        public $PoetrySFDB1;
        
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetrynote=new poetrynote();
            $poetrynote->PoetryAuthorNote=$row["PoetryAuthorNote"];
            $poetrynote->PoetryZonglan=$row["PoetryZonglan"];
            $poetrynote->PoetryFJSY=$row["PoetryFJSY"];
            $poetrynote->PoetrySFDB=$row["PoetrySFDB"];
            $poetrynote->PoetrySFDB1=$row["PoetrySFDB1"];
            
            $data[] = $poetrynote;
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