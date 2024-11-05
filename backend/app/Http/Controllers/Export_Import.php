<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Export_Import extends Controller
{
    public function exportAndImport() {
        return view("admin.export-import.export_import");
    }

    public function exportCategory() {
        return view("admin.export-import.export.export-category");
    }

    public function exportProduct() {
        return view("admin.export-import.export.export-product");
    }

    public function exportPost() {
        return view("admin.export-import.export.export-post");
    }

    public function importCategory() {
        $tableName = 'categories';

        // Lấy danh sách các cột và kiểu dữ liệu của bảng
        $columnsCategory = DB::connection()->getDoctrineSchemaManager()->listTableColumns($tableName);
        
        // Khởi tạo một mảng để lưu trữ tên và kiểu dữ liệu của các cột
        $columnsData = [];

        foreach ($columnsCategory as $column) {
            $columnsData[] = [
                'name' => $column->getName(),
                'type' => $column->getType()->getName(),
                'comments' => $column->getComment(),
            ];
        }

        // Truyền dữ liệu cột tới view
        return view('admin.export-import.import.import-category', compact('columnsData'));
    }

    public function importProduct() {
        $tableName = 'products';

        // Lấy danh sách các cột và kiểu dữ liệu của bảng
        $columnsProduct = DB::connection()->getDoctrineSchemaManager()->listTableColumns($tableName);
        
        // Khởi tạo một mảng để lưu trữ tên và kiểu dữ liệu của các cột
        $columnsData = [];

        foreach ($columnsProduct as $column) {
            $columnsData[] = [
                'name' => $column->getName(),
                'type' => $column->getType()->getName(),
                'comments' => $column->getComment(),
            ];
        }
        return view("admin.export-import.import.import-product", compact('columnsData'));
    }

    public function importPost() {
        $tableName = 'posts';

        // Lấy danh sách các cột và kiểu dữ liệu của bảng
        $columnsPosts = DB::connection()->getDoctrineSchemaManager()->listTableColumns($tableName);
        
        // Khởi tạo một mảng để lưu trữ tên và kiểu dữ liệu của các cột
        $columnsData = [];

        foreach ($columnsPosts as $column) {
            $columnsData[] = [
                'name' => $column->getName(),
                'type' => $column->getType()->getName(),
                'comments' => $column->getComment(),
            ];
        }
        return view("admin.export-import.import.import-post", compact('columnsData'));
    }
}
