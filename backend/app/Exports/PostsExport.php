<?php

namespace App\Exports;

use App\Models\Post;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PostsExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithTitle, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $selectedColumns;

    public function __construct(array $selectedColumns)
    {
        // Loại bỏ cột "image" khỏi các cột được chọn
        $this->selectedColumns = array_filter($selectedColumns, function($column) {
            return $column !== 'thumbnail';  // Không chọn trường "image"
        });
    }

    // public function collection()
    // {
    //     // Lấy dữ liệu với các cột đã chọn từ cơ sở dữ liệu
    //     return Category::select($this->selectedColumns)->get();
    // }

    public function collection()
    {
        // Lấy danh sách các bài viết từ cơ sở dữ liệu theo cột đã chọn
        return Post::select($this->selectedColumns)->get();
    }

    public function headings(): array
    {
        // Mảng ánh xạ tên cột sang tiếng việt
        $columnNamesInVietnamese = [
            'id' => 'ID bài viết',
            'title' => 'Tên bài viết',
            'content' => 'Nội dung',
            'slug' => 'Slug cho bài viết',
            'meta_title' => 'Tiêu đề SEO',
            'meta_description' => 'Mô tả SEO',
            'user_id' => 'ID người dùng',
            'is_published' => 'Trạng thái xuất bản',
            'published_at' => 'Thời gian xuất bản',
            'deleted_at' => 'Ngày xóa',
            'deleted_by' => 'Người xóa',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
        ];

        // Chuyển tên cột đã chọn sang tiếng việt
        // Trả về tiêu đề cột, bao gồm STT và các tên cột đã chọn
        return array_merge(['STT'], array_map(function ($column) use ($columnNamesInVietnamese) {
            return $columnNamesInVietnamese[$column] ?? ucfirst(str_replace('_', ' ', $column));
        }, $this->selectedColumns));

    }

    public function map($post): array
    {
        static $index = 0;
        $index++;

        $data = [$index]; // Thêm STT vào đầu mảng dữ liệu
        foreach ($this->selectedColumns as $column) {
            // Kiểm tra nếu cột tồn tại trong đối tượng $post, sau đó lấy giá trị
            $value = $post->$column ?? '';

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
            'B' => 15,  // ID bài viết
            'C' => 15,  // Tên bài viết
            'D' => 15,  // Mô tả
            'E' => 15,  // Slug bài viết
            'F' => 15,  // Tiêu đề SEO
            'G' => 20,  // Mô tả SEO
            'H' => 20,  // Dường dẫn ảnh
            'I' => 15,  // ID người dùng
            'J' => 20,  // Trạng thái xuất bản
            'K' => 20,  // Thời gian xuất bản
            'L' => 20,  // Ngày xóa
            'M' => 20,  // Ngày tạo
            'N' => 20,  // Ngày cập nhật
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Căn giữa các tiêu đề (dòng 1)
        $sheet->getRowDimension(1)->setRowHeight(20);  // Thiết lập chiều cao cho dòng tiêu đề (tùy chỉnh)
        foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'] as $column) {
            $sheet->getStyle($column . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column . '1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn giữa các ô số (bắt đầu từ hàng 2 trở đi)
        foreach (['A', 'B', 'I', 'J'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn trái các ô chữ (bắt đầu từ hàng 2 trở đi)
        foreach (['C', 'D', 'E', 'F', 'G'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Căn phải các ô ngày (bắt đầu từ hàng 2 trở đi)
        foreach (['K', 'L', 'M', 'N'] as $column) {
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle($column . '2:' . $column . $sheet->getHighestRow())->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        // Tự động căn chỉnh độ rộng cột
        foreach (range('A', 'P') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }

    public function title(): string
    {
        return 'Danh sách danh mục';
    }
}
