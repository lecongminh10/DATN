<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class CategoriesExport implements FromCollection, WithColumnWidths, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $selectedColumns;

    public function __construct(array $selectedColumns)
    {
        // Loại bỏ cột "image" khỏi các cột được chọn
        $this->selectedColumns = array_filter($selectedColumns, function($column) {
            return $column !== 'image';  // Không chọn trường "image"
        });
    }

    public function collection()
    {
        // Lấy danh sách các danh mục từ cơ sở dữ liệu theo cột đã chọn
        return Category::select($this->selectedColumns)->get();
    }

    public function headings(): array
    {
        // Ánh xạ tên cột sang tiếng Việt cho bảng Category
        $columnNamesInVietnamese = [
            'id' => 'ID danh mục',
            'name' => 'Tên danh mục',
            'description' => 'Mô tả',
            'parent_id' => 'Danh mục cha',
            'is_active' => 'Cờ kích hoạt',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'deleted_at' => 'Ngày xóa',
            'deleted_by' => 'Người xóa',
        ];

        // Trả về tiêu đề cột, bao gồm STT và các tên cột đã chọn
        return array_merge(['STT'], array_map(function($column) use ($columnNamesInVietnamese) {
            return $columnNamesInVietnamese[$column] ?? ucfirst(str_replace('_', ' ', $column));
        }, $this->selectedColumns));
    }

    public function map($category): array
    {
        static $index = 0;
        $index++;

        $data = [$index]; // Thêm STT vào đầu mảng dữ liệu
        foreach ($this->selectedColumns as $column) {
            // Kiểm tra nếu cột tồn tại trong đối tượng $category, sau đó lấy giá trị
            $value = $category->$column ?? '';

            // Định dạng ngày tháng cho các trường ngày
            if (in_array($column, ['created_at', 'updated_at', 'deleted_at'])) {
                if ($value instanceof Carbon) {
                    $value = $value->format('d/m/Y');
                } else {
                    $value = ''; // Nếu không phải là ngày hợp lệ, để trống
                }
            }

            // Định dạng cho các trường boolean
            if (strpos($column, 'is_') === 0) {
                // Kiểm tra giá trị boolean và chuyển đổi thành "Có" / "Không"
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
            'B' => 15,  // ID danh mục
            'C' => 15,  // Tên danh mục
            'D' => 15,  // Mô tả
            'E' => 15,  // Danh mục cha
            'F' => 15,  // Kích hoạt
            'G' => 20,  // Ngày xóa
            'H' => 20,  // Người xóa
            'I' => 20,  // Ngày tạo
            'J' => 20,  // Ngày cập nhật
        ];
    }


    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        // Căn giữa các tiêu đề (dòng 1)
        $sheet->getRowDimension(1)->setRowHeight(20);  // Thiết lập chiều cao cho dòng tiêu đề (tùy chỉnh)
        foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'] as $column) {
            $sheet->getStyle($column . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column . '1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn giữa các ô số (bắt đầu từ hàng 2 trở đi)
        foreach (['A', 'B','F'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn trái các ô chữ (bắt đầu từ hàng 2 trở đi)
        foreach (['C', 'D'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn phải các ô ngày (bắt đầu từ hàng 2 trở đi)
        foreach (['G', 'I', 'J'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Tự động căn chỉnh độ rộng cột
        foreach (range('A', 'AA') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }

    public function title(): string
    {
        return 'Danh sách danh mục';
    }
}
