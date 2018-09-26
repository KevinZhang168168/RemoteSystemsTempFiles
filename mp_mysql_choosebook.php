<?php

//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：[ { "idPubHouse": "1", "idCoursein": "1", "semester": "10" }, { "idPubHouse": "1", "idCoursein": "1", "semester": "11" }, { "idPubHouse": "1", "idCoursein": "1", "semester": "20" }, { "idPubHouse": "1", "idCoursein": "1", "semester": "21" } ]

//用户可以在这里自己选择课本，缺省为小学语文二年级下册，这个从数据库里提取。界面上，显示为：
//第一行：版本：从数据库中提取
//第二行：年级：一年级，二年级，三年级，四年级，五年级，六年级；都显示，但是如果数据库中没有此数据，则做灰化处理；
//第三行：学期：上学期，下学期；都显示，但是如果没有数据，则做灰化处理；
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

if($link){
    //$Studentid = $_GET['Studentid'];//获取从小程序传递过来的id值，
    //$idCourse_in_FK = $_GET['idCourse_in_FK']
    //$idCourse_in_grade_PubHouse_FK = $_GET['idCourse_in_grade_PubHouse_FK']
    $idCourse_in_FK=1;//代表语文；
    $idCourse_in_grade_PubHouse_FK=1;//代表部编教材
    
    //idStudent=1暂时按照1代替，实际微信小程序用$Studentid
    //这个字段代表年级和学期，第一个数字代表几年级，第二个数字代表学期，0为上学期，1为下学期；
    //例如21代表，小学二年级下学期，这个数值传给view层，让他们自己判断哪个地方要做灰化处理。
    //目前直接在程序中写死为idCourse_in_FK=1代表语文；
    //写死idCourse_in_grade_PubHouse_FK=1代表部编教材
    $sql = "select idCourse_in_grade_PubHouse_FK,idCourse_in_FK,Course_in_grade_semester from Course_in_grade where idCourse_in_FK=".$idCourse_in_FK." and idCourse_in_grade_PubHouse_FK=".$idCourse_in_grade_PubHouse_FK."";
    
    mysqli_query($link, "set names 'utf8'");
    
    $result = mysqli_query($link, $sql);
    
    class ChooseBook{
        public $idPubHouse;
        public $idCoursein;
        public $semester;
    }
    
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $ChooseBook=new ChooseBook();
            $ChooseBook->idPubHouse=$row["idCourse_in_grade_PubHouse_FK"];
            $ChooseBook->idCoursein=$row["idCourse_in_FK"];
            $ChooseBook->semester=$row["Course_in_grade_semester"];
            $data[] = $ChooseBook;
            //echo($coursein);
        }
        
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
        echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
        //echo json_encode($data);
        //echo sizeof($data);
    }
    
}
else{
    echo "db connect failed!";
}

?>
