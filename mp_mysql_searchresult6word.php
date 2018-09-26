<?php
header("Content-Type:text/html;charset=UTF-8");
//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：{ "id": 1, "idWord": "1", "Wordcontent": "酒", "Wordidiom": "对酒当歌", "Wordsentence_making": "昨天晚上喝了很多酒，醉了。", "Wordmeaning": "用粮食酿酒", "WordPicURI": null } 

//符合搜索关键词的所有字的列表，最多显示3个，只在字的字体，字义，词组，造句四个部分搜索，其余部分不搜索。
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$keyword = $_GET['keyword'];//获取从小程序传递过来的搜索关键词值，
    $keyword = '酒';
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
        
        //还应该有一个学习进度的Json数据返回，我现在文档中写上，这个在php中还没有实现。
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?>
