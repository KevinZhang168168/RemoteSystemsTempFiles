<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idhotestvoice": 1, "voice_uri": "/image/voice/lou.png", "hotestvoice_navito": "../voice/index", "voiceid": "1", "hotestvoice_count": "5" }, { "idhotestvoice": 2, "voice_uri": "/image/voice/lou.png", "hotestvoice_navito": "../voice/index", "voiceid": "2", "hotestvoice_count": "2" } ] 

//��ҳ�ϳ����������������������Ƶ����������ݿ�����ȡ������8�׿��ڵ�ʫ�裬�����ʫ�趼��ֻ��������û����Ƶ�ģ�����ָ������Щֻ��������Ƶ��
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
    //�����ݿ��в�ѯ��ѧ������������������ʶ�
    $sql_top2 = "SELECT Student_log_PERAid_FK, count(*) FROM mp_wx_zxj_demo_mysql.Student_log_PERA group by Student_log_PERAid_FK order by count(*) desc limit 0,2";//��д
    mysqli_query($link, "set names 'utf8'");
    $result_top2 = mysqli_query($link, $sql_top2);
    class hotestpoetryPERA_top2{
        public $idhotestPERA_id;//�õ������ʶ���idֵ��
        public $idhotestPEXA_id_count;//���ֵ���ʶ�������Ĵ���
    }
    //�Ѳ�ѯ�������һ��array������һ������
    $data_top2 = array();
    if (mysqli_num_rows($result_top2) > 0) {
        while($row = mysqli_fetch_assoc($result_top2)) {
            $hotestpoetryPERA_top2=new hotestpoetryPERA_top2();
            $hotestpoetryPERA_top2->idhotestPERA_id=$row["Student_log_PERAid_FK"];//�õ�poetry��idֵ����������
            $hotestpoetryPERA_top2->idhotestPERA_id_count=$row["count(*)"];//�õ�poetry���������ֵ����������
            $data_top2[] = $hotestpoetryPERA_top2;
        }
    }
    
   
    
    class hotestvoice{
        public $idhotestvoice;
        public $voice_uri;
        public $hotestvoice_navito;
        public $voiceid;
        public $hotestvoice_count;
    }
    
   
    $data = array();
    if (mysqli_num_rows($result_top2) > 0) {
        $idhotestvoice = 1;
        for ($x=0; $x<=1; $x++) {
            //echo($data_top2[$x]->idhotestPERA_id);
            $sql = "select Poetry_extended_readingPicURI from mp_wx_zxj_demo_mysql.Poetry_extended_reading where idPoetry_extended_reading = " .$data_top2[$x]->idhotestPERA_id."";
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
            
            while($row = mysqli_fetch_assoc($result)) {
                $hotestvoice=new hotestvoice();
                $hotestvoice->idhotestvoice=$idhotestvoice++;//����+1
                $hotestvoice->voice_uri=$row["Poetry_extended_readingPicURI"];//�õ����word��URIֵ
                $hotestvoice->hotestvoice_navito="../voice/index";
                $hotestvoice->voiceid=$data_top2[$x]->idhotestPERA_id;//�����word��ID���ظ�С����ҳ��
                $hotestvoice->hotestvoice_count=$data_top2[$x]->idhotestPERA_id_count;
                $data[] = $hotestvoice;
            }
            
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
        
    }
    
}
else{
    echo "db connect failed!";
}

?> 