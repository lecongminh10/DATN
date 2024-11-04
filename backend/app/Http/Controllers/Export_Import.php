<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view("admin.export-import.import.import-category");
    }

    public function importProduct() {
        return view("admin.export-import.import.import-product");
    }

    public function importPost() {
        return view("admin.export-import.import.import-post");
    }
}
