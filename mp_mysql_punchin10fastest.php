<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "id": 1, "Studentname": "��С��", "fastesttime": "17" }, { "id": 2, "Studentname": "��С��", "fastesttime": "37" }, { "id": 3, "Studentname": "��С��", "fastesttime": "57" }, { "id": 4, "Studentname": "��С��", "fastesttime": "17" }, { "id": 5, "Studentname": "��С��", "fastesttime": "37" }, { "id": 6, "Studentname": "��С��", "fastesttime": "57" }, { "id": 7, "Studentname": "��С��", "fastesttime": "17" }, { "id": 8, "Studentname": "����", "fastesttime": "17" }, { "id": 9, "Studentname": "����", "fastesttime": "17" }, { "id": 10, "Studentname": "����ȫ", "fastesttime": "17" } ]

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
    //SELECT *, ABS(NOW() - startTime)  AS diffTime
    //FROM PolicyShuPrice
    //ORDER BY diffTime ASC
    //LIMIT 0, 1
    
    //SELECT *, abs(UNIX_TIMESTAMP(start_time)-UNIX_TIMESTAMP('2017-02-22')) as min from t_service_orders where user_id=7 GROUP BY min desc
    //��Ҫ��д����Ҫ�õ���ֵ��ÿ������������������ֵ������Ӧ���������ǰ���ÿ����������������ÿ�������6�㵽�賿12���ڼ��ĸ��ϴ�ʱ�����6�������
    //Ȼ���������е���������������ĸ���ֵ��С��
    $sql = "SELECT Student_log_PunchinidStu_FK, ABS(NOW() - Student_log_Punchindate)  AS diffTime FROM Student_log_Punchin order by diffTime desc limit 0,10";//
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class searchtop10punchinfastest{
        public $id;
        public $Studentname;
        public $fastesttime;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $id = 1;
        while($row = mysqli_fetch_assoc($result)) {
            
            $sql1 = "select StudentName from Student where idStudent=".$row["Student_log_PunchinidStu_FK"]."";//
            mysqli_query($link, "set names 'utf8'");
            $result1 = mysqli_query($link, $sql1);
            
            $searchtop10punchinfastest=new searchtop10punchinfastest();
            $searchtop10punchinfastest->id=$id++;//���Բ�Ҫ��
            while($row1 = mysqli_fetch_assoc($result1)) {
                $searchtop10punchinfastest->Studentname=$row1["StudentName"];
            }
            
            $searchtop10punchinfastest->fastesttime=strftime('%S',$row["diffTime"]);//�������
            $data[] = $searchtop10punchinfastest;
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
