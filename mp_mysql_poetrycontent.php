<?php

//Kevin Zhang �����������Գɹ���δ����С����
//PHP+MySQL���Խ����[ { "poetryname": "���¶���", "PoetryDynasty": "�Ƴ�", "PoetryAuthor": "���", "PoetryContent": "����һ���ƣ����������ס�", "wordPinyin": "b��i,0_b��i,0_b��i,2_b��i,1_h��,1_Null,2_b��i,2_b��i,2_b��i,2_b��i,2_b��i,2_Null,2_" } ] 
//���ڵ����ݿ�����ǣ�����Poetry���table�������������У������洢���ϵ��ֺͻ�д���֣��������Ϳ��ԱȽ��ˡ�

//$name=$_GET["name"];//���ղ���
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//���ݿ���
$username_conn = "root";//�û���
$password_conn = "Qinyue590822";//�Լ����ݿ������

//����MYSQL���ݿ�
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//��ȡһ��ʫ�����Ƶ����
if($link){
    //idPoetry = $_GET['idPoetry'];//��ȡ��С���򴫵ݹ�����idֵ��
    
    //idPoetry=1��ʱ����1���棬ʵ��΢��С������idPoetry
    $idPoetry=1;
    $sql = "SELECT PoetryName,idPoetryAuthorDynasty_FK,idPoetryAuthor_FK,PoetryContent,Poetrymustwrite,Poetrymustread FROM Poetry where idPoetry=".$idPoetry."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class poetrycontent{
        public $poetryname;
        public $PoetryDynasty;
        public $PoetryAuthor;
        public $PoetryContent;
        public $wordPinyin;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            
            $poetrycontent=new poetrycontent();
            $poetrycontent->poetryname=$row["PoetryName"];
            $poetrycontent->PoetryDynasty=$row["idPoetryAuthorDynasty_FK"];
            $poetrycontent->PoetryAuthor=$row["idPoetryAuthor_FK"];
            $poetrycontent->PoetryContent=$row["PoetryContent"];
            
            //����ַ���������ƴ������ɫ��
            //����0�����д������Ϊ��ɫ��1������ϣ�����Ϊ��ɫ��2������Ҫ������Ϊ��ɫ��
            //�������ݿ�Poetry����ά���������ֶΣ��ֱ�洢���ʫ���л��ϵ��֣��ͻ�д���֣������Ƚϼ򵥣�
            function mb_str_split($str){
                
                return preg_split('/(?<!^)(?!$)/u', $str );
                
            }
            //�����õ�ʫ������ݵ�һ�����飻
            $word = array();
            $word = mb_str_split($poetrycontent->PoetryContent);
            
            //�õ������д�ĺ������飻
            $wordmustwrite=array();
            $wordmustwrite = mb_str_split($row["Poetrymustwrite"]);
            
            //�õ�������ϵĺ������飻
            $wordmustread=array();
            $wordmustread = mb_str_split($row["Poetrymustread"]);
            
            $pinyin = '';
            $wordcolor = 2;
            for ($x=0; $x<count($word); $x++) {
                //echo($word[$x]);
                $sql_pinyin = "SELECT Wordspell FROM word where Wordcontent='". $word[$x]."'";
                mysqli_query($link, "set names 'utf8'");
                $result_pinyin = mysqli_query($link, $sql_pinyin);
                
                if (mysqli_num_rows($result) > 0) {//�鵽��ƴ������������
                    while($row1 = mysqli_fetch_assoc($result_pinyin)) {
                        $ismustwrite = in_array($word[$x] , $wordmustwrite);
                        if($ismustwrite){
                            //�ڱ����д�������
                            $wordcolor=0;
                        }else{
                            $ismustread = in_array($word[$x] , $wordmustread);
                            //�ڱ����д�������
                            if($ismustread){
                               $wordcolor=1;
                            }else{
                               //����Ҫ��
                               $wordcolor=2;
                            }
                        }
                        
                        $pinyin = $pinyin . $row1["Wordspell"] .",". $wordcolor."_";
                    }
                }else{
                    //û�в鵽ƴ��,���롰���������Ǳ�㣻
                    $pinyin = $pinyin . ';';
                }
            }
            $poetrycontent->wordPinyin=$pinyin;
            
            $data[] = $poetrycontent;
         }
    
         echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//��������ת��Ϊjson��ʽ
            //echo($coursein);
        }
        
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//��������ת��Ϊjson��ʽ
        
        //echo json_encode($data);
        //echo sizeof($data);
}    
else{
    echo "db connect failed!";
}

?> 