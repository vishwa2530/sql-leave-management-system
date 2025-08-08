<?php
require 'vendor/autoload.php';
include 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'User');
$sheet->setCellValue('B1', 'Start Date');
$sheet->setCellValue('C1', 'End Date');
$sheet->setCellValue('D1', 'Reason');
$sheet->setCellValue('E1', 'Status');

$query = "SELECT l.*, u.name FROM leaves l JOIN users u ON l.user_id=u.id";
$result = mysqli_query($conn, $query);
$rowCount = 2;

while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowCount, $row['name']);
    $sheet->setCellValue('B' . $rowCount, $row['start_date']);
    $sheet->setCellValue('C' . $rowCount, $row['end_date']);
    $sheet->setCellValue('D' . $rowCount, $row['reason']);
    $sheet->setCellValue('E' . $rowCount, $row['status']);
    $rowCount++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'leave_report.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$writer->save("php://output");
?>
