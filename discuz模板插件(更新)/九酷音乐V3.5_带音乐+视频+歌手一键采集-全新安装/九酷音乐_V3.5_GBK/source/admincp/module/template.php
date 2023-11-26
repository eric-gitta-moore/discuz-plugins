<?php
close_browse();
$f=SafeRequest("f","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>模板目录</title>
<link href="static/admincp/images/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function ReturnValue(reimg){
        this.parent.document.<?php echo $f; ?>.value=reimg;
        this.parent.asyncbox.tips("恭喜，模板选择成功！", "success", 1000);
        this.parent.layer.closeAll();
}
</script>
</head>
<body>
<div class="container">
<table class="tb tb2">
<tr class="header">
<th>模板名称</th>
<th>文件大小</th>
<th>修改时间</th>
</tr>
<?php
$path = cd_templatedir;
if(file_exists($path) && is_dir($path)) {
        $d = dir($path);
        $d->rewind();
        while(false !== ($v = $d->read())) {
                if($v == "." || $v == "..") {
                        continue; 
                }
                $file = $d->path.$v; 
                if(is_dir($file)) {
                        continue;
                }
                if(is_file($file)) {
                        echo "<tr class=\"hover\">";
                        echo "<td><a href=\"javascript:ReturnValue('".$v."');\" class=\"act\">".$v."</a></td>";
                        echo "<td>".round(filesize($file)/1204,2)."Kb</td>";
                        echo "<td>".date('Y-m-d H:i:s',filemtime($file))."</td>";
                        echo "</tr>";
                }
        }
        $d->close();
}
?>
</table>
</div>
</body>
</html>