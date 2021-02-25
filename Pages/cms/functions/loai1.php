<?php 

    $name=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:"";
    $pageNumber=isset($_REQUEST["pagesNumber"])?$_REQUEST["pageNumber"]:"";
    $rowNumber = isset($_REQUEST["rowNumber"])?$_REQUEST["rowNumber"]:10;
    $total=0;
    $pageNumber = max(1,$pageNumber);
    $res = GetLoaiPT($name,$pageNumber,$rowNumber,$total); 
    //var_dump($res);
    $totalPages = ceil($total/$rowNumber);
    $pageNumber = min($pageNumber,$totalPages);
    $res = GetLoaiPT($name,$pageNumber,$rowNumber,$total); 


?>



<div class="panel panel-primary">
      <div class="panel-heading">
            <h3 class="panel-title">Danh Sách Loại</h3>
      </div>
      <div class="panel-body">
        <select name="" id="" onchange ="window.location.href='?pages=loai&rowNumber='+this.value">
            <option value="">5</option>
            <option value="">10</option>
            <option value="">15</option>
            <option value="">20</option>


        </select>
        <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th></th>
                <th>Mã Loại</th>
                <th>Tên Loại</th>
                <th>Hình Ảnh</th>
                <th>Ghi Chú</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $res->fetch_array()) {
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
                <th><?php echo $row["MaLoai"]; ?></th>
                <th><?php echo $row["TenLoai"]; ?></th>
                <th><?php echo $row["HinhAnh"]; ?></th>
                <th><?php echo $row["GhiChu"]; ?></th>
            </tr>                                   
                <?php              
            }
            ?>        

                    
        </tbody>
    </table>
             <?php echo PhanTrang($totalPages,$pageNumber,"?pages=loai&pageNumber=[i]&rowNumber{$rowNumber}"); ?>
      </div>
</div>

