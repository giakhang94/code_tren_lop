<?php 

    $sql = "SELECT * FROM `nn_admin`";
    $res = $db->query($sql); 
    // từ khoán tìm kiếm
    $keyword = "";
    // trang hien tai, nho nhat = 1
    $pagesNumber = 
    isset($_REQUEST["pagesNumber"])?$_REQUEST["pagesNumber"]:1;
    $pagesNumber = max(1,$pagesNumber);
    // só dòng / trang
    $rowNumber = 
    isset($_REQUEST["rowNumber"])?$_REQUEST["rowNumber"]:1;
    // tổng số dòng
    $total = 0;
    $taiKhoans = GetAdminsPT($keyword,$pagesNumber,$rowNumber,$total);
    //var_dump($res);
    echo $total;

    // làm phân trang
    // Tính tổng số trang
    $totalPages=ceil($total/$rowNumber);//trong đó Ceil => Làm tròn lên    
    $pagesNumber = min ($pagesNumber, $totalPages);
    $taiKhoans = GetAdminsPT($keyword,$pagesNumber,$rowNumber,$total);

?>



<div class="panel panel-primary">
      <div class="panel-heading">
            <h3 class="panel-title">Danh Sách Loại</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th></th>
                <th>#</th>
                <th>Ho & Tên</th>
                <th>Tài Khoản</th>
                <th>SĐT</th>
                <th>Email</th>
                <th>Tình Trạng</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $index = 1;
            while ($row = $taiKhoans->fetch_array()) {
                ?>
            <tr>
                <th>
                <a class="btn btn-primary"
                 href="?pages=sualoai&id=<?php echo $row["MaLoai"] ?>">Sửa</a>
                 <a 
                 onclick="return confirm('Bạn có muốn xóa loại này không?')" 
                 class="btn btn-danger"
                 href="?pages=xoaloai&id=<?php echo $row["MaLoai"] ?>">Xóa</a>
                </th>
                <th><?php echo $index++; ?></th>
                <th><?php echo $row["Name"]; ?></th>
                <th><?php echo $row["Username"]; ?></th>
                <th><?php echo $row["Phone"]; ?></th>
                <th><?php echo $row["Email"]; ?></th>
                <th><?php echo $row["Active"]; ?></th>
            </tr>                                   
                <?php              
            }
            ?>        

                    
        </tbody>
    </table>
            <?php
                $link = "?pages=danhsachtaikhoan&pagesNumber=[i]"; 
                echo PhanTrang($totalPages,$pagesNumber,$link); 
                ?>         
      </div>
</div>

