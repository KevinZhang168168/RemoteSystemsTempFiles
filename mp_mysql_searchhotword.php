<?php
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "idhotestword": 1, "word_uri": "/image/word/jiu.png", "hotestword_navito": "../word/index", "wordid": "1", "hotestword_count": "4" }, { "idhotestword": 2, "word_uri": "/image/word/lou.png", "hotestword_navito": "../word/index", "wordid": "2", "hotestword_count": "2" } ] 

//��ҳ�ϳ�����������������ִʣ���������ݿ�����ȡ
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //�����ݿ��в�ѯ��ѧ������������������ִ�
    $sql_top2 = "SELECT Student_log_WLWordid_FK, count(*) FROM mp_wx_zxj_demo_mysql.student_log_wl group by Student_log_WLWordid_FK order by count(*) desc limit 0,2";//��д
    mysqli_query($link, "set names 'utf8'");
    $result_top2 = mysqli_query($link, $sql_top2);
    class hotestword_top2{
        public $idhotestword_PLid;//�õ������ִʵ�idֵ��
        public $idhotestword_PLid_count;//���ֵ���ִʱ�����Ĵ���
    }
    //�Ѳ�ѯ�������һ��array������һ������
    $data_top2 = array();
    if (mysqli_num_rows($result_top2) > 0) {
        while($row = mysqli_fetch_assoc($result_top2)) {
            $hotestword_top2=new hotestword_top2();
            $hotestword_top2->idhotestword_PLid=$row["Student_log_WLWordid_FK"];//�õ�word��idֵ����������
            $hotestword_top2->idhotestWord_PLid_count=$row["count(*)"];//�õ�word���������ֵ����������
            //echo($hotestword_top2->idhotestWord_PLid_count);
            $data_top2[] = $hotestword_top2;
        }
    }
    
    //�����Ǹ�С����ҳ��ķ���ֵ
    class hotestword{
        public $idhotestword;
        public $word_uri;
        public $hotestword_navito;
        public $wordid;
        public $hotestword_count;
    }
   
    $data = array();
    if (mysqli_num_rows($result_top2) > 0) {
        $idhotestword = 1;
        for ($x=0; $x<=1; $x++) {
            $sql = "select Word_picURI from mp_wx_zxj_demo_mysql.word_pic where idWord_pic = " .$data_top2[$x]->idhotestword_PLid."";
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
            
            while($row = mysqli_fetch_assoc($result)) {
                $hotestword=new hotestword();
                $hotestword->idhotestword=$idhotestword++;//����+1
                $hotestword->word_uri=$row["Word_picURI"];//�õ����word��URIֵ
                $hotestword->hotestword_navito="../word/index";
                $hotestword->wordid=$data_top2[$x]->idhotestword_PLid;//�����word��ID���ظ�С����ҳ��
                $hotestword->hotestword_count=$data_top2[$x]->idhotestWord_PLid_count;
                //echo($hotestword_top2->idhotestWord_PLid_count);
                $data[] = $hotestword;
            }
            
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
            
        }
        
}
else{
    echo "db connect failed!";
}

?> 
