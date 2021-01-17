<?php
/**
 * resource.php
 *
 * @author: aida
 * @version: 2019-03-16 14:21:33
 */

//$config['base_url'] = 'http://zukan.cloud/';
$config['base_url'] = 'https://zukan.cloud/';
// アップ用のディレクトリ
$config['file_upload_dir'] = '/var/www/zukanprj/html/files/';
$config['apos_upload_dir'] = '/var/www/zukanprj/html/apos/';

$config['api_type_add_id'] = 9;

$config['app_sv_maintenance_mode'] = 0;// 0,OFF 1,ON
$config['app_sv_maintenance_redirect_url'] = 'https://www.zukan.cloud/mente.php';// メンテページURL

// メンテ対象外IP
$config['maintenance_staff_ip_array'] = array(
    '202.171.150.14', // 亀有
    '124.146.213.241', // avex
);
