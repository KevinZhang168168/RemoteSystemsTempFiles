<?php
//读取excel文件的数据，写入Poetry这首诗的扩展阅读，不包括“问题小贴士”和“课堂互动”这两部分老师用的内容；在其他的php里写入；
//也不包括知识大爆炸，在别的php里写入数据库
//INSERT INTO Poetry_extended_reading SET Poetry_extended_readingPoetryid_FK=3,Poetry_extended_readingname='早行 ',Poetry_extended_readingdynasty='清',Poetry_extended_readingauthor='高鼎',Poetry_extended_readingcentent='一叶西风里，催程曙色微。 水流残梦急，帆带落星飞。 宿鸟未离树，寒潮欲上矶。 江湖无远近，莫问几时归。',Poetry_extended_readingnote=''INSERT INTO Poetry_extended_reading SET Poetry_extended_readingPoetryid_FK=3,Poetry_extended_readingname='风筝 ',Poetry_extended_readingdynasty='唐',Poetry_extended_readingauthor='高骈',Poetry_extended_readingcentent='夜静弦声响碧空，宫商信任往来风。 依稀似曲才堪听，又被风吹别调中。 ',Poetry_extended_readingnote='诗词大意：静夜里从高空中传来弦声,任由风儿演奏出简单的音调.那音调模糊成曲勉强能欣赏,但不久又奏出另一种声调。'

require_once "lib\PHPExcel-1.8\Classes\PHPExcel.php";

//读数据
$filename = 'file\Poetry.xlsx';

$objReader = PHPExcel_IOFactory::createReaderForFile($filename);; //准备打开文件

$objPHPExcel = $objReader->load($filename);   //载入文件

//$objPHPExcel->setActiveSheetIndex(0);         //设置第一个Sheet，这里只读取了第一个sheet，以后每首诗歌都放入独立的sheet就可以了，按照相同的顺序；

//以下是一个基本的顺序，按照顺序读取；读取第一首扩展阅读
$data1 = $objPHPExcel->getActiveSheet()->getCell('B5')->getValue();  //获取单元格B5的值，诗歌名字

//写入数据库
$hostname_conn = "localhost";
$database_conn = "MP_WX_ZXJ_DEMO_MYSQL";//数据库名
$username_conn = "root";//用户名
$password_conn = "Qinyue590822";//自己数据库的密码

//连接MYSQL数据库
$link = mysqli_connect($hostname_conn, $username_conn, $password_conn,$database_conn)or trigger_error(mysqli_error(),E_USER_ERROR);
if($link){
    //根据诗歌的名字找到对应的id，因为我在数据库中限制了；
    $sql = "select idPoetry from Poetry where PoetryName='".$data1."'";
    mysqli_query($link, "set names 'utf8'");
    $result = mysqli_query($link, $sql);
    
    $poetryid="";
    
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $poetryid=$row["idPoetry"];
        }
    }
}
else{
    echo "db connect failed!";
}

//循环八次，从0开始，代表8个sheet
for ($x=0; $x<=7; $x++) {
    $objPHPExcel->setActiveSheetIndex($x); //设置第一个Sheet，后面循环读取不同的sheet，每个sheet只有一首诗歌，后面做好了excel文件后，可以重新写这个部分
    
    $data2 = $objPHPExcel->getActiveSheet()->getCell('B22')->getValue();  //获取单元格，扩展阅读1的名字
    $data3 = $objPHPExcel->getActiveSheet()->getCell('C22')->getValue();  //获取单元格，扩展阅读1的朝代
    $data4 = $objPHPExcel->getActiveSheet()->getCell('D22')->getValue();  //获取单元格，扩展阅读1的作者
    $data5 = $objPHPExcel->getActiveSheet()->getCell('E22')->getValue();  //获取单元格，扩展阅读1的内容
    $data51 = $objPHPExcel->getActiveSheet()->getCell('F22')->getValue();  //获取单元格，扩展阅读1的诗词大意
    
    
    if($link){
        //echo($imageContents);
        
        //把新计算的数值逐一插入进去；
        $sql_insert = "INSERT INTO Poetry_extended_reading SET Poetry_extended_readingPoetryid_FK=" .$poetryid."" . ",Poetry_extended_readingname='".$data2."'" . ",Poetry_extended_readingdynasty='".$data3."'". ",Poetry_extended_readingauthor='".$data4."'". ",Poetry_extended_readingcentent='".$data5."'". ",Poetry_extended_readingnote='".$data51."'";
        mysqli_query($link, "set names 'utf8'");
        $result_insert = mysqli_query($link, $sql_insert);
        
        //$data[] = $media_top3service;
        echo( $sql_insert);
        
    }
    else{
        echo "db connect failed!";
    }
    
    
    //以下是一个基本的顺序，按照顺序读取；读取第二首扩展阅读
    $data6 = $objPHPExcel->getActiveSheet()->getCell('B23')->getValue();  //获取单元格，扩展阅读2的名字
    $data7 = $objPHPExcel->getActiveSheet()->getCell('C23')->getValue();  //获取单元格，扩展阅读2的朝代
    $data8 = $objPHPExcel->getActiveSheet()->getCell('D23')->getValue();  //获取单元格，扩展阅读2的作者
    $data9 = $objPHPExcel->getActiveSheet()->getCell('E23')->getValue();  //获取单元格，扩展阅读2的内容
    $data91 = $objPHPExcel->getActiveSheet()->getCell('F23')->getValue();  //获取单元格，扩展阅读2的诗词大意
    
    if($link){
        //把新计算的数值逐一插入进去；
        $sql_insert = "INSERT INTO Poetry_extended_reading SET Poetry_extended_readingPoetryid_FK=" .$poetryid."" . ",Poetry_extended_readingname='".$data6."'" . ",Poetry_extended_readingdynasty='".$data7."'". ",Poetry_extended_readingauthor='".$data8."'". ",Poetry_extended_readingcentent='".$data9."'". ",Poetry_extended_readingnote='".$data91."'";
        mysqli_query($link, "set names 'utf8'");
        $result_insert = mysqli_query($link, $sql_insert);
        
        echo( $sql_insert);
        
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