<?php
class makeScore{
	function makeScore($msg){
      
    }
	function make($msg){
		 $score = 0;
        //标点分数
        $score += $this->score1($msg);
        //判断含有P标签
        $score += $this->score2($msg);
        //判断是否含有br标签
        $score += $this->score3($msg);
        //判断是否含有li标签
        $score -= $this->score4($msg);
        //判断是否不包含任何标点符号
        $score -= $this->score5($msg);
        //判断javascript关键字
        $score -= $this->score6($msg);
        //判断<li><a这样的标签
        $score -= $this->score7($msg);
        return $score;
	}
    /*
     * 判断是否有标点符号
     */
    private function score1($msg){
        //取得标点符号的个数
        $count = preg_match_all("/(，|。|！|（|）|“|”|；|《|》|、)/si",$msg,$out);
        if($count){
            return $count * 2;
        }else{
            return 0;
        }
    }

    /*
     * 判断是否含有P标签
     */
    private function score2($msg){
        $count = preg_match_all("'<p[^>]*?>.*?</p>'si",$msg,$out);
        return $count * 2;
    }

    /*
     * 判断是否含有BR标签
     */
    private function score3($msg){
        $count = preg_match_all("'<br/>'si",$this->str,$out) + preg_match_all("'<br>'si",$msg,$out);
        return $count * 2;
    }

    /*
     * 判断是否含有li标签
     */
    private function score4($msg){
        //有多少，减多少分 * 2
        $count = preg_match_all("'<li[^>]*?>.*?</li>'si",$msg,$out);
        return $count * 2;
    }

    /*
     * 判断是否不包含任何标点符号
     */
    private function score5($msg){
        if(!preg_match_all("/(，|。|！|（|）|“|”|；|《|》|、|【|】)/si",$msg,$out)){
            return 2;
        }else{
            return 0;
        }
    }

    /*
     * 判断是否包含javascript关键字，有几个，减几分
     */
    private function score6($msg){
        $count = preg_match_all("'javascript'si",$msg,$out);
        return $count;
    }

    /*
     * 判断<li><a这样的标签，有几个，减几分
     */
    private function score7($msg){
        $count = preg_match_all("'<li[^>]*?>.*?<a'si",$msg,$out);
        return $count * 2;
    }
}
?>