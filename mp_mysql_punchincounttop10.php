<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "Studentname": "��С��", "count": "10" }, { "id": 2, "Studentname": "����", "count": "4" }, { "id": 3, "Studentname": "����ȫ", "count": "3" }, { "id": 4, "Studentname": "����", "count": "3" } ]

//�ĸ�ѧ����ʷ�ϴ򿨴�������ǰʮ������������ݿ�����ȡ
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
    //SELECT Student_log_PunchinidStu_FK, count(*) FROM mp_wx_zxj_demo_mysql.Student_log_Punchin group by Student_log_PunchinidStu_FK order by count(*) desc limit 0,10;
    $sql = "SELECT Student_log_PunchinidStu_FK, count(*) FROM Student_log_Punchin group by Student_log_PunchinidStu_FK order by count(*) desc limit 0,10";//
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class searchtop10punchin{
        public $id;
        public $Studentname;
        public $count;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $sql1 = "select StudentName from Student where idStudent=".$row["Student_log_PunchinidStu_FK"]."";//
            mysqli_query($link, "set names 'utf8'");
            $result1 = mysqli_query($link, $sql1);
            
            $searchtop10punchin=new searchtop10punchin();
            $searchtop10punchin->id=$id++;//���Բ�Ҫ��
            while($row1 = mysqli_fetch_assoc($result1)) {
                $searchtop10punchin->Studentname=$row1["StudentName"];//����
            }
            
            $searchtop10punchin->count=$row["count(*)"];
            $data[] = $searchtop10punchin;
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
