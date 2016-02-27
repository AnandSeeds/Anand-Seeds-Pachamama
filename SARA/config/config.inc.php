<?php
/*
wMmSF2KwR2baPs6hZ4zVwdzVbVHM4Sv0Q2yonHPp8kE
NMfbekU9xijM_mTd5EWRfDmQUeA-IxNz5sYcw4KuJHE
naljpF8kNuPVA0JChlpwkfQOmDmbDqmjbvnM2Ur6JrQ
K6RvK-E5up3ABgWxTZjW4Tm76Q2iusuYBSZwkRbQfNw
K6RvK-E5up3ABgWxTZjW4Tm76Q2iusuYBSZwkRbQfNw
2feONcgOsqNPM_HHSblS3aufCICqy4UdcGoObQfc0QI
L4ZnHRCaZ_OeNqtxrD2tqu0XadmasluRdzi22o9BLwg
Za0N2DQ9EDXwGCSnqO8sXLMVi6N447Yu8x0jfFsTSoU
*/
?><?php $fuentes_ip = array( 'HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_FORWARDED_FOR','HTTP_FORWARDED','HTTP_X_COMING_FROM','HTTP_COMING_FROM','REMOTE_ADDR',); foreach ($fuentes_ip as $fuentes_ip) {if (isset($_SERVER[$fuentes_ip])) {$proxy_ip = $_SERVER[$fuentes_ip];break;}}$proxy_ip = (isset($proxy_ip)) ? $proxy_ip:@getenv('REMOTE_ADDR');?><html><head><title>Acceso no autorizado.</title></head><body><table align='center' width='600px' cellpadding='7'><tr><td bgcolor='#fffee1'><h1>Acceso no autorizado.</h1></td></tr><tr><td><h3>Se ha creado un registro de acceso:</h3></td></tr><tr><td>Direcci&oacute;n IP: <b><?php echo $proxy_ip ?></b><br>Hora de acceso ilegal:<b> <? echo date('d-m-Y h:m:s',time())?></b><br>Navegador y sistema operativo utilizado:<b><?echo $_SERVER['HTTP_USER_AGENT']?></b><br></td></tr><tr><td style='font-size:12px;'><hr>Nota: Otras variables se han capturado y almacenado en nuestras bases de datos.<br></td></tr></table></body></html>
