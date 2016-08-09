<?php
 	 
$value = trim($vars['value']);
$pos1 = strpos($value, "=");
if ($pos1 !== false) {
    $pos2 = strpos($value,"&",$pos1+1);
    if ($pos2 !== false) {
        $value=substr($value,$pos1+1,$pos2-$pos1-1);
    } else {
        $value = substr($value, $pos1+1);
    }
    
    $size = $vars['size'];
    if (!$size) {
        $size = 'full';
    }
    if ($size == 'thumb') {
        print '<img src="http://img.youtube.com/vi/'.$value.'/2.jpg" />';
    } else {
       
	 
?>

<object width="425" height="344">
<param name="movie" value="http://www.youtube.com/v/<?php echo $value; ?>&hl=en&fs=1"></param>
<param name="allowFullScreen" value="true"></param>
<embed src="http://www.youtube.com/v/<?php echo $value; ?>&hl=en&fs=1" 
type="application/x-shockwave-flash" allowfullscreen="true" 
width="425" height="344">
</embed>
</object>

<?php 
    }
}
?>