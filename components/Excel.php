<?php
namespace app\components;

class Excel {
    public static function generateMultisheet($data = []) {
        require 'components/excel/vendor/autoload.php';

        $filename = 'storage/excel/multilang-export-' . time() . '.xlsx';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $sheetIndex = 0;
        foreach ($data as $sheetName => $sheetData) {
            $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $sheetName);
            $spreadsheet->addSheet($myWorkSheet, $sheetIndex);
            $sheetIndex += 1;

            $sheet = $myWorkSheet;
            $data = $sheetData;

            $spreadsheet->setActiveSheetIndex($sheetIndex - 1);

            $all = [];
            if (count($data) === 0) {
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $writer->save($filename);
                return $filename;
            }

            $columns = [];
            foreach ($data[0] as $key => $_) {
                $columns[] = $key;
            }
            $all[] = $columns;

            foreach ($data as $item) {
                $row = [];
                foreach ($item as $k => $v) {
                    $row[] = $v;
                }
                $all[] = $row;
            }

            for ($line = 1; $line <= count($all); $line += 1) {
                $row = $all[$line - 1];
                for ($column = ord('A'), $i = 0; $column <= 26, $i < 26; $column += 1, $i += 1) {
                    $sheet->setCellValue(chr($column) . strval($line), strval($row[$i] ?? ''));
                }
            }

        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filename);
        return $filename;
    }

    public static function generate($data = []) {
        require 'components/excel/vendor/autoload.php';

        $filename = 'storage/excel/multilang-export-' . time() . '.xlsx';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $all = [];
        if (count($data) === 0) {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($filename);
            return $filename;
        }

        $columns = [];
        foreach ($data[0] as $key => $_) {
            $columns[] = $key;
        }
        $all[] = $columns;

        foreach ($data as $item) {
            $row = [];
            foreach ($item as $k => $v) {
                $row[] = $v;
            }
            $all[] = $row;
        }

        for ($line = 1; $line <= count($all); $line += 1) {
           $row = $all[$line - 1];
           for ($column = ord('A'), $i = 0; $column <= 26, $i < 26; $column += 1, $i += 1) {
               $sheet->setCellValue(chr($column) . strval($line), strval($row[$i] ?? ''));
           }
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filename);
        return $filename;
    }
}