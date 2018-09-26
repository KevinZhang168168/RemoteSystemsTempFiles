<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。学习进度的Json数据没有，目前在小程序的log中存储，并计算学习进度，择机存储到服务器端。
//因此要有一个程序，可以被小程序调用，从小程序的本地log文件中读取学习进度，并上传服务器。应该是每次用户登录的时候上传本地的学习进度，表示他上一次退出后的学习进度；
//每次用户退出的时候也上传，但是小程序很多情况是系统kill这个进程的，因此不一定能执行本次上传操作。
//如果用户没有本地的学习进度，则表示，要么他是第一次登录，要么可能是换了手机，本地无记录但是服务器有记录。因此小程序应该向服务器做请求，读取学习进度，
//如果服务器返回学习进度，则小程序写入此进度到本地log；如果服务器返回为空，则表示此用户是新用户；
//PHP+MySQL测试结果：[ { "id": 1, "idPoetry": "1", "PoetryName": "月下独酌", "idPoetryAuthor": "李白", "idPoetryAuthorDynasty": "唐朝", "PoetryContent": "花间一壶酒，独酌无相亲。", "PoetryPicURI": "/image/media/lou.png" }, { "id": 2, "idPoetry": "2", "PoetryName": "登鹳雀楼", "idPoetryAuthor": "白居易", "idPoetryAuthorDynasty": "唐朝", "PoetryContent": "白日依山尽，黄河入海流。", "PoetryPicURI": "/image/media/lou.png" }, { "id": 3, "idPoetry": "3", "PoetryName": "村居", "idPoetryAuthor": "李白", "idPoetryAuthorDynasty": "唐朝", "PoetryContent": "花间一壶酒，独酌无相亲。", "PoetryPicURI": "/image/media/lou.png" }, { "id": 4, "idPoetry": "4", "PoetryName": "静夜思", "idPoetryAuthor": "白居易", "idPoetryAuthorDynasty": "唐朝", "PoetryContent": "花间一壶酒，独酌无相亲。", "PoetryPicURI": "/image/media/lou.png" } ]

//古诗词首页下方出现用户目前的课本的所有古诗的列表。
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['Studentid'];//获取从小程序传递过来的id值，
    
    //idStudent=1暂时按照1代替，实际微信小程序用$Studentid
    $Studentid=1;
    $sql = "select idPoetry,PoetryName,idPoetryAuthor_FK,idPoetryAuthorDynasty_FK,PoetryContent,PoetryPic_id_FK from Poetry where idCourse_in_grade_PubHouse_Poetry_FK=(select idCourse_in_grade from Course_in_grade where idCourse_in_grade=(select class_Course_in_gradeFK from class where idclass=(SELECT Student_belongto_classid_FK FROM mp_wx_zxj_demo_mysql.Student where idStudent=".$Studentid.")))";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
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
