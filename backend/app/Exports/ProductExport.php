<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ProductExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithTitle, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $selectedColumns;

    public function __construct($selectedColumns)
    {
        $this->selectedColumns = $selectedColumns;
    }
    public function collection()
    {
        $query = Product::query();

        // Áp dụng lọc cột dựa trên các cột đã chọn
        if (!empty($this->selectedColumns)) {
            $query->select($this->selectedColumns);
        }

        return $query->get();
    }

    public function headings(): array
    {
        $columnNamesInVietnamese = [
            'id' => 'ID sản phẩm',
            'category_id' => 'Mã danh mục',
            'code' => 'Mã sản phẩm',
            'name' => 'Tên sản phẩm',
            'short_description' => 'Mô tả ngắn',
            'content' => 'Mô tả chi tiết',
            'price_regular' => 'Giá sản phẩm (VNĐ)',
            'price_sale' => 'Giá giảm (VNĐ)',
            'stock' => 'Số lượng tồn kho',
            'rating' => 'Điểm đánh giá',
            'warranty_period' => 'Thời gian bảo hành (tháng)',
            'view' => 'Số lượt xem',
            'buycount' => 'Số lượt mua',
            'wishlistscount' => 'Số lượt yêu thích',
            'is_active' => 'Cờ kích hoạt sản phẩm',
            'is_hot_deal' => 'Trạng thái hot của sản phẩm',
            'is_show_home' => 'Trạng thái hiển thị ra màn hình chủ',
            'is_new' => 'Trạng thái sản phẩm mới',
            'is_good_deal' => 'Trạng thái tốt của sản phẩm',
            'slug' => 'Slug của sản phẩm',
            'meta_title' => 'Tiêu đề SEO của sản phẩm',
            'meta_description' => 'Mô tả SEO của sản phẩm',
            'deleted_at' => 'Ngày xóa (sản phẩm)',
            'deleted_by' => 'Người xóa (sản phẩm)',
            'created_at' => 'Ngày tạo (sản phẩm)',
            'updated_at' => 'Ngày cập nhật (sản phẩm)',
        ];
    
        // Trả về tiêu đề cột (bao gồm STT và các tên cột đã chọn)
        return array_merge(['STT'], array_map(function($column) use ($columnNamesInVietnamese) {
            return $columnNamesInVietnamese[$column] ?? ucfirst(str_replace('_', ' ', $column));
        }, $this->selectedColumns));
    }

    public function map($product): array
    {
        static $index = 0;
        $index++;

        $data = [$index];
        foreach ($this->selectedColumns as $column) {
            // Kiểm tra nếu cột tồn tại trong đối tượng $product, sau đó lấy giá trị
            $value = $product->$column ?? '';

           // Định dạng giá tiền (VD: price_regular, price_sale)
            if (in_array($column, ['price_regular', 'price_sale'])) {
                // Chuyển giá trị thành float để đảm bảo là số
                $value = (float) $value;
                
                // Kiểm tra nếu giá trị hợp lệ cho price_sale (có thể là null hoặc rỗng)
                if ($column === 'price_sale' && ($value == null)) {
                    // Nếu là price_sale và giá trị null hoặc 0, thì không hiển thị gì
                    $value = ' ';
                } elseif ($value !== null && is_numeric($value)) {
                    // Định dạng giá dưới dạng số tiền (VNĐ) chỉ nếu giá trị hợp lệ
                    $value = number_format($value, 0, ',', '.') . ' VNĐ';
                } else {
                    // Nếu giá trị không hợp lệ cho price_regular (không phải số)
                    $value = null;
                }
            }

            // Định dạng ngày tháng (VD: created_at, updated_at, deleted_at)
            if (in_array($column, ['created_at', 'updated_at', 'deleted_at'])) {
                // Kiểm tra nếu giá trị là ngày hợp lệ và định dạng lại theo 'Y-m-d'
                if ($value instanceof Carbon) {
                    $value = $value->format('d/m/Y');
                } else {
                    $value = ''; // Nếu không phải là ngày hợp lệ, để trống
                }
            }

            // Định dạng cho các trường có tiền tố 'is_' (ví dụ: is_active, is_hot_deal, ...)
            if (strpos($column, 'is_') === 0) {
                // Kiểm tra giá trị boolean và chuyển đổi thành "Có" hoặc "Không"
                $value = $value ? '1' : '0';
            }

            // Thêm giá trị vào mảng dữ liệu
            $data[] = $value;
        }

        return $data;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // STT 
            'B' => 15,  // ID sản phẩm
            'C' => 15,  // Mã danh mục
            'D' => 15,  // Mã sản phẩm
            'E' => 25,  // Tên sản phẩm
            'F' => 30,  // Mô tả ngắn
            'G' => 50,  // Mô tả chi tiết
            'H' => 20,  // Giá sản phẩm (VNĐ)
            'I' => 20,  // Giá giảm (VNĐ)
            'J' => 20,  // Số lượng tồn kho
            'K' => 20,  // Điểm đánh giá
            'L' => 25,  // Thời gian bảo hành (tháng)
            'M' => 20,  // Số lượt xem
            'N' => 20,  // Số lượng lượt mua
            'O' => 20,  // Số lượng lượt yêu thích
            'P' => 20,  // Cờ kích hoạt sản phẩm
            'Q' => 25,  // Trạng thái hot của sản phẩm
            'R' => 30,  // Trạng thái hiển thị ra màn hình chủ
            'S' => 25,  // Trạng thái sản phẩm mới
            'T' => 25,  // Trạng thái tốt của sản phẩm
            'U' => 30,  // Slug của sản phẩm
            'V' => 25,  // Tiêu đề SEO của sản phẩm
            'W' => 30,  // Mô tả SEO của sản phẩm
            'X' => 20,  // Ngày xóa (sản phẩm)
            'Y' => 20,  // Người xóa (sản phẩm)
            'Z' => 20,  // Ngày tạo (sản phẩm)
            'AA' => 25, // Ngày cập nhật (sản phẩm)
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        // Căn giữa các tiêu đề (dòng 1)
        $sheet->getRowDimension(1)->setRowHeight(20);  // Thiết lập chiều cao cho dòng tiêu đề (tùy chỉnh)
        foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA'] as $column) {
            $sheet->getStyle($column . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column . '1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn giữa các ô số (bắt đầu từ hàng 2 trở đi)
        foreach (['A', 'B', 'C', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn trái các ô chữ (bắt đầu từ hàng 2 trở đi)
        foreach (['D', 'E', 'F', 'G', 'U', 'V', 'W'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn phải các ô giá (bắt đầu từ hàng 2 trở đi)
        foreach (['H', 'I'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn phải các ô ngày (bắt đầu từ hàng 2 trở đi)
        foreach (['X', 'Z', 'AA'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Tự động căn chỉnh độ rộng cột
        foreach (range('A', 'AA') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }

    // Đặt tiêu đề cho sheet
    public function title(): string
    {
        return 'Danh sách sản phẩm';
    }

}
