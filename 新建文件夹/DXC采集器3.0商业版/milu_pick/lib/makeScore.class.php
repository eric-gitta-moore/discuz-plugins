<?php
class makeScore{
	function makeScore($msg){
      
    }
	function make($msg){
		 $score = 0;
        //������
        $score += $this->score1($msg);
        //�жϺ���P��ǩ
        $score += $this->score2($msg);
        //�ж��Ƿ���br��ǩ
        $score += $this->score3($msg);
        //�ж��Ƿ���li��ǩ
        $score -= $this->score4($msg);
        //�ж��Ƿ񲻰����κα�����
        $score -= $this->score5($msg);
        //�ж�javascript�ؼ���
        $score -= $this->score6($msg);
        //�ж�<li><a�����ı�ǩ
        $score -= $this->score7($msg);
        return $score;
	}
    /*
     * �ж��Ƿ��б�����
     */
    private function score1($msg){
        //ȡ�ñ����ŵĸ���
        $count = preg_match_all("/(��|��|��|��|��|��|��|��|��|��|��)/si",$msg,$out);
        if($count){
            return $count * 2;
        }else{
            return 0;
        }
    }

    /*
     * �ж��Ƿ���P��ǩ
     */
    private function score2($msg){
        $count = preg_match_all("'<p[^>]*?>.*?</p>'si",$msg,$out);
        return $count * 2;
    }

    /*
     * �ж��Ƿ���BR��ǩ
     */
    private function score3($msg){
        $count = preg_match_all("'<br/>'si",$this->str,$out) + preg_match_all("'<br>'si",$msg,$out);
        return $count * 2;
    }

    /*
     * �ж��Ƿ���li��ǩ
     */
    private function score4($msg){
        //�ж��٣������ٷ� * 2
        $count = preg_match_all("'<li[^>]*?>.*?</li>'si",$msg,$out);
        return $count * 2;
    }

    /*
     * �ж��Ƿ񲻰����κα�����
     */
    private function score5($msg){
        if(!preg_match_all("/(��|��|��|��|��|��|��|��|��|��|��|��|��)/si",$msg,$out)){
            return 2;
        }else{
            return 0;
        }
    }

    /*
     * �ж��Ƿ����javascript�ؼ��֣��м�����������
     */
    private function score6($msg){
        $count = preg_match_all("'javascript'si",$msg,$out);
        return $count;
    }

    /*
     * �ж�<li><a�����ı�ǩ���м�����������
     */
    private function score7($msg){
        $count = preg_match_all("'<li[^>]*?>.*?<a'si",$msg,$out);
        return $count * 2;
    }
}
?>