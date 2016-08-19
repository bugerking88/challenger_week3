<?php
require_once("PDOConnect.php");
header("content-type: text/html; charset=utf-8");
ignore_user_abort();
set_time_limit(0);
$interval=60;

class GetNews_OK extends PDOConnect
{
    public function goCatch()
    {
        $head = ['User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36'];
        $url = "http://www.228365365.com/app/member/FT_future/body_var.php?uid=test00&rtype=r&langx=zh-cn&mtype=3&delay=&league_id=";
        $ch = curl_init();

        //設定連結
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        // 3. 執行，取回 response 結果
        $pageContent = curl_exec($ch);
        $data = htmlspecialchars($pageContent);
        curl_close($ch);

        preg_match_all('/parent.GameFT.+/', $data, $match);

        foreach($match[0] as $ans)
        {
            $ans = htmlspecialchars_decode($ans);
            $ans = str_replace("parent.", "$", $ans);
            $ans = str_replace("new Array", "Array", $ans);
            $ans = str_replace("<br>", " ", $ans);
            $ans = str_replace("<font color=red>Running Ball</font>", "", $ans);
            eval($ans);
        }
        foreach($GameFT as $data)
        {
            $result['id'] = $data[0];
            $result['playTime'] = $data[1];
            $result['league'] = $data[2];
            $result['game']= $data[5]." ".$data[6];
            $result['ownWin'] = $data[15]." ".$data[16]." ".$data[17];
            $result['handicap'] = $data[9]." ".$data[10];
            $result['size'] = $data[13] [14];
            $result['single'] = $data[20];
            $result['couple'] .= " ".$data[21];
            $result['ownWinHalf'] = $data[31]." ".$data[32]." ".$data[33];
            $result['handicapHalf'] = $data[25]." ".$data[26];
            $result['sizeHalf'] = $data[29]." ".$data[30];
            $this->insertData($result);
        }
     }

    public function insertData($result)
    {
        $sql = "insert INTO `RecordTable`(`id` ,  `playTime` ,  `league` ,  `game` ,  `ownWin` ,  `handicap` ,  `size` ,  `single` ,  `couple` , `ownWinHalf` ,  `handicapHalf` ,  `sizeHalf`)";
        $sql .= "VALUES(:id, :playTime, :league, :game, :ownWin, :handicap, :size, :single, :couple, :ownWinHalf, :handicapHalf, :sizeHalf)";
        $db = $this->db->prepare($sql);
        $db->bindParam(':id', $result['id']);
        $db->bindParam(':playTime', $result['playTime']);
        $db->bindParam(':league', $result['league']);
        $db->bindParam(':game', $result['game']);
        $db->bindParam(':ownWin', $result['ownWin']);
        $db->bindParam(':handicap', $result['handicap']);
        $db->bindParam(':size', $result['size']);
        $db->bindParam(':single', $result['single']);
        $db->bindParam(':couple', $result['couple']);
        $db->bindParam(':ownWinHalf', $result['ownWinHalf']);
        $db->bindParam(':handicapHalf', $result['handicapHalf']);
        $db->bindParam(':sizeHalf', $result['sizeHalf']);
        $db->execute();
    }
}
$GetNews_OK1 = new GetNews_OK();
$GetNews_OK1->goCatch();
do{
    $GetNews_OK1->goCatch();
    sleep($interval);// 等待60s

}while(true);
