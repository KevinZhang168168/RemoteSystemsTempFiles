<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idhotestsearch": 1, "searchword": "����ȸ¥" }, { "idhotestsearch": 2, "searchword": "��" }, { "idhotestsearch": 3, "searchword": "¥" }, { "idhotestsearch": 4, "searchword": "��" }, { "idhotestsearch": 5, "searchword": "���1" }, { "idhotestsearch": 6, "searchword": "��" }, { "idhotestsearch": 7, "searchword": "���2" }, { "idhotestsearch": 8, "searchword": "���3" }, { "idhotestsearch": 9, "searchword": "���4" } ]

//��ҳ�ϳ���9����������Ĳ�ѯ�ؼ��ʣ���������ݿ�����ȡ
//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//$link = mysqli_connect("localhost","Kevinzhang","Kevinzhang");
if($link){
    //echo "db connect success!";
    
    $sql = "SELECT search_logkeyword, count(*) FROM mp_wx_zxj_demo_mysql.search_log group by search_logkeyword order by count(*) desc limit 0,9";//��д
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class search9keyword{
        public $idhotestsearch;
        public $searchword;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        
        $idhotestsearch = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $search9keyword=new search9keyword();
            $search9keyword->idhotestsearch=$idhotestsearch++;//����
            $search9keyword->searchword=$row["search_logkeyword"];//����
            $data[] = $search9keyword;
            //echo($coursein);
        }
        
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?>
