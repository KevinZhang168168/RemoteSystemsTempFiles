<?php
header("Content-Type:text/html;charset=UTF-8");
//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����{ "id": 1, "idWord": "1", "Wordcontent": "��", "Wordidiom": "�ԾƵ���", "Wordsentence_making": "�������Ϻ��˺ܶ�ƣ����ˡ�", "Wordmeaning": "����ʳ���", "WordPicURI": null } 

//���������ؼ��ʵ������ֵ��б������ʾ3����ֻ���ֵ����壬���壬���飬����ĸ��������������ಿ�ֲ�������
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$keyword = $_GET['keyword'];//��ȡ��С���򴫵ݹ����������ؼ���ֵ��
    $keyword = '��';
    $keyword=mb_convert_encoding($keyword,'UTF-8','GBK');
    
    $sql = "select idWord,Wordcontent,Wordidiom,Wordsentence_making,Wordmeaning,WordPicURI from Word where Wordcontent like '%".$keyword."%' or Wordidiom like '%".$keyword."%' or Wordsentence_making like '%".$keyword."%' or Wordmeaning like '%".$keyword."%' limit 0,6";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    //echo($sql);
    
    class WordList{
        public $id;
        public $idWord;
        public $Wordcontent;
        public $Wordidiom;
        public $Wordsentence_making;
        public $Wordmeaning;
        public $WordPicURI;
    }
    $id=1;
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $WordList=new WordList();
            $WordList->id=$id++;
            $WordList->idWord=$row["idWord"];
            $WordList->Wordcontent=$row["Wordcontent"];
            $WordList->Wordidiom=$row["Wordidiom"];
            $WordList->Wordsentence_making=$row["Wordsentence_making"];
            $WordList->Wordmeaning=$row["Wordmeaning"];
            $WordList->WordPicURI=$row["WordPicURI"];
            $data[] = $WordList;
            //echo($coursein);
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
