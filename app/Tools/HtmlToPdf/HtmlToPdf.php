<?php

namespace App\Tools\HtmlToPdf;

use App\Tools\QiNiu\QiNiu;
use Dompdf\Dompdf;

class HtmlToPdf
{
    protected $qiNiu;

    /**
     * 依赖注入
     * RemindServices constructor.
     */
    public function __construct
    (
        QiNiu $qiNiu
    )
    {
        $this->qiNiu = $qiNiu;
    }

    /**
     * 把HTML转成PDF
     *
     * @param $html
     * @param int $action 1 上传到七牛 2 直接下载
     * @return mixed
     * @author renqingbin
     */
    public function htmlToPdf($html, $name, $action = 1, $backet = "zzgerp")
    {
        // 上传的名字前加上公司标识
        if($GLOBALS['database']){
            $name = $GLOBALS['database'].'/'.$name.'.pdf';
        }
        $dompdf = new Dompdf();
        // 获取HTML
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // 判断是直接上传还是下载
        if($action == 1){
            // 上传到七牛
            $uploadResult = $this->qiNiu->uploadContent($name, $dompdf->output(), $backet);
            return $uploadResult;
        }else{
            // Output the generated PDF to Browser
            return $dompdf->stream();
        }
    }
}
