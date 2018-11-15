<?php

/**
 * php生成excel简单封装
 *
 */
class ExcelModel extends ModelBase
{
    private $x = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');


    /**
     * 将数组以excel方式发送到客户端
     *
     * @return void
     */
    public static function sentExcelFile($data, $header = null, $fileName = '运营分析报表')
    {
        Header("Content-type:application/octet-stream ");
        Header("Accept-Ranges:bytes ");
        header("Content-Disposition:attachment;filename=" . iconv('UTF-8', 'GB2312', $fileName . '.xls'));
        echo '<?xml version="1.0" encoding="UTF-8"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">';
        echo "<Worksheet ss:Name=\"全服\">\n";
        echo "<Table>\n";
        if ($header) {
            //输出头部
            foreach ($data as $row) {
                echo '<Row>';
                foreach ($header as $item) {
                    echo '<Cell><Data ss:Type="String">' . $item . '</Data></Cell>';
                }
                echo '</Row>';
            }
            $header = array_keys($header);
            foreach ($data as $v) {
                echo '<Row>';
                foreach ($header as $key) {
                    echo '<Cell><Data ss:Type="String">' . $v[$key] . '</Data></Cell>';
                }
                echo '</Row>';
            }
        } else {
            foreach ($data as $row) {
                echo '<Row>';
                foreach ($row as $item) {
                    echo '<Cell><Data ss:Type="String">' . $item . '</Data></Cell>';
                }
                echo '</Row>';
            }
        }

        echo "</Table>\n";
        echo "</Worksheet>\n";
        echo "</Workbook>";
    }

    //发送头部
    public static function sentHeader($header = array())
    {
        Header("Content-type:application/octet-stream ");
        Header("Accept-Ranges:bytes ");
        header("Content-Disposition:attachment;filename=" . iconv('UTF-8', 'GB2312', '运营分析报表.xls'));
        echo '<?xml version="1.0" encoding="UTF-8"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">';
        echo "<Worksheet ss:Name=\"导出数据\">\n";
        echo "<Table>\n";

        if ($header) {
            //输出头部
            echo '<Row>';
            foreach ($header as $item) {
                echo '<Cell><Data ss:Type="String">' . $item . '</Data></Cell>';
            }
            echo '</Row>';
        }
    }

    //发送数据
    public static function sentData($row)
    {
        echo '<Row>';
        foreach ($row as $item) {
            if (is_numeric($item)) {
                echo '<Cell><Data ss:Type="Number">' . $item . '</Data></Cell>';
            } else {
                echo '<Cell><Data ss:Type="String">' . $item . '</Data></Cell>';
            }
        }
        echo '</Row>';
    }

    //发送尾部
    public static function sentEnd()
    {
        echo "</Table>\n";
        echo "</Worksheet>\n";
        echo "</Workbook>";
    }

}
 
