<?php

namespace classes;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Classe para manipulação de planilhas.
 * CSV, ODT, XLSX
 * Estudar documentação:
 * https://phpspreadsheet.readthedocs.io/en/latest/#welcome-to-phpspreadsheets-documentation
 */
class Planilha
{

	/**
	 * Função modelo.
	 * Recebe um valor, trata e retorna.
	 *
	 * @return void
	 */
	public static function teste()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');

		$writer = new Xlsx($spreadsheet);
		$writer->save('hello world.xlsx');

		// Retorna o resultado.
		return $r;
	}


}
