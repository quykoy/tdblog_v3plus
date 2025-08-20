<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */
 
if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class java {

    protected $fileJava;
    protected $configs;

    function __construct($fileJava)
    {
        $this->fileJava = str_replace(base_url(), __SITE_PATH, $fileJava);
        $this->configs = parse_ini_file(__SYSTEMS_PATH . '/ini/java.ini', true);
    }

    public function addLogo()
    {
        $thoigian_nen = 3000;
        $thoigian_mid = 9000;
        $maunen       = 'ffffff';
        $amluong      = 80;
        $logo_java    = base_url().'/publics/images/logo.png';

        chdir(__SYSTEMS_PATH.'/files/java');
        if ($logo_java && $logo_java != 'http://') {
            copy($logo_java, 'logo/tubotocdo.gif');
        }

        $zip = new ZipArchive();
        if ($zip->open($this->fileJava) === TRUE) {
            $zip1 = zip_open($this->fileJava);
            if ($zip1) {
                while ($entry3 = zip_read($zip1)) {
                    $name  = zip_entry_name($entry3);
                    $size3 = zip_entry_filesize($entry3);
                    $nd    = zip_entry_read($entry3, $size3);
                    $nd    = str_replace(chr(32) . 'javax/microedition/midlet/MIDlet', chr(17) . 'tubotocdo/NhacNen', $nd);
                    $zip->addFromString($name, $nd);
                }
            }
            zip_close($zip1);
            $zip->addFile('tubotocdo/NhacNen.class');
            $zip->addFile('tubotocdo/Logo.class');
            $zip->addFile('logo/tubotocdo.gif');
            //$zip->addFromString('tubotocdo.txt', 'Wapsite đa tiện ích');
            $zip->close();
            $zip2 = new ZipArchive();
            if ($zip2->open($this->fileJava) === TRUE) {
                $noidung = $zip2->getFromName('META-INF/MANIFEST.MF');
                $caidac  = "Thoigian_Nen: " . $thoigian_nen . "\nMaunen: " . $maunen . "\nThoigian_Mid: " . $thoigian_mid . "\nAmluong: " . $amluong .  "\n" . $noidung;
                $zip2->addFromString('META-INF/MANIFEST.MF', $caidac);
                $zip2->close();
            }
            show_alert(1, array('đóng dấu bản quyền thành công'));
        } else {
            show_alert(2, array('đóng dấu bản quyền thất bại'));
        }
    }

    public function addText() {
        $vendor = base_url();
        $desc = "Tải nhiều hơn tại ".base_url();
        $info = base_url();
        $del = "truy cập ".base_url().' để tả nhiều game hơn';
        $zip = new ZipArchive();

        if ($zip->open($this->fileJava) === TRUE) {
            $open = zip_open($this->fileJava);
            if ($open) {
                while ($entry = zip_read($open)) {
                    $name = zip_entry_name($entry);
                    $size = zip_entry_filesize($entry);
                    if ($name == 'META-INF/MANIFEST.MF') {
                        $content = zip_entry_read($entry, $size);
                        $content = preg_replace("/MIDlet-Delete-Confirm:(.*?)\n/is", "MIDlet-Delete-Confirm: ".$this->configs['Delete-Confirm']."\n", $content);
                        $content = preg_replace("/MIDlet-Info-URL:(.*?)\n/is", "MIDlet-Info-URL: ".$this->configs['Info-URL']."\n", $content);
                        $content = preg_replace("/MIDlet-Description:(.*?)\n/is", "MIDlet-Description: ".$this->configs['Description']."\n", $content);
                        $content = preg_replace("/MIDlet-Vendor:(.*?)\n/is", "MIDlet-Vendor: ".$this->configs['Vendor']."\n", $content);
                        $content = trim($content) . "\n";
                        if (!preg_match("/MIDlet-Delete-Confirm:/is", $content)) $content = $content . "MIDlet-Delete-Confirm: ".$this->configs['Delete-Confirm']."\n";
                        if (!preg_match("/MIDlet-Description:/is", $content)) $content = $content . "MIDlet-Description: ".$this->configs['Description']."\n";
                        if (!preg_match("/MIDlet-Vendor:/is", $content)) $content = $content . "MIDlet-Vendor: ".$this->configs['Vendor']."\n";
                        if (!preg_match("/MIDlet-Info-URL:/is", $content)) $content = $content . "MIDlet-Info-URL: ".$this->configs['Info-URL']."\n";
                        $content = str_replace("\n\n\n", "\n", $content);
                        $content = str_replace("\n\n", "\n", $content);
                        $zip->addFromString($name, $content);
                    }
                }
            }

            zip_close($open);
        }

        $zip->close();
        show_alert(1, array('đóng dấu bản quyền thành công'));
    }
    
}