<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idhotestpoetry": 1, "poetry_uri": "/image/poetry/cunju.png", "hotestpoetry_navito": "../poetry/index", "poetryid": "1", "hotestpoetry_count": "3" }, { "idhotestpoetry": 2, "poetry_uri": "/image/poetry/dengguanquelou.png", "hotestpoetry_navito": "../poetry/index", "poetryid": "2", "hotestpoetry_count": "2" } ] 

//��ҳ�ϳ����������������ʫ�裬��������ݿ�����ȡ
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
    
    //�����ݿ��в�ѯ��ѧ�����������������ʫ��
    $sql_top2 = "SELECT Student_log_PLPoetryid_FK, count(*) FROM student_log_pl group by Student_log_PLPoetryid_FK order by count(*) desc limit 0,2";//��д
    mysqli_query($link, "set names 'utf8'");
    $result_top2 = mysqli_query($link, $sql_top2);
    class hotestpoetry_top2{
        public $idhotestpoetry_PLid;//�õ�����ʫ���idֵ��
        public $idhotestpoetry_PLid_count;//���ֵ��ʫ�豻����Ĵ���
    }
    //�Ѳ�ѯ�������һ��array������һ������
    $data_top2 = array();
    if (mysqli_num_rows($result_top2) > 0) {
        while($row = mysqli_fetch_assoc($result_top2)) {
            $hotestpoetry_top2=new hotestpoetry_top2();
            $hotestpoetry_top2->idhotestpoetry_PLid=$row["Student_log_PLPoetryid_FK"];//�õ�poetry��idֵ����������
            $hotestpoetry_top2->idhotestpoetry_PLid_count=$row["count(*)"];//�õ�poetry���������ֵ����������
            $data_top2[] = $hotestpoetry_top2;
        }
    }
    
    //$result_top2->close();
    //$link->close();
    //echo (mysqli_num_rows($result_top2));
    //echo json_encode($data_top2,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    //echo ($data_top2);
    
    //�����Ǹ�С����ҳ��ķ���ֵ
    //$sql = "select Poetry_picURI from poetry_pic where idPoetry_pic = " ;
    //mysqli_query($link, "set names 'utf8'");
    
    //$result = mysqli_query($link, $sql);
    
    class hotestpoetry{
        public $idhotestpoetry;
        public $poetry_uri;
        public $hotestpoetry_navito;
        public $poetryid;
        public $hotestpoetry_count;
    }
    
    $data = array();
    if (mysqli_num_rows($result_top2) > 0) {
        //echo (mysqli_num_rows($result_top2));
        //echo (mysqli_fetch_assoc($data_top2));
        //while($row = mysqli_fetch_assoc($result_top2)) {
        $idhotestpoetry = 1;
        
        $PLid="";//$link1 = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);
        
        //while($row = mysqli_num_rows($result_top2)) {
        //while($row = mysqli_fetch_assoc($data_top2)) {
        for ($x=0; $x<=1; $x++) {
            //$sql = "select Poetry_picURI from mp_wx_zxj_demo_mysql.poetry_pic where idPoetry_pic = 1"; //$hotestpoetry_top2->idhotestpoetry_PLid=row["Student_log_PLPoetryid_FK"];
            $PLid= $data_top2[$x]->idhotestpoetry_PLid;
            $sql = "select Poetry_picURI from mp_wx_zxj_demo_mysql.poetry_pic where idPoetry_pic = " .$PLid."";
            //echo($sql);
            
            //if($link1) {
            //$link1 = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn);//or trigger_error(mysqli_error(),E_USER_ERROR);
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
            //echo (mysqli_num_rows($result));
            
            while($row = mysqli_fetch_assoc($result)) {
                $hotestpoetry=new hotestpoetry();
                $hotestpoetry->idhotestpoetry=$idhotestpoetry++;//����+1
                $hotestpoetry->poetry_uri=$row["Poetry_picURI"];//�õ����poetry��URIֵ
                $hotestpoetry->hotestpoetry_navito="../poetry/index";
                $hotestpoetry->poetryid=$data_top2[$x]->idhotestpoetry_PLid;//�����poetry��ID���ظ�С����ҳ��
                $hotestpoetry->hotestpoetry_count=$data_top2[$x]->idhotestpoetry_PLid_count;
                $data[] = $hotestpoetry;
            }
            //echo($coursein);
            //echo (idhotestpoetry);
            //echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        //}
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