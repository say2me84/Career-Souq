<?php
	require_once(PDF_URL."dompdf_config.inc.php");
	spl_autoload_register('DOMPDF_autoload');
	function pdf_create($html, $filename, $paper, $orientation, $stream=TRUE)
	{
		$dompdf = new DOMPDF();
		$dompdf->set_paper($paper,$orientation);
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream($filename.".pdf");
	}
	$filename = 'Resume_PDF';
	$dompdf = new DOMPDF();
	$html = file_get_contents(APPLICATION_PATH."dashboard/index"); 
	pdf_create($html,$filename,'A4','portrait');
?>