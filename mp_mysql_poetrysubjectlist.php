<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idPoetry": "5", "PoetryName": "��չ�Ķ�1" }, { "idPoetry": "6", "PoetryName": "��չ�Ķ�2" }, { "idPoetry": "7", "PoetryName": "��չ�Ķ�3" }, { "idPoetry": "8", "PoetryName": "��չ�Ķ�4" }, { "idPoetry": "1", "PoetryName": "���¶���" }, { "idPoetry": "3", "PoetryName": "���" }, { "idPoetry": "2", "PoetryName": "����ȸ¥" }, { "idPoetry": "4", "PoetryName": "��ҹ˼" } ]

//ɸѡ���������ʫ�裬�������ڰ�����ѧ��¼�Ƶ���Ƶ�����ൽ����һ��ʫ�����ˡ�
//��������ݿ������е�ʫ�趼�г�������Ϊ�����б�

$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['Studentid'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //idStudent=1��ʱ����1���棬ʵ��΢��С������$Studentid
    $sql = "select idPoetry,PoetryName from Poetry";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    class PoetryList{
        public $idPoetry;
        public $PoetryName;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $PoetryList=new PoetryList();
            
            $PoetryList->idPoetry=$row["idPoetry"];
            $PoetryList->PoetryName=$row["PoetryName"];
          
            $data[] = $PoetryList;
        }
        
        //��Ӧ����һ��ѧϰ���ȵ�Json���ݷ��أ��������ĵ���д�ϣ������php�л�û��ʵ�֡�
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?>
