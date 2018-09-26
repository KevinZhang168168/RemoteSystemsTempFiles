<?php
header("Content-Type:text/html;charset=UTF-8");
//Kevin Zhang 开发环境测试成功，未连接小程序。
//PHP+MySQL测试结果：[ { "id": 1, "idPunckin": "", "Punckindate": "" }, { "id": 2, "idPunckin": "", "Punckindate": "" }, { "id": 3, "idPunckin": "", "Punckindate": "" }, { "id": 4, "idPunckin": "", "Punckindate": "" }, { "id": 5, "idPunckin": "", "Punckindate": "" }, { "id": 6, "idPunckin": "", "Punckindate": "" }, { "id": 7, "idPunckin": "", "Punckindate": "" }, { "id": 8, "idPunckin": "", "Punckindate": "" }, { "id": 9, "idPunckin": "", "Punckindate": "" }, { "id": 10, "idPunckin": "", "Punckindate": "" }, { "id": 11, "idPunckin": "", "Punckindate": "" }, { "id": 12, "idPunckin": "", "Punckindate": "" }, { "id": 13, "idPunckin": "", "Punckindate": "" }, { "id": 14, "idPunckin": "", "Punckindate": "" }, { "id": 15, "idPunckin": "1", "Punckindate": "2018-09-15 00:00:00" }, { "id": 16, "idPunckin": "2", "Punckindate": "2018-09-16 00:00:00" }, { "id": 17, "idPunckin": "3", "Punckindate": "2018-09-17 00:00:00" }, { "id": 18, "idPunckin": "4", "Punckindate": "2018-09-18 00:00:00" }, { "id": 19, "idPunckin": "5", "Punckindate": "2018-09-19 00:00:00" }, { "id": 20, "idPunckin": "6", "Punckindate": "2018-09-20 00:00:00" }, { "id": 21, "idPunckin": "7", "Punckindate": "2018-09-21 00:00:00" }, { "id": 22, "idPunckin": "8", "Punckindate": "2018-09-22 00:00:00" }, { "id": 23, "idPunckin": "9", "Punckindate": "2018-09-23 00:00:00" }, { "id": 24, "idPunckin": "10", "Punckindate": "2018-09-24 00:00:00" }, { "id": 25, "idPunckin": "", "Punckindate": "" }, { "id": 26, "idPunckin": "", "Punckindate": "" }, { "id": 27, "idPunckin": "", "Punckindate": "" }, { "id": 28, "idPunckin": "", "Punckindate": "" }, { "id": 29, "idPunckin": "", "Punckindate": "" }, { "id": 30, "idPunckin": "", "Punckindate": "" } ]


//这个是要给小程序页面做返回的值，首先我们要从punckin中提取，每天需要打卡的诗歌的id；在提取这个学生每天打卡的记录，做对比，才能知道具体用哪种颜色标注view。
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);


if($link){
    //$dateYMD = $_GET['dateYMD'];//获取从小程序传递过来的时间值，
    //$idStu = $_GET['idStu'];//获取从小程序传递过来学生id
    $dateYMD = '2018-09-21';
    $idStu = '1';
    
    //先按照传递进来的日期，在Punchin表格中，把整个月份的应打卡信息全部找出来；按照从1号至31号的顺序；
    //也有可能不是整个月的，因为可以我们的打卡排期是从某个月份的中间一个日期开始的，总之按照月查找；
    //echo($dateYMD);
    //echo(strtotime($dateYMD));
    //echo(date("Y",strtotime($dateYMD)));
    $sql = "select idPunchin,PunchinPoetryid_FK,PunchinExreadingid_FK,Punchindate from Punchin where Year(Punchindate)='".date("Y",strtotime($dateYMD))."' and Month(Punchindate)='".date("m",strtotime($dateYMD))."' order by Punchindate asc";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    //echo($sql);
    
    class PunchinList{
        public $id;//还是想加一个id，顺序值；
        public $idPunckin;//打卡任务的id，不是顺序编号；当天无打卡任务，赋值为空；
        public $Punckindate;//学生打卡的日期，这个值是学生打卡的日期，不是打卡任务的日期，可能是学生补打卡的日期；也可能是空，表示学生当天没有打卡；
    }
    
    //$id = 1;
    $data = array();
    if (mysqli_num_rows($result) > 0) {//搜索结果大于0，证明本月有打卡任务；
        
        
        
        //需要有个外层循环，循环整个月，因为没有打卡任务的日期也需要返回值，除非全月都没有打卡任务；
        $monthdate = date("t",strtotime($dateYMD));//指定月份应有的天数；
        $arr=getdate(strtotime($dateYMD));//使用getdate()函数将当前信息保存。
       
        for ($x=1; $x<=$monthdate; $x++) {//循环整月
            //echo($x);
            $PunchinList=new PunchinList();
            $PunchinList->id=$x;
            
            //从本月的第一天开始循环查找;看看当天是否有打卡任务；
            $sql2 = "select idPunchin,PunchinPoetryid_FK,PunchinExreadingid_FK,Punchindate from Punchin where Punchindate='".$arr["year"]."-".$arr["mon"]."-".$x." '";
            mysqli_query($link, "set names 'utf8'");
            $result2 = mysqli_query($link, $sql2);
            
            if (mysqli_num_rows($result2) > 0){
                //如果不为0，表示这天有打卡任务；
                while($row2 = mysqli_fetch_assoc($result2)) {
                    
                    
                    //这里从学生的打卡信息里逐个查找本月的打卡记录；如果这个学生有某个打卡任务的id，则证明他曾经完成了这个打卡任务；但是不代表是当天打的；
                    //可能是后来补的；
                    $sql1 = "select Student_log_Punchindate,Student_log_Punchinid_FK from Student_log_Punchin where Student_log_PunchinidStu_FK=".$idStu." and Student_log_Punchinid_FK=".$row2["idPunchin"];
                    mysqli_query($link, "set names 'utf8'");
                    $result1 = mysqli_query($link, $sql1);
                    if (mysqli_num_rows($result1) > 0) {//有这条记录
                        $row1 = mysqli_fetch_assoc($result1);
                        $PunchinList->idPunckin=$row1["Student_log_Punchinid_FK"];
                        $PunchinList->Punckindate=$row1["Student_log_Punchindate"];
                    }else{//没有这条记录,赋值为idPunchin为打卡任务的id，日期为空；
                        $PunchinList->idPunckin=$row2["idPunchin"];
                        $PunchinList->Punckindate="";
                    }
                }
            }else{
                //如果为0，表示当天无打卡任务；都是空值；
                $PunchinList->idPunckin="";
                $PunchinList->Punckindate="";
            }
            
            //echo($PunchinList->id);
            //echo($PunchinList->idPunckin);
            //echo($PunchinList->Punckindate);
            $data[] = $PunchinList;
        }
        
        
    }else{//否则证明全月都没有打卡任务，可以直接退出；如果小程序界面得到的值是全空，则表示全月没有打卡任务；
        return 0;
        exit;
            
    }
    
    //还应该有一个学习进度的Json数据返回，我现在文档中写上，这个在php中还没有实现。
    echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
    //echo json_encode($data);
    //echo sizeof($data);
        
}
    

else{
    echo "db connect failed!";
}

?>
