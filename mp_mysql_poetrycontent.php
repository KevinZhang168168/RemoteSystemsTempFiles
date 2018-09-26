<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：[ { "poetryname": "月下独酌", "PoetryDynasty": "唐朝", "PoetryAuthor": "李白", "PoetryContent": "花间一壶酒，独酌无相亲。", "wordPinyin": "bèi,0_bèi,0_bèi,2_bèi,1_hé,1_Null,2_bèi,2_bèi,2_bèi,2_bèi,2_bèi,2_Null,2_" } ] 
//现在的数据库设计是，我在Poetry这个table中设置了两个列，用来存储会认的字和会写的字，这样，就可以比较了。

//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//提取一个诗歌的视频内容
if($link){
    //idPoetry = $_GET['idPoetry'];//获取从小程序传递过来的id值，
    
    //idPoetry=1暂时按照1代替，实际微信小程序用idPoetry
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
            
            //拆分字符串，加上拼音和颜色；
            //数字0代表会写，字体为红色；1代表会认，字体为黄色；2代表不做要求，字体为黑色。
            //我在数据库Poetry里面维护了两个字段，分别存储这个诗歌中会认的字，和会写的字，这样比较简单；
            function mb_str_split($str){
                
                return preg_split('/(?<!^)(?!$)/u', $str );
                
            }
            //这里拿到诗歌的内容的一个数组；
            $word = array();
            $word = mb_str_split($poetrycontent->PoetryContent);
            
            //拿到必须会写的汉字数组；
            $wordmustwrite=array();
            $wordmustwrite = mb_str_split($row["Poetrymustwrite"]);
            
            //拿到必须会认的汉字数组；
            $wordmustread=array();
            $wordmustread = mb_str_split($row["Poetrymustread"]);
            
            $pinyin = '';
            $wordcolor = 2;
            for ($x=0; $x<count($word); $x++) {
                //echo($word[$x]);
                $sql_pinyin = "SELECT Wordspell FROM word where Wordcontent='". $word[$x]."'";
                mysqli_query($link, "set names 'utf8'");
                $result_pinyin = mysqli_query($link, $sql_pinyin);
                
                if (mysqli_num_rows($result) > 0) {//查到了拼音，这样操作
                    while($row1 = mysqli_fetch_assoc($result_pinyin)) {
                        $ismustwrite = in_array($word[$x] , $wordmustwrite);
                        if($ismustwrite){
                            //在必须会写的数组里；
                            $wordcolor=0;
                        }else{
                            $ismustread = in_array($word[$x] , $wordmustread);
                            //在必须会写的数组里；
                            if($ismustread){
                               $wordcolor=1;
                            }else{
                               //不做要求；
                               $wordcolor=2;
                            }
                        }
                        
                        $pinyin = $pinyin . $row1["Wordspell"] .",". $wordcolor."_";
                    }
                }else{
                    //没有查到拼音,插入“；”；就是标点；
                    $pinyin = $pinyin . ';';
                }
            }
            $poetrycontent->wordPinyin=$pinyin;
            
            $data[] = $poetrycontent;
         }
    
         echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
            //echo($coursein);
        }
        
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
        
        //echo json_encode($data);
        //echo sizeof($data);
}    
else{
    echo "db connect failed!";
}

?> 