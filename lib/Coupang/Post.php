<?php

namespace CCPP\Coupang;
use CCPP\Coupang\CoupangAPI;

class Post
{
    public $coupangApi;
    public $downLoadedImagePath;
    public $bbsImagePath;
    public $tableName;
    public $boTable;

    public function __construct(CoupangAPI $coupangApi)
    {
        $this->coupangApi = $coupangApi;
        $this->downLoadedImagePath = G5_PATH.'/coupang/images';
    }

    public function init($tableName)
    {
        global $g5;
        $this->bbsImagePath = G5_PATH.'/data/file/'.$tableName;
        $this->tableName = $tableName;
        $this->boTable = $g5['write_prefix'].$this->tableName;

        if(!is_dir($this->downLoadedImagePath)){
            mkdir($this->downLoadedImagePath, 0777, true);
        } else {
            chmod($this->downLoadedImagePath, 0777);
        }

        if(!is_dir($this->bbsImagePath)){
            mkdir($this->bbsImagePath, 0777, true);
        } else {
            chmod($this->bbsImagePath, 0777);
        }
    }

    public function storeItems($object){
        global $member;
        global $g5;
        $ra = [];
//        $cname = str_replace('(', '', $object[0]->categoryName);
//        $ca_name = str_replace(')', '', $cname);
//        $ids = sql_query("SELECT * FROM {$this->boTable} WHERE ca_name = '{$ca_name}'");
//        while ($row = sql_fetch_array($ids)) {
//            $img = sql_fetch("SELECT * FROM {$g5['board_file_table']} WHERE bo_table='{$this->tableName}' AND wr_id = '{$row["wr_id"]}'");
//            $imgpath = $this->bbsImagePath.''.$img['bf_file'];
//            unlink($imgpath);
//            sql_query("DELETE FROM {$g5['board_file_table']} WHERE bo_table='{$this->tableName}' AND wr_id = '{$row["wr_id"]}'");
//            // 최근게시물 삭제
//            sql_query(" delete from {$g5['board_new_table']} where bo_table = '{$this->tableName}' and wr_parent = '{$row['wr_id']}' ");
//
//            // 스크랩 삭제
//            sql_query(" delete from {$g5['scrap_table']} where bo_table = '{$this->tableName}' and wr_id = '{$row['wr_id']}' ");
//
//        }
//        sql_query("DELETE FROM {$this->boTable} WHERE ca_name = '{$ca_name}'");

        // sql_query("ALTER TABLE {$this->boTable} AUTO_INCREMENT = 0");

        foreach ($object as $key => $value) {
            $cname = str_replace('(', '', $value->categoryName);
            $ca_name = str_replace(')', '', $cname);
            $wr_num = '';
            $wr_reply = "";
            // $ca_name = $cname;
            $html = "";
            $secret = "";
            $mail = "";
            $wr_subject = $value->productName;
            $wr_content = $value->productName;
            $wr_seo_title = str_replace(' ', '-', $value->productName);
            $wr_link1 = $value->productUrl;
            $wr_link2 = "";
            $wr_password = "";
            $wr_name = "";
            $wr_email = "";
            $wr_homepage = "";
            $wr_1 = $value->productId;
            $wr_2 = $value->productPrice;
            $wr_3 = $value->isRokect;
            $wr_4 = $value->isFreeShipping;
            $wr_5 = $value->productImage;
            $wr_6 = $value->rank;
            $wr_7 = "";
            $wr_8 = "";
            $wr_9 = "";
            $wr_10 = "";

            $sql = " insert into {$this->boTable}
                        set wr_num = '$wr_num',
                        wr_reply = '$wr_reply',
                        wr_comment = 0,
                        ca_name = '$ca_name',
                        wr_option = '$html,$secret,$mail',
                        wr_subject = '$wr_subject',
                        wr_content = '$wr_content',
                        wr_seo_title = '$wr_seo_title',
                        wr_link1 = '$wr_link1',
                        wr_link2 = '$wr_link2',
                        wr_link1_hit = 0,
                        wr_link2_hit = 0,
                        wr_hit = 0,
                        wr_good = 0,
                        wr_nogood = 0,
                        mb_id = '{$member['mb_id']}',
                        wr_password = '$wr_password',
                        wr_name = '$wr_name',
                        wr_email = '$wr_email',
                        wr_homepage = '$wr_homepage',
                        wr_datetime = '".G5_TIME_YMDHIS."',
                        wr_file = 1,
                        wr_last = '".G5_TIME_YMDHIS."',
                        wr_ip = '{$_SERVER['REMOTE_ADDR']}',
                        wr_1 = '$wr_1',
                        wr_2 = '$wr_2',
                        wr_3 = '$wr_3',
                        wr_4 = '$wr_4',
                        wr_5 = '$wr_5',
                        wr_6 = '$wr_6',
                        wr_7 = '$wr_7',
                        wr_8 = '$wr_8',
                        wr_9 = '$wr_9',
                        wr_10 = '$wr_10' ";
            $result = sql_query($sql);
            if($result){
                $wr_id = sql_insert_id();
                sql_query("UPDATE {$this->boTable} SET wr_parent = '$wr_id', wr_num = '-$wr_id' WHERE wr_id = '$wr_id'");
                sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$this->tableName}', '{$wr_id}', '{$wr_id}', '".G5_TIME_YMDHIS."', '{$member['mb_id']}' ) ");
                $response = $this->coupangApi->downloadImage($value->productImage, $this->bbsImagePath);
                $body = $response->getBody();
                $metaData =  $body->getMetadata();
                $storeResult = $this->imageStore($wr_id, $metaData['uri']);

                $ra[]['wr_id'] = $wr_id;
                $ra[]['storeResult'] = $storeResult;
            }
        }
        $this->fixCount();

        return $ra;
    }

    function imageStore($wr_id, $fname){
        global $g5;

        $imgpath = $fname;
        $fname = basename($fname);
        $imgdata = getimagesize($imgpath);
        $bf_source = $fname; //원래 파일명
        $bf_file = $fname; //변환된 파일명
        $bf_content = '';
        $bf_fileurl = '';
        $bf_thumburl = '';
        $bf_storage = '';
        $bf_filesize = $imgdata['bits'];
        $bf_width = $imgdata[0];
        $bf_height = $imgdata[1];
        $bf_type = $imgdata[2];

        if (file_exists($imgpath)) {
            $sql = " insert into {$g5['board_file_table']}
                 set bo_table = '{$this->tableName}',
                 wr_id = '{$wr_id}',
                 bf_no = '0',
                 bf_source = '{$bf_source}',
                 bf_file = '{$bf_file}',
                 bf_content = '{$bf_content}',
                 bf_fileurl = '{$bf_fileurl}',
                 bf_thumburl = '{$bf_thumburl}',
                 bf_storage = '{$bf_storage}',
                 bf_download = 0,
                 bf_filesize = '".(int)$bf_filesize."',
                 bf_width = '".(int)$bf_width."',
                 bf_height = '".(int)$bf_height."',
                 bf_type = '".(int)$bf_type."',
                 bf_datetime = '".G5_TIME_YMDHIS."' ";
            return sql_query($sql);
        }
    }

    function fixCount(){
        global $g5;

        // 게시판의 글 수
        $sql = " select count(*) as cnt from {$this->boTable} where wr_is_comment = 0 ";
        $row = sql_fetch($sql);
        $bo_count_write = $row['cnt'];

        // 게시판의 코멘트 수
        $sql = " select count(*) as cnt from {$this->boTable} where wr_is_comment = 1 ";
        $row = sql_fetch($sql);
        $bo_count_comment = $row['cnt'];

        $sql = " select a.wr_id, (count(b.wr_parent) - 1) as cnt from {$this->boTable} a, {$this->boTable} b where a.wr_id=b.wr_parent and a.wr_is_comment=0 group by a.wr_id ";
        $result = sql_query($sql);
        for ($i=0; $row=sql_fetch_array($result); $i++) {
            sql_query(" update {$this->boTable} set wr_comment = '{$row['cnt']}' where wr_id = '{$row['wr_id']}' ");
        }

        $sql = " update {$g5['board_table']}
                    set bo_notice = '',
                        bo_count_write = '{$bo_count_write}',
                        bo_count_comment = '{$bo_count_comment}'
                  where bo_table = '{$this->tableName}' ";
        sql_query($sql);
        delete_cache_latest($this->tableName);
    }
}