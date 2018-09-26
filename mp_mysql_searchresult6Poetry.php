<?php
header("Content-Type:text/html;charset=UTF-8");
//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：[ { "id": 1, "idPoetry": "1", "PoetryName": "月下独酌", "idPoetryAuthor": "李白", "idPoetryAuthorDynasty": "唐朝", "PoetryContent": "花间一壶酒，独酌无相亲。", "PoetryPicURI": "/image/media/lou.png" }, { "id": 2, "idPoetry": "2", "PoetryName": "登鹳雀楼", "idPoetryAuthor": "白居易", "idPoetryAuthorDynasty": "唐朝", "PoetryContent": "白日依山尽，黄河入海流。", "PoetryPicURI": "/image/media/lou.png" }, { "id": 3, "idPoetry": "3", "PoetryName": "村居", "idPoetryAuthor": "李白", "idPoetryAuthorDynasty": "唐朝", "PoetryContent": "花间一壶酒，独酌无相亲。", "PoetryPicURI": "/image/media/lou.png" }, { "id": 4, "idPoetry": "4", "PoetryName": "静夜思", "idPoetryAuthor": "白居易", "idPoetryAuthorDynasty": "唐朝", "PoetryContent": "花间一壶酒，独酌无相亲。", "PoetryPicURI": "/image/media/lou.png" }, { "id": 5, "idPoetry": "5", "PoetryName": "Hello", "idPoetryAuthor": "李白", "idPoetryAuthorDynasty": "唐朝", "PoetryContent": "花间一壶酒，独酌无相亲。", "PoetryPicURI": "/image/media/lou.png" }, { "id": 6, "idPoetry": "6", "PoetryName": "Hello1", "idPoetryAuthor": "李白", "idPoetryAuthorDynasty": "唐朝", "PoetryContent": "花间一壶酒，独酌无相亲。", "PoetryPicURI": "/image/media/lou.png" } ]


//符合搜索关键词的所有古诗的列表，最多显示3个，只在诗歌的名字，朝代，作者，诗歌内容四个部分搜索，其余部分不搜索。
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);


if($link){
    //$keyword = $_GET['keyword'];//获取从小程序传递过来的搜索关键词值，
    
    //idStudent=1暂时按照1代替，实际微信小程序用$Studentid
    //$keyword = mb_str_split($keyword);
    $keyword = '唐';
    $keyword=mb_convert_encoding($keyword,'UTF-8','GBK');
    
    //echo(mb_check_encoding($keyword));
    //echo( mb_substr($keyword,0,4,"gb2312"));
    //$keyword = implode('',mb_str_split($keyword));
    //echo(mb_str_split($keyword));
    //select idPoetry,PoetryName,idPoetryAuthor_FK,idPoetryAuthorDynasty_FK,PoetryContent,PoetryPic_id_FK from mp_wx_zxj_demo_mysql.Poetry where PoetryName='村';
    //select idPoetry,PoetryName,idPoetryAuthor_FK,idPoetryAuthorDynasty_FK,PoetryContent,PoetryPic_id_FK from mp_wx_zxj_demo_mysql.Poetry where PoetryName like "%村%";
    
    $sql = "select idPoetry,PoetryName,idPoetryAuthor_FK,idPoetryAuthorDynasty_FK,PoetryContent,PoetryPic_id_FK from Poetry where PoetryName like '%".$keyword."%' or idPoetryAuthor_FK like '%".$keyword."%' or idPoetryAuthorDynasty_FK like '%".$keyword."%' or PoetryContent like '%".$keyword."%' limit 0,6";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    //echo($sql);
    
    class PoetryList{
        public $id;
        public $idPoetry;
        public $PoetryName;
        public $idPoetryAuthor;
        public $idPoetryAuthorDynasty;
        public $PoetryContent;
        public $PoetryPicURI;
    }
    $id=1;
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $PoetryList=new PoetryList();
            $PoetryList->id=$id++;
            $PoetryList->idPoetry=$row["idPoetry"];
            $PoetryList->PoetryName=$row["PoetryName"];
            $PoetryList->idPoetryAuthor=$row["idPoetryAuthor_FK"];
            $PoetryList->idPoetryAuthorDynasty=$row["idPoetryAuthorDynasty_FK"];
            $PoetryList->PoetryContent=$row["PoetryContent"];
            $PoetryList->PoetryPicURI=$row["PoetryPic_id_FK"];
            $data[] = $PoetryList;
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
