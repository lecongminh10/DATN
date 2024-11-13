<?php

namespace App\Http\Controllers;

use App\Exports\ProductsAndVariantsExport;
// use App\Exports\ProductsExport;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Exports\CategoriesExport;
use App\Exports\PostsExport;
use App\Imports\CategoriesImport;
use App\Imports\PostsImport;
use App\Imports\ProductsImport;
use App\Imports\VariationsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\ProductExport;

class ExportImportController extends Controller
{
    public function exportAndImport()
    {
        return view("admin.export-import.export_import");
    }

    public function exportCategory()
    {
        $countCategory = Category::count();
        $tableName = 'categories';

        // Lấy danh sách các cột và kiểu dữ liệu của bảng
        $columnsCategory = DB::connection()->getDoctrineSchemaManager()->listTableColumns($tableName);

        // Khởi tạo một mảng để lưu trữ tên và kiểu dữ liệu của các cột
        $columnsData = [];

        foreach ($columnsCategory as $column) {
            $columnsData[] = [
                'name' => $column->getName(),
            ];
        }
        return view("admin.export-import.export.export-category", compact('countCategory', 'columnsData'));
    }

    public function exportCategories(Request $request)
    {
        $selectedColumns = $request->input('columns'); // Nhận cột đã chọn từ request
        return Excel::download(new CategoriesExport($selectedColumns), 'categories.xlsx');
    }

    public function exportProduct()
    {
        $countProduct = Product::count(); // Tổng sản phẩm 
        $countProductVariants = ProductVariant::count(); // Tổng sản phẩm biến thể
        $sumProduct = $countProduct + $countProductVariants; // Tổng tất cả sản phẩm

        // Lấy danh sách các cột và kiểu dữ liệu của bảng products
        $columnsProduct = DB::connection()->getDoctrineSchemaManager()->listTableColumns('products');

        $columnsDataPro = [];

        foreach ($columnsProduct as $column) {
            $columnsDataPro[] = [
                'name' => $column->getName(),
            ];
        }

        // Trả về view với các dữ liệu đã xử lý
        return view("admin.export-import.export.export-product")->with(
            [
                'countProduct' => $countProduct,
                'countProductVariants' => $countProductVariants,
                'sumProduct' => $sumProduct,
                'columnsDataPro' => $columnsDataPro,
            ]
        );
    }
    private function selectedValue($input)
    {

        $data = [];
        foreach ($input as $item) {
            foreach ($item as $key => $val) {
                if ($val == 'on') {
                    $data[] = $key;
                }
            }
        }
        return $data;
    }

    public function exportProducts(Request $request)
    {
        $selectedRequetPro = $request->input('product');
        $selectedProductVariantFields = $request->input('product_variant');

        $selectedColumnsPro = $this->selectedValue($selectedRequetPro);
        $selectedColumnsPro_Variant = $this->selectedValue($selectedProductVariantFields);

        // Truyền các cột đã chọn vào export
        return Excel::download(new ProductsAndVariantsExport($selectedColumnsPro, $selectedColumnsPro_Variant), 'products_and_variants.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportPost()
    {
        $countPost = Post::count();
        $tableName = 'posts';

        // Lấy danh sách các cột và kiểu dữ liệu của bảng
        $columnsPost = DB::connection()->getDoctrineSchemaManager()->listTableColumns($tableName);

        // Khởi tạo một mảng để lưu trữ tên và kiểu dữ liệu của các cột
        $columnsData = [];

        foreach ($columnsPost as $column) {
            $columnsData[] = [
                'name' => $column->getName(),
            ];
        }
        return view("admin.export-import.export.export-post", compact('countPost', 'columnsData'));
    }

    public function exportPosts(Request $request)
    {
        $selectedColumns = $request->input('columns'); // Nhận cột đã chọn từ request
        return Excel::download(new PostsExport($selectedColumns), 'posts.xlsx');
    }

    public function importCategory()
    {
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

    public function importCategories(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        try {
            // Ghi log khi nhập
            // Log::info("Bắt đầu nhập dữ liệu từ tệp: " . $fileName);

            Excel::import(new CategoriesImport, $file);

            // Ghi log khi thành công
            // Log::info("Dữ liệu đã được nhập thành công từ tệp: " . $fileName);

            return response()->json(['success' => true, 'message' => 'Dữ liệu đã được nhập thành công!']);
        } catch (\Exception $e) {
            // Ghi log khi gặp lỗi
            // Log::error("Lỗi khi nhập dữ liệu từ tệp: " . $fileName, ['error' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi nhập dữ liệu.']);
        }
    }

    private function setValueColumnVariantFormatted()
    {
        return [
            [
                "name" => "id",
                "type" => "bigint",
                "comments" => "Mã định danh của sản phẩm biến thể"
            ],
            [
                "name" => "product_id",
                "type" => "bigint",
                "comments" => "Mã định danh của sản phẩm chính"
            ],
            [
                "name" => "price_modifier",
                "type" => "decimal",
                "comments" => "Giá thay đổi của biến thể, áp dụng cho từng sản phẩm"
            ],
            [
                "name" => "original_price",
                "type" => "decimal",
                "comments" => "Giá gốc của sản phẩm biến thể"
            ],
            [
                "name" => "stock",
                "type" => "int",
                "comments" => "Số lượng của sản phẩm biến thể có sẵn trong kho"
            ],
            [
                "name" => "sku",
                "type" => "string",
                "comments" => "Mã SKU của sản phẩm biến thể, dùng để nhận dạng trong hệ thống"
            ],
            [
                "name" => "status",
                "type" => "enum",
                "comments" => "Trạng thái hiện tại của sản phẩm biến thể (ví dụ: đang bán, ngừng bán)"
            ],
            [
                "name" => "variant_image",
                "type" => "string",
                "comments" => "Hình ảnh mô tả sản phẩm biến thể"
            ],
            [
                "name" => "deleted_at",
                "type" => "datetime",
                "comments" => "Ngày mà sản phẩm biến thể bị xóa"
            ],
            [
                "name" => "deleted_by",
                "type" => "bigint",
                "comments" => "Tên người thực hiện xóa sản phẩm biến thể"
            ],
            [
                "name" => "created_at",
                "type" => "datetime",
                "comments" => "Ngày mà sản phẩm biến thể được tạo ra"
            ],
            [
                "name" => "updated_at",
                "type" => "datetime",
                "comments" => "Ngày mà sản phẩm biến thể được cập nhật lần cuối"
            ]
        ];
    }

    public function importProduct()
    {
        $tableName = 'products';
        $tableNameVariant = "product_variants";

        // Lấy danh sách các cột và kiểu dữ liệu của bảng
        $columnsProduct = DB::connection()->getDoctrineSchemaManager()->listTableColumns($tableName);

        $columnsData = [];

        foreach ($columnsProduct as $column) {
            $columnsData[] = [
                'name' => $column->getName(),
                'type' => $column->getType()->getName(),
                'comments' => $column->getComment(),
            ];
        }

        $columnsDataVariant = $this->setValueColumnVariantFormatted();
        return view("admin.export-import.import.import-product", compact('columnsData', 'columnsDataVariant'));
    }

    public function importProducts(Request $request)
    {
        // Xác nhận yêu cầu
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',  // Kiểm tra tệp hợp lệ
            'import-type' => 'required|in:products,product_variants',  // Kiểm tra loại nhập
        ]);


        $file = $request->file('file');  // Lấy tệp
        $importType = $request->input('import-type');  // Lấy loại nhập (sản phẩm hoặc biến thể)
            // Log::info('Loại tệp tải : ' . $importType);
        // dd($importType);

        try {
            // Log::info('Bắt đầu nhập dữ liệu từ tệp: ' . $file->getClientOriginalName());

            // Nhập liệu theo loại đã chọn
            if ($importType === 'products') {
                Excel::import(new ProductsImport, $file);  // Nhập sản phẩm
            }

            if ($importType === 'product_variants') {
                Excel::import(new VariationsImport, $file);  // Nhập biến thể sản phẩm
            }

            // Log::info('Dữ liệu đã được nhập thành công từ tệp: ' . $file->getClientOriginalName());

            return response()->json([
                'success' => true,
                'message' => 'Dữ liệu đã được nhập thành công!'
            ]);
        } catch (\Exception $e) {
            // Log::error('Có lỗi xảy ra khi nhập dữ liệu từ tệp: ' . $file->getClientOriginalName(), [
            //     'error' => $e->getMessage(),
            // ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi nhập dữ liệu: ' . $e->getMessage()
            ]);
        }
    }


    public function importPost()
    {
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

    public function importPosts(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        try {
            // Ghi log khi bắt đầu nhập dữ liệu
            // Log::info('Bắt đầu nhập dữ liệu từ tệp: ' . $file->getClientOriginalName());

            // Import dữ liệu từ tệp vào database
            Excel::import(new PostsImport, $file);

            // Ghi log khi nhập thành công
            // Log::info('Dữ liệu đã được nhập thành công từ tệp: ' . $file->getClientOriginalName());

            return response()->json([
                'success' => true,
                'message' => 'Dữ liệu đã được nhập thành công!'
            ]);
        } catch (\Exception $e) {
            // Ghi log khi có lỗi xảy ra
            // // Log::error('Có lỗi xảy ra khi nhập dữ liệu từ tệp: ' . $file->getClientOriginalName(), [
            //     'error' => $e->getMessage(),
            //     'file' => $file->getClientOriginalName()
            // ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi nhập dữ liệu: ' . $e->getMessage()
            ]);
        }
    }
}
