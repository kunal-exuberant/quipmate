<?php
$file = $_GET['file'];
$width_thumb = (int)$_GET['width'];
$height_thumb = (int)$_GET['height'];
$width_max = (int)$_GET['maxw'];
$height_max = (int)$_GET['maxh'];

if($width_max && $height_max)
{
	$sType = 'scale';
}
else if ($width_thumb && $height_thumb)
{
	$sType = 'exact';
}
$img = NULL;

$sExtension = strtolower(end(explode('.', $file)));
if ($sExtension == 'jpg' || $sExtension == 'jpeg')
{
	$img = @imagecreatefromjpeg($file) or die("Cannot create new JPEG image");
}
else if($sExtension == 'png')
{
	$img = @imagecreatefrompng($file) or die("Cannot create new PNG image");
}
else if($sExtension == 'gif')
{
	$img = @imagecreatefromgif($file) or die("Cannot create new GIF image");
}
if($img)
{
	$iOrigWidth = imagesx($img);
	$iOrigHeight = imagesy($img);
	if($sType == 'scale') 
	{
		$fScale = min($width_max/$iOrigWidth,
    	$height_max/$iOrigHeight);
		if ($fScale < 1) 
		{
			$iNewWidth = floor($fScale*$iOrigWidth);
			$iNewHeight = floor($fScale*$iOrigHeight);
			$tmpimg = imagecreatetruecolor($iNewWidth,$iNewHeight);
			imagecopyresampled($tmpimg, $img, 0, 0, 0, 0,$iNewWidth, $iNewHeight, $iOrigWidth, $iOrigHeight);
			imagedestroy($img);
			$img = $tmpimg;
		}
	}
	else if ($sType == "exact") 
	{
		$fScale = max($width_thumb/$iOrigWidth,$height_thumb/$iOrigHeight);
		if ($fScale < 1) 
		{
			$iNewWidth = floor($fScale*$iOrigWidth);
			$iNewHeight = floor($fScale*$iOrigHeight);
			$tmpimg = imagecreatetruecolor($iNewWidth,$iNewHeight);
			$tmp2img = imagecreatetruecolor($width_thumb,$height_thumb);
			imagecopyresampled($tmpimg, $img, 0, 0, 0, 0,$iNewWidth, $iNewHeight, $iOrigWidth, $iOrigHeight);
			if ($iNewWidth == $width_thumb) 
			{
				$yAxis = ($iNewHeight/2)-($height_thumb/2);
				$xAxis = 0;
			}
			else if ($iNewHeight == $height_thumb)  
			{
				$yAxis = 0;
				$xAxis = ($iNewWidth/2)-($width_thumb/2);
			} 
			imagecopyresampled($tmp2img,$tmpimg,0,0,$xAxis, $yAxis,$width_thumb,$height_thumb,$width_thumb,$height_thumb);
			imagedestroy($img);
			imagedestroy($tmpimg);
			$img = $tmp2img;
		}
	}
	header("Content-type: image/jpeg");
	imagejpeg($img);
}
?>