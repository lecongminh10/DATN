<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $this->command->error('Không tìm thấy người dùng để gán bài viết!');
            return;
        }

        $tagNames = ['Công nghệ', 'Thời trang', 'Đời sống', 'Sức khỏe', 'Mẹo mua sắm', 'Đánh giá'];
        $tags = [];
        foreach ($tagNames as $name) {
            $tags[] = Tag::firstOrCreate(['name' => $name]);
        }

        $postsData = [
            [
                'title' => 'Top 5 Smartphone đáng mua nhất năm 2026',
                'content' => '<h2>Top 5 Smartphone đáng mua nhất năm 2026</h2><p>Năm 2026 chứng kiến những bước nhảy vọt trong công nghệ di động, từ màn hình gập hoàn hảo đến thời lượng pin kéo dài hàng tuần.</p><h3>1. iPhone 17 Pro Max</h3><p>Apple tiếp tục khẳng định vị thế với con chip A19 Bionic vô cùng mạnh mẽ...</p><h3>2. Samsung Galaxy S26 Ultra</h3><p>Camera 300MP là điểm nhấn lớn nhất trên dòng flagship của Samsung năm nay...</p><h3>3. Xiaomi 16 Ultra</h3><p>Xiaomi mang đến công nghệ sạc siêu nhanh 300W, đầy pin chỉ trong 5 phút...</p>',
                'thumbnail' => 'posts/smartphone-2026.jpg',
            ],
            [
                'title' => 'Xu hướng thời trang Xuân - Hè 2026: Sự trỗi dậy của vải sinh học',
                'content' => '<h2>Xu hướng thời trang Xuân - Hè 2026</h2><p>Các nhà thiết kế hàng đầu thế giới đang dần chuyển hướng sang các loại chất liệu bền vững và có khả năng phân hủy sinh học.</p><p>Vải sợi tơ tằm nhân tạo được nuôi cấy trong phòng thí nghiệm đang trở thành cơn sốt mới trong làng mốt...</p>',
                'thumbnail' => 'posts/fashion-2026.jpg',
            ],
            [
                'title' => 'Cách chọn Laptop cho sinh viên ngành thiết kế đồ họa',
                'content' => '<h2>Cách chọn Laptop cho sinh viên đồ họa</h2><p>Khi chọn mua laptop làm đồ họa, màn hình và card đồ họa là hai yếu tố quan trọng nhất cần lưu ý.</p><ul><li>Độ bao phủ màu: Tối thiểu 100% sRGB.</li><li>RAM: Nên bắt đầu từ 16GB.</li><li>SSD: 512GB là mức cơ bản nhất.</li></ul>',
                'thumbnail' => 'posts/laptop-graphic.jpg',
            ],
            [
                'title' => 'Bí quyết bảo quản giày da luôn bền đẹp như mới',
                'content' => '<h2>Mẹo bảo quản giày da</h2><p>Giày da nam/nữ cần được chăm sóc đúng cách để tránh bị nổ da hoặc mất phom dáng.</p><p>Hãy nhớ sử dụng xi chuyên dụng và tránh để giày tiếp xúc trực tiếp với nước mưa quá lâu...</p>',
                'thumbnail' => 'posts/leather-shoes-care.jpg',
            ],
            [
                'title' => 'Tương lai của thương mại điện tử tại Việt Nam',
                'content' => '<h2>E-commerce Việt Nam 2026</h2><p>Mua sắm qua livestream tích hợp AR (Thực tế tăng cường) đang làm thay đổi thói quen mua hàng của giới trẻ Việt...</p>',
                'thumbnail' => 'posts/ecommerce-future.jpg',
            ],
        ];

        foreach ($postsData as $data) {
            $post = Post::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'thumbnail' => $data['thumbnail'],
                    'user_id' => $user->id,
                    'is_published' => true,
                    'published_at' => now(),
                    'meta_title' => $data['title'] . ' - ZonMart Blog',
                    'meta_description' => Str::limit(strip_tags($data['content']), 160),
                ]
            );

            // Gán 1-2 tag ngẫu nhiên
            $post->tags()->sync([
                $tags[array_rand($tags)]->id,
                $tags[array_rand($tags)]->id,
            ]);
        }

        $this->command->info('✅ Đã tạo ' . count($postsData) . ' bài viết mẫu thành công!');
    }
}
