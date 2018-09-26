<?php

//Kevin Zhang 开发环境测试成功，未连接小程序
//PHP+MySQL测试结果：王小虎4王小虎2米夏全2米夏全6{ "米夏全": 8, "王小虎": 6 } 

//用户的上传作品被点赞的总次数最多的学生排名，这个从数据库里提取，这里说的作品指的是用户自己上传的任何媒体文件，包含视频和朗读，以及打卡；
//$name=$_GET["name"];//接收参数
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

function comm_sumarrs($arr){
    $item = array();
    foreach($arr as $key=>$value){
        
        foreach($value as $k=>$v){
            if(isset($item[$k])){
                $item[$k] = $item[$k] +$v;
            }else{
                $item[$k] = $v;
            }
        }
    }
    //arsort($item);
    return $item;
}

if($link){
    //从数据库中查询出所有作品，每个作品被点赞的次数；
    $sql_top10 = "SELECT Student_log_Lid_FK, count(*) FROM Student_log_L group by Student_log_Lid_FK";//要测试
    mysqli_query($link, "set names 'utf8'");
    $result_top10 = mysqli_query($link, $sql_top10);
    class Like_top{
        public $Lid;//得到的是小视频的id值。
        public $count;//这个值是小视频被点赞的次数
    }
    //把查询结果放入一个array中做下一步处理。
    $data_top10 = array();
    if (mysqli_num_rows($result_top10) > 0) {
        while($row = mysqli_fetch_assoc($result_top10)) {
            $Like_top=new Like_top();
            $Like_top->Lid=$row["Student_log_Lid_FK"];//拿到小视频的id值，放入数组
            $Like_top->count=$row["count(*)"];//拿到小视频的点赞数量值，放入数组
            $data_top10[] = $Like_top;
        }
    }
    
    class LikestStu{
        //public $idLikestStu;
        public $Stuname;
        public $count;
    };
    
    $data = array();
    if (mysqli_num_rows($result_top10) > 0) {
        $idLikestStu = 1;
        for ($x=0; $x<mysqli_num_rows($result_top10); $x++) {
            //循环找到每个被点赞的作品属于哪个学生；
            $sql = "select StudentName from Student where idStudent=(select Student_shortVideo_log_Stuid_FK from Student_shortVideo_log where idStudent_shortVideo_log = " .$data_top10[$x]->Lid.")";
            mysqli_query($link, "set names 'utf8'");
            $result = mysqli_query($link, $sql);
            //echo($sql);
            
            while($row = mysqli_fetch_assoc($result)) {
                //for ($x1=0; $x1<=count($data); $x1++){
                    $LikestStu=new LikestStu();
                    //$LikestStu->idLikestStu=$idLikestStu++;//自增+1
                    //$LikestStu->Stuname=$row["StudentName"];//拿到这个学生的姓名
                    $LikestStu->Stuname=$row["StudentName"];//拿到这个学生的id
                    $LikestStu->count=$data_top10[$x]->count + $LikestStu->count;//拿到这个学生id的点赞数量
                    $data[] = $LikestStu;
                    //echo($LikestStu->Stuname);
                    //echo($LikestStu->count);
                //}
            }
            
        }
        
        //这是的$data[]里面存储了每个学生的点赞数量，但是没有求和；现在需要求和；
        $res = array();
        /*
        foreach($data as $v) {
            if(isset($datasum[$v['Stuname']])) $datasum[$v['Stuname']]['count'] += $v['count'];
            else $datasum[$v['Stuname']] = $v;
        }
        $datasum = array_values($datasum);
        */
        //$datasum = comm_sumarrs($data);
        //按照点赞的数量合并学生；
        foreach($data as $v) {
            if(! isset($res[$v->Stuname])) $res[$v->Stuname] = 0;
            $res[$v->Stuname] += $v->count;
        }
        //$res就是最后合并的结果，现在还需要排序前十名；
        //array_multisort($res,SORT_DESC,$res);
        arsort($res);//按照点赞的数量做降序；
        //取前十；
        $res = array_slice($res, 0, 10); 
        //echo($res);
        
        echo json_encode($res,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
        
    }
    
    
}
else{
    echo "db connect failed!";
}

?> 