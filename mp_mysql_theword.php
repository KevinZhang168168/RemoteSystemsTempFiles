<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "Wordcontent": "��", "Wordspell": "h��", "Wordstrokes": "14", "Wordsentence_making": "�������Ϻ��˺ܶ�ƣ����ˡ�", "idWordstructure_FK": "1", "Wordmeaning": "����ʳ���", "Wordidiom": "�ԾƵ���", "WordBushou": null, "WordYinxu": null, "WordPicURI": null } ] 
//���ﲻ������˳����˳������ȡ��

//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//��ȡһ��ʫ�����Ƶ����
if($link){
    //$idword = $_GET['idword'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //idword=1��ʱ����1���棬ʵ��΢��С������idword
    $idword=1;
    $sql = "SELECT Wordcontent,Wordspell,Wordstrokes,Wordsentence_making,idWordstructure_FK,Wordmeaning,Wordidiom,WordBushou,WordYinxu,WordPicURI FROM Word where idWord=".$idword."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class wordcontent{
        public $Wordcontent;
        public $Wordspell;
        public $Wordstrokes;
        public $Wordsentence_making;
        public $idWordstructure_FK;
        
        public $Wordmeaning;
        public $Wordidiom;
        public $WordBushou;
        public $WordYinxu;
        public $WordPicURI;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $wordcontent=new wordcontent();
            $wordcontent->Wordcontent=$row["Wordcontent"];
            $wordcontent->Wordspell=$row["Wordspell"];
            $wordcontent->Wordstrokes=$row["Wordstrokes"];
            $wordcontent->Wordsentence_making=$row["Wordsentence_making"];
            $wordcontent->idWordstructure_FK=$row["idWordstructure_FK"];
            $wordcontent->Wordmeaning=$row["Wordmeaning"];
            $wordcontent->Wordidiom=$row["Wordidiom"];
            $wordcontent->WordBushou=$row["WordBushou"];
            $wordcontent->WordYinxu=$row["WordYinxu"];
            $wordcontent->WordPicURI=$row["WordPicURI"];
            
            
            //$wordcontent->wordPinyin=$pinyin;
            
            
            $data[] = $wordcontent;
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