<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idmyhistorysearch": 1, "mysearchword": "����ȸ¥" }, { "idmyhistorysearch": 2, "mysearchword": "¥" }, { "idmyhistorysearch": 3, "mysearchword": "���1" }, { "idmyhistorysearch": 4, "mysearchword": "���2" }, { "idmyhistorysearch": 5, "mysearchword": "���3" }, { "idmyhistorysearch": 6, "mysearchword": "���4" }, { "idmyhistorysearch": 7, "mysearchword": "��" }, { "idmyhistorysearch": 8, "mysearchword": "���" }, { "idmyhistorysearch": 9, "mysearchword": "һ" } ]

//��ҳ�ϳ���9���û��Լ��Ĳ�ѯ�ؼ��ʣ���������ݿ�����ȡ��ʱ�������9��
//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //echo "db connect success!";
    //$Studentid = $_GET['Studentid'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //search_logStudentid_FK=1��ʱ����1���棬ʵ��΢��С������$Studentid
    $Studentid=1;
    $sql = "SELECT search_logkeyword FROM mp_wx_zxj_demo_mysql.search_log where search_logStudentid_FK=".$Studentid." group by search_logkeyword order by search_logtime desc limit 0,9";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class search9myhistory{
        public $idmyhistorysearch;
        public $mysearchword;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $idmyhistorysearch = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $search9myhistory=new search9myhistory();
            $search9myhistory->idmyhistorysearch=$idmyhistorysearch++;//����
            $search9myhistory->mysearchword=$row["search_logkeyword"];//����
            $data[] = $search9myhistory;
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
