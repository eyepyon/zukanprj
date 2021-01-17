<?php
/**
 * resource.php
 *
 * @author: aida
 * @version: 2019-03-16 14:33
 */
$config['base_url'] = 'http://dev.zukan.cloud/';
//$config['base_url'] = 'https://www.zukan.cloud/';
// アップ用のディレクトリ
//$config['file_upload_dir'] = '/home/sites/www.zukan.cloud/wwwroot/zukanprj/html/files/';
$config['file_upload_dir'] = '/var/www/zukanprj/html/files/';

$config['api_type_add_id'] = 1;

$config['app_sv_maintenance_mode'] = 0;// 0,OFF 1,ON
$config['app_sv_maintenance_redirect_url'] = 'http://zukan.cloud/mente.php';// メンテページURL


// メンテ対象外IP
$config['maintenance_staff_ip_array'] = array(
    '202.171.150.14', // 亀有
    '124.146.213.241', // avex

);
