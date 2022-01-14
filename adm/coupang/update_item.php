<?php
include "./_common.php";

use CCPP\CoupangAPI;
use Illuminate\Container\Container;
$sub_menu = "400100";
auth_check($auth[$sub_menu], 'r');
include_once('../admin.head.php');

$app = new Container();
$coupangAPI = $app->make(CoupangAPI::class);

$productArr = $coupangAPI->productArr;

if(isset($cp)){
    $table    = sql_real_escape_string($cp['bo_table']);
    $resource = $cp['resource'];
    $method   = $cp['method'];
    $count    = empty($cp['count']) ? '10' : $cp['count'];
    $coupangAPI->init($table);
    $cpItems = $coupangAPI->getBestcategories("$resource", 'GET', $count);
    $result1 = $coupangAPI->storeItems($cpItems->data);
    $result2 = $coupangAPI->fixCount();
}
?>
<form action="" method="POST">
<div class="btn_fixed_top">
    <?php if ($is_admin == 'super') { ?>
        <input type="submit" class="btn_01 btn" value="등록하기">
    <?php } ?>
</div>
<div class="tbl_frm01 tbl_wrap">
    <table>
        <tbody>
            <tr>
                <th>테이블명</th>
                <td>
                    <?php
                    $sql = "SELECT * FROM g5_board WHERE gr_id = 'product'";
                    $result = sql_query($sql);
                    ?>
                    <select name="cp[bo_table]" id="">
                        <?php while($row = sql_fetch_array($result)) { ?>
                            <option value="<?php echo $row['bo_table']?>" <?php echo $row['bo_table'] == 'product' ? 'selected' : ''; ?>><?php echo $row['bo_subject']?></option>
                        <?php } ?>
                    </select>
                    <div>
                        <small>bo_table 값을 입력하세요</small>
                    </div>
                </td>
            </tr>
            <tr>
                <th>주소</th>
                <td>
                    <select name="cp[resource]" id="">
                        <?php foreach ($productArr as $index => $item) { ?>
                            <option value="<?php echo $index?>"><?php echo $item?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>METHOD</th>
                <td>
                    <select name="cp[method]" id="">
                        <option value="GET">GET</option>
                        <option value="POST">POST</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>개수</th>
                <td>
                    <input type="tel" name="cp[count]" class="frm_input" value="100">
                    <div>
                        <small>불러올 아이템의 수를 입력하세요. 1~100까지 입력 가능합니다. </small>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</form>
<?php include_once('../admin.tail.php'); ?>