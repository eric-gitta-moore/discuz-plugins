<?php
Administrator(6);
mainjump();
if(cd_webhtml==1 || cd_webhtml==3){die("<font color=\"red\">��ǰվ������ģʽΪ��̬�����ȿ�����̬��</font>");}
echo "<script type=\"text/javascript\">function $(obj) {return document.getElementById(obj);}</script>";
echo "<table style=\"border:1px solid #09C;width:300px\">";
echo "<tr><td>�ۼ�����</td><td><div id=\"num\" style=\"color:blue\">0</div></td></tr>";
echo "<tr><td>�����ܼ�</td><td><div id=\"nums\" style=\"color:green\"><img src=\"static/admincp/images/ajax_loader.gif\" /></div></td></tr>";
echo "</table>";
fwrite(fopen("index.html","wb"),GetTemp("index.html",0));
echo "<script type=\"text/javascript\">$('num').innerHTML=1;</script>";
echo "<script type=\"text/javascript\">$('nums').innerHTML=1;</script>";
?>