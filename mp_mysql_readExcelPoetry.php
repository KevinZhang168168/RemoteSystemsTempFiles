
<?php
//读取excel文件的数据，写入Poetry数据库；这里先写入Poetry主题部分，不包括“问题小贴士”和“课堂互动”这两部分老师用的内容；在其他的php里写入；
//也不包括知识大爆炸，在别的php里写入数据库
//INSERT INTO Poetry SET PoetryName='村居',idPoetryAuthorDynasty_FK='清',idPoetryAuthor_FK='高鼎',PoetryContent='草长莺飞二月天，拂堤杨柳醉春烟。 儿童散学归来早，忙趁东风放纸鸢。',PoetryAuthorNote='高鼎，清代后期诗人。字象一，又字拙吾，仁和（今浙江省杭州市）人。高鼎生活在鸦片战争之后，大约在咸丰年间（1851～1861），著作有《拙吾诗稿》等。',PoetryZonglan='《村居》是清代诗人高鼎所作的一首七言绝句。前两句写景，再现了江南二月明媚的“春景图”；后两句写人，刻画了儿童放学归来放风筝的“乐春图”，景人合一，相映成趣。轻快明丽的景，兴致勃勃的人，饶富乐趣的事，展现了春天生机勃勃的景象，抒发了作者对春天来临的喜悦和赞美。',PoetryFJSY='草长莺飞二月天，拂堤杨柳醉春烟。这两句诗写的是春天所见之景。 草长莺飞二月天：早春二月，小草嫩芽从土里钻出，自由地生长，黄莺在天上纵情飞舞，欢快地鸣叫。 拂堤杨柳醉春烟：杨柳长出了嫩叶，柔软而细长的枝条在春风中摇摆，轻轻地拂扫着堤岸。 儿童散学归来早，忙趁东风放纸鸢。这两句写的是春天所见之人。 儿童散学归来早：傍晚，乡间的小孩子们放学后早早地回来了。 忙趁东风放纸鸢：他们正趁着这和煦的春风放风筝呢！',PoetrySFDB='1.“草长莺飞”四个字，富有动感，涌动着春的脉搏。 2.“拂”“醉”二字，用拟人的手法，写活了杨柳的娇姿、柔态和神韵。 3.诗句由物及人，将明媚醉人的春景与生动活泼的孩童相互渲染，相互映衬，生机勃勃又充满希望的春天尽现眼前。'

require_once "lib\PHPExcel-1.8\Classes\PHPExcel.php";

//读数据

$filename = 'file\Poetry.xlsx';

$objReader = PHPExcel_IOFactory::createReaderForFile($filename);; //准备打开文件

$objPHPExcel = $objReader->load($filename);   //载入文件

//写入数据库
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);

//循环八次，从0开始，代表8个sheet
for ($x=0; $x<=7; $x++) {
    $objPHPExcel->setActiveSheetIndex($x); //设置第一个Sheet，后面循环读取不同的sheet，每个sheet只有一首诗歌，后面做好了excel文件后，可以重新写这个部分

    //以下是一个基本的顺序，按照顺序读取；
    $data1 = $objPHPExcel->getActiveSheet()->getCell('B5')->getValue();  //获取单元格B5的值，诗歌名字
    $data2 = $objPHPExcel->getActiveSheet()->getCell('B6')->getValue();  //获取单元格B6的值，诗歌朝代
    $data3 = $objPHPExcel->getActiveSheet()->getCell('B7')->getValue();  //获取单元格B7的值，诗歌作者
    $data4 = $objPHPExcel->getActiveSheet()->getCell('B8')->getValue();  //获取单元格B8的值，诗歌内容
    $data5 = $objPHPExcel->getActiveSheet()->getCell('B9')->getValue();  //获取单元格B9的值，诗歌诗人简介
    $data6 = $objPHPExcel->getActiveSheet()->getCell('B10')->getValue();  //获取单元格B10的值，诗歌总览
    $data7 = $objPHPExcel->getActiveSheet()->getCell('B11')->getValue();  //获取单元格B11的值，诗歌分句释义
    $data8 = $objPHPExcel->getActiveSheet()->getCell('B12')->getValue();  //获取单元格B12的值，诗歌手法点拨

    if($link){
        //把新计算的数值逐一插入进去；
        $sql_insert = "INSERT INTO Poetry SET PoetryName='" .$data1."'" . ",idPoetryAuthorDynasty_FK='".$data2."'" . ",idPoetryAuthor_FK='".$data3."'" . ",PoetryContent='".$data4."'" . ",PoetryAuthorNote='".$data5."'". ",PoetryZonglan='".$data6."'". ",PoetryFJSY='".$data7."'". ",PoetrySFDB='".$data8."'";
        mysqli_query($link, "set names 'utf8'");
        $result_insert = mysqli_query($link, $sql_insert);
    
        //$data[] = $media_top3service;
        echo( $sql_insert);
    
        //echo json_encode((object)$data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);//将请求结果转换为json格式
        //echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);//将请求结果转换为json格式
        //echo json_encode($data);
        //echo sizeof($data);
    }
    else{
        echo "db connect failed!";
    }
}
//写数据

//$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Hello');//指定要写的单元格位置 

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

//$objWriter->save('2.xls');
?>