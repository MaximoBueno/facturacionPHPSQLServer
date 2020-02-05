<?php
session_start();
if(isset($_SESSION['ns_my_imprimir']) && isset($_POST['surface_nc'])){

    $surface_numero_boleta = $_SESSION['ns_my_imprimir'];
    $surface_nombreCompleto = $_POST['surface_nc'];

    require("./../../aclases/libs/html2pdf/html2pdf.class.php");
    header("Content-Type: text/html;charset=utf-8");
    try {
        ob_start();
        include ('./plantillaBoleta.php');
        $content = ob_get_clean();
        $pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8');
        //$pdf = new HTML2PDF('L', 'A4', 'es', true, 'UTF-8');
        $pdf->writeHTML($content);
        $pdf->Output($surface_numero_boleta.'.pdf');
    } catch (Html2PdfException $e) {
        $pdf->clean();
        $formatter = new ExceptionFormatter($e);
        echo $formatter->getHtmlMessage();
    }
}else{
    echo "No tiene acceso";
}
?>