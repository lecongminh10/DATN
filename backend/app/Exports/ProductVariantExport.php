<?php

namespace App\Exports;

use App\Models\ProductVariant;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ProductVariantExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithTitle, WithStyles
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
        $query = ProductVariant::query();

        // Áp dụng lọc cột dựa trên các cột đã chọn
        if (!empty($this->selectedColumns)) {
            $query->select($this->selectedColumns);
        }

        return $query->get();
    }

    public function headings(): array
    {
        // return array_merge(['STT'], array_map(function($column) {
        //     return ucfirst(str_replace('_', ' ', $column));
        // }, $this->selectedColumns));

        $columnNamesInVietnamese = [
            'id' => 'ID sản phẩm biến thể',
            'product_id ' => 'Mã sản phẩm',
            'price_modifier' => 'Giá thay đổi do biến thể (VNĐ)',
            'original_price' => 'Giá gốc của biến thể (VNĐ)',
            'stock' => 'Số lượng tồn kho của biến thể	',
            'sku' => '	Mã SKU của biến thể',
            'status' => 'Trạng thái của biến thể',
            'variant_image' => 'Ảnh của biến thể sản phẩm',
            'deleted_at' => 'Ngày xóa',
            'deleted_by' => 'Người xóa',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
        ];
    
        // Trả về tiêu đề cột (bao gồm STT và các tên cột đã chọn)
        return array_merge(['STT'], array_map(function($column) use ($columnNamesInVietnamese) {
            return $columnNamesInVietnamese[$column] ?? ucfirst(str_replace('_', ' ', $column));
        }, $this->selectedColumns));
    }

    public function map($variant): array
    {
        static $index = 0;
        $index++;

        $data = [$index];
        foreach ($this->selectedColumns as $column) {
            // Kiểm tra nếu cột tồn tại trong đối tượng $variant, sau đó lấy giá trị
            $value = $variant->$column ?? '';

            // Định dạng giá tiền (VD: price_modifier và original_price)
            if (in_array($column, ['price_modifier', 'original_price'])) {
                // Kiểm tra nếu giá trị là null
                if (is_null($value)) {
                    $value = null;  // Nếu giá trị là null, giữ nguyên null
                } else {
                    // Định dạng giá dưới dạng số tiền (VNĐ) nếu giá trị hợp lệ
                    if (is_numeric($value)) {
                        $value = number_format($value, 0, ',', '.') . ' VNĐ';
                    } else {
                        $value = null;  // Nếu giá trị không phải là số hợp lệ, trả về null
                    }
                }
            }

            // Định dạng ngày tháng (VD: created_at, updated_at, deleted_at)
            if (in_array($column, ['created_at', 'updated_at', 'deleted_at'])) {
                // Đảm bảo giá trị ngày tháng hợp lệ và định dạng theo kiểu 'Y-m-d'
                if ($value instanceof Carbon) {
                    $value = $value->format('d/m/Y');
                } else {
                    $value = ''; // Nếu giá trị không phải kiểu ngày, để trống
                }
            }

            // Thêm giá trị vào mảng
            $data[] = $value;
        }

        return $data;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // STT
            'B' => 20,  // ID sản phẩm biến thể
            'C' => 15,  // Mã mã sản phẩm
            'D' => 30,  // price_modifier
            'E' => 25,  // original_price
            'F' => 30,  // stock
            'G' => 20,  // Sku
            'H' => 24,  // Trạng thái
            'I' => 25,  // Ngày xóa
            'J' => 30,  // Người xóa
            'K' => 30,  // Ngày tạo
            'L' => 30,  // Ngày cập nhật
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        // Căn giữa các tiêu đề (dòng 1)
        $sheet->getRowDimension(1)->setRowHeight(20);  // Thiết lập chiều cao cho dòng tiêu đề (tùy chỉnh)
        foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'] as $column) {
            $sheet->getStyle($column . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column . '1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn giữa các ô số (bắt đầu từ hàng 2 trở đi)
        foreach (['A', 'B', 'C', 'F'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn trái các ô chữ (bắt đầu từ hàng 2 trở đi)
        foreach (['G', 'H'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }

        // Căn phải các ô giá (bắt đầu từ hàng 2 trở đi)
        foreach (['D', 'E'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        // Căn phải các ô ngày (bắt đầu từ hàng 2 trở đi)
        foreach (['I', 'K', 'L'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }
        // Tự động căn chỉnh độ rộng cột
        foreach (range('A', 'AA') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }

    public function title(): string
    {
        return 'Danh sách sản phẩm biến thể';
    }
}
