<?php

//Kevin Zhang �����������Գɹ���δ����С����
//��Ϊ�ֵ�ҳ���Ǵӹ�ʫҳ���ȥ�ģ������Ұ������ʫ������Ҫ��д���ַŵ�һ���ˣ�
//PHP+MySQL���Խ����[ { "poetrymustwrite": "��,��" } ] ���û�д�ƴ������ΪͻȻ�����������ֵ��ʵ��ʫҳ�����Ѿ����ˣ������ٴ������������

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
    $sql = "SELECT Poetrymustwrite FROM Poetry where idPoetry=1";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetrycontent{
        public $poetrymustwrite;
        
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetrycontent=new poetrycontent();
            $poetrycontent->poetrymustwrite=$row["Poetrymustwrite"];
           
      
            $data[] = $poetrycontent;
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
