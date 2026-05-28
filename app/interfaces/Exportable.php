<?php
interface Exportable {
    public function exportToExcel($data, $filename);
    public function exportToPdf($data, $filename);
}
