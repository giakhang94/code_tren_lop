<?php 

function Db(){
    return $GLOBALS['db'];
}

function XinChao($hoTen){

    return "Xin chao" . $hoTen; 
}

function  GetLoaiById($id){
    $sql = "SELECT * FROM `nn_loai`
     WHERE `MaLoai` = {$id}";
    $res = Db()->query($sql);
    $loai = $res->fetch_array();
    return $loai;
}  

function UpdateLoai($loai){
    $sql = "UPDATE `nn_loai` SET 
    `TenLoai`='{$loai['TenLoai']}',
    `GhiChu`='{$loai['GhiChu']}',
    `HinhAnh`='{$loai['HinhAnh']}' WHERE `MaLoai` = {$loai['MaLoai']}";
    Db()->query($sql);
}
 function InsertLoai($loai){
    $sql = "INSERT INTO `nn_loai` SET 
    `TenLoai`='{$loai['TenLoai']}',
    `GhiChu`='{$loai['GhiChu']}',
    `HinhAnh`='{$loai['HinhAnh']}'";
    Db()->query($sql);
 }
 function UploadFile($fileUpload,$filePath){
    copy($fileUpload["tmp_name"],$filePath);
 }
 // lấy danh sách tài khoản và phân trang
 function GetAdminsPT ($keyword,$pagesNumber,$rowNumber,&$total){
     // tính vị trí bắt đầu
     $pagesNumber = ($pagesNumber - 1)* $rowNumber;
     // cau lenh truy vấn
    $sql = "SELECT * FROM `nn_admin` 
    WHERE `Name` LIKE '%{$keyword}%' 
    OR `Username` LIKE '%{$keyword}%' 
    OR `Email` LIKE '%{$keyword}%' 
    OR `Phone` LIKE '%{$keyword}%'";
    $res = Db()->query($sql);
    // lấy tổng số dòng
    $total = $res->num_rows;
    // giới hạn số lượng dòng trả về
    $sql = $sql ." limit {$pagesNumber},{$rowNumber}";
    // trả về các dòng hiển thị
    return Db()->query($sql);
    
 }
 function GetLoaiPT ($keyword,$pagesNumber,$rowNumber,&$total){
    // tính vị trí bắt đầu
    $pagesNumber = ($pagesNumber - 1)* $rowNumber;
    // cau lenh truy vấn
   $sql = "SELECT * FROM `nn_loai` 
   WHERE `TenLoai` LIKE '%{$keyword}%'";
   $res = Db()->query($sql);
   // lấy tổng số dòng
   $total = $res->num_rows;
   // giới hạn số lượng dòng trả về
   $sql = $sql ." limit {$pagesNumber},{$rowNumber}";
   // trả về các dòng hiển thị
   return Db()->query($sql);
// $sql = "SELECT * FROM `nn_loai`";
// $db->query($sql);
 function InsertTaiKhoan($tk){
     $sql = "INSERT INTO 
    `nn_admin` 
    (`Id`,  `Name`,  `Username`,  `Password`, 
    `Randomkey`,  `Email`,  `Phone`,  `BOD`, 
    `Sex`,  `Address`, `Active`, `GGCode`) 
    VALUES (NULL, '{$tk["Name"]}', '{$tk["Username"]}',
     '{$tk["Password"]}', 
     '{$tk["Randomkey"]}',
      '{$tk["Email"]}', 
      '{$tk["Phone"]}', 
      '{$tk["BOD"]}', 
      '{$tk["Sex"]}', 
      '{$tk["Address"]}', 
      '{$tk["Active"]}', NULL)";
    Db()->query($sql);

 }  
function RandomString($lenght =10){
    $strrand = time().rand(0,time());
    $strrand = sha1($strrand);
    return substr($strrand,0,($lenght-1));
}

function GetTaiKhoanByUsername($un){
    // tìm tài khoản theo username
    $sql = "SELECT * FROM `nn_admin` where Username = '{$un}'";
    $res =  Db()->query($sql);
    if($res->num_rows > 0)
        return $res->fetch_array();
    return null;
}
function GetTaiKhoanByEmail($email){
    // tìm tài khoản theo username
    $sql = "SELECT * FROM `nn_admin` where Email = '{$email}'";
    $res =  Db()->query($sql);
    if($res->num_rows > 0)
        return $res->fetch_array();
    return null;
}
function PhanTrang($totalPgaes, $currentPage,$link){
    $next = $currentPage +1;
    $next = min($next, $totalPgaes);
  
    $prev = $currentPage-1;
    $prev = max (1,$prev);
    $start = $currentPage-3;
    $start = max(1, $start);
    $end = $currentPage+3;
    $end = min($totalPgaes, $end);
    $linkNext = str_replace("[i]",$next,$link);
    $linkPrev = str_replace("[i]",$prev,$link);
    $linkLast = str_replace("[i]",$totalPgaes,$link);
    $linkFirst = str_replace("[i]",1,$link);
    $isFirst = $currentPage==1?"hidden":"";
    $isLast = $currentPage==$totalPgaes?"hidden":"";
//$link="?pages=danhsachtaikhoan&pagesNumber=[i];
$String = <<<PhanTrang
<ul class="pagination">
        <li class="" >
             <a href="$linkFirst">
             First
        </a>
        </li>
        <li class="" >
            <a href="$linkPrev">
                 Prev
            </a>
        </li>
    __for__
        <li class="" >
                <a href="$linkNext">
                    Next
                </a>
    </li>
    <li class="" >
                <a href="$linkLast">
                    Last
                </a>
    </li>
    
    
    
</ul>             
PhanTrang;
$forString="";
    for($i=$start; $i<=$end; $i++){
        $linkPages = str_replace("[i]",$i,$link);
        $active = $currentPage==$i?"active":"";
        $strPage = "<li class='{$active}'><a  href='{$linkPages}'>{$i}</a></li>";
        $forString.=$strPage;
    }
    $String = str_replace("__for__",$forString,$String);
    return $String;
}