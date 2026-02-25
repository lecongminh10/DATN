<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'name'            => 'Về chúng tôi',
                'permalink'       => 've-chung-toi',
                'description'     => 'Thông tin giới thiệu về ZonMart',
                'content'         => '<h2>Về chúng tôi</h2>
<p>ZonMart là cửa hàng thương mại điện tử hàng đầu, chuyên cung cấp các sản phẩm công nghệ chính hãng với giá tốt nhất thị trường.</p>
<h3>Sứ mệnh</h3>
<p>Mang đến cho khách hàng trải nghiệm mua sắm tuyệt vời với sản phẩm chất lượng, dịch vụ tận tâm và giao hàng nhanh chóng.</p>
<h3>Tầm nhìn</h3>
<p>Trở thành nền tảng thương mại điện tử tin cậy số 1 Việt Nam, nơi mọi người có thể mua sắm an tâm với hàng nghìn sản phẩm chính hãng.</p>
<h3>Giá trị cốt lõi</h3>
<ul>
  <li>✅ Uy tín - Chúng tôi cam kết 100% hàng chính hãng</li>
  <li>✅ Chất lượng - Sản phẩm được kiểm tra kỹ lưỡng trước khi giao</li>
  <li>✅ Tận tâm - Đội ngũ hỗ trợ 24/7 luôn sẵn sàng phục vụ</li>
  <li>✅ Nhanh chóng - Giao hàng toàn quốc trong 1-3 ngày</li>
</ul>',
                'is_active'       => true,
                'template'        => 'default',
                'seo_title'       => 'Về chúng tôi - ZonMart',
                'seo_description' => 'Tìm hiểu về ZonMart - Cửa hàng công nghệ chính hãng hàng đầu Việt Nam.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'name'            => 'Chính sách bảo hành',
                'permalink'       => 'chinh-sach-bao-hanh',
                'description'     => 'Chính sách bảo hành sản phẩm tại ZonMart',
                'content'         => '<h2>Chính sách bảo hành</h2>
<p>ZonMart cam kết bảo hành chính hãng cho tất cả sản phẩm được mua tại cửa hàng.</p>
<h3>Điều kiện bảo hành</h3>
<ul>
  <li>Sản phẩm còn trong thời hạn bảo hành theo quy định của nhà sản xuất.</li>
  <li>Sản phẩm còn nguyên tem, nhãn bảo hành và có hóa đơn mua hàng.</li>
  <li>Lỗi kỹ thuật do nhà sản xuất (không bao gồm lỗi do người dùng).</li>
</ul>
<h3>Thời gian bảo hành</h3>
<table class="table table-bordered">
  <thead><tr><th>Loại sản phẩm</th><th>Thời gian bảo hành</th></tr></thead>
  <tbody>
    <tr><td>Laptop</td><td>12 - 24 tháng</td></tr>
    <tr><td>Điện thoại</td><td>12 tháng</td></tr>
    <tr><td>Phụ kiện</td><td>3 - 6 tháng</td></tr>
    <tr><td>Thiết bị âm thanh</td><td>6 - 12 tháng</td></tr>
  </tbody>
</table>
<h3>Quy trình bảo hành</h3>
<ol>
  <li>Liên hệ hotline <strong>0392853609</strong> để được tư vấn.</li>
  <li>Mang sản phẩm cùng hóa đơn đến cửa hàng gần nhất.</li>
  <li>Nhân viên kiểm tra và xác nhận lỗi.</li>
  <li>Gửi sản phẩm về trung tâm bảo hành chính hãng.</li>
  <li>Nhận lại sản phẩm sau khi sửa chữa.</li>
</ol>',
                'is_active'       => true,
                'template'        => 'default',
                'seo_title'       => 'Chính sách bảo hành - ZonMart',
                'seo_description' => 'Chính sách bảo hành chính hãng tại ZonMart. Cam kết bảo hành đúng thời hạn và chất lượng.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'name'            => 'Chính sách bảo mật',
                'permalink'       => 'chinh-sach-bao-mat',
                'description'     => 'Chính sách bảo mật thông tin khách hàng',
                'content'         => '<h2>Chính sách bảo mật</h2>
<p>ZonMart cam kết bảo vệ thông tin cá nhân của khách hàng theo quy định pháp luật Việt Nam.</p>
<h3>Thông tin chúng tôi thu thập</h3>
<ul>
  <li>Họ tên, địa chỉ email, số điện thoại.</li>
  <li>Địa chỉ giao hàng và thông tin thanh toán.</li>
  <li>Lịch sử đơn hàng và sản phẩm đã xem.</li>
</ul>
<h3>Mục đích sử dụng thông tin</h3>
<ul>
  <li>Xử lý đơn hàng và giao hàng đến tay khách hàng.</li>
  <li>Thông báo về trạng thái đơn hàng và khuyến mãi.</li>
  <li>Cải thiện dịch vụ và trải nghiệm mua sắm.</li>
</ul>
<h3>Cam kết bảo mật</h3>
<p>Chúng tôi <strong>không</strong> chia sẻ, bán hoặc tiết lộ thông tin cá nhân của khách hàng cho bên thứ ba mà không có sự đồng ý, ngoại trừ các trường hợp pháp luật yêu cầu.</p>
<h3>Liên hệ</h3>
<p>Nếu có bất kỳ thắc mắc nào về chính sách bảo mật, vui lòng liên hệ: <strong>0392853609</strong></p>',
                'is_active'       => true,
                'template'        => 'default',
                'seo_title'       => 'Chính sách bảo mật - ZonMart',
                'seo_description' => 'Chính sách bảo mật thông tin khách hàng tại ZonMart.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'name'            => 'Hướng dẫn mua hàng',
                'permalink'       => 'huong-dan-mua-hang',
                'description'     => 'Hướng dẫn mua hàng tại ZonMart',
                'content'         => '<h2>Hướng dẫn mua hàng</h2>
<h3>Bước 1: Tìm kiếm sản phẩm</h3>
<p>Sử dụng thanh tìm kiếm hoặc duyệt qua các danh mục sản phẩm để tìm sản phẩm phù hợp.</p>
<h3>Bước 2: Chọn sản phẩm</h3>
<p>Nhấp vào sản phẩm để xem chi tiết. Chọn màu sắc, dung lượng hoặc phiên bản phù hợp rồi nhấn <strong>"Thêm vào giỏ hàng"</strong>.</p>
<h3>Bước 3: Kiểm tra giỏ hàng</h3>
<p>Xem lại giỏ hàng, kiểm tra số lượng và áp dụng mã giảm giá (nếu có).</p>
<h3>Bước 4: Điền thông tin giao hàng</h3>
<p>Nhập đầy đủ họ tên, số điện thoại và địa chỉ nhận hàng.</p>
<h3>Bước 5: Chọn phương thức thanh toán</h3>
<ul>
  <li>💳 Thanh toán online qua VNPay</li>
  <li>💵 Thanh toán khi nhận hàng (COD)</li>
</ul>
<h3>Bước 6: Xác nhận đơn hàng</h3>
<p>Nhấn <strong>"Đặt hàng"</strong>. Bạn sẽ nhận được email xác nhận đơn hàng ngay sau đó.</p>
<h3>Hỗ trợ</h3>
<p>Nếu cần hỗ trợ, liên hệ hotline: <strong>0392853609</strong> (8:00 - 22:00 hàng ngày)</p>',
                'is_active'       => true,
                'template'        => 'default',
                'seo_title'       => 'Hướng dẫn mua hàng - ZonMart',
                'seo_description' => 'Hướng dẫn mua hàng trực tuyến tại ZonMart một cách dễ dàng và nhanh chóng.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'name'            => 'Liên hệ',
                'permalink'       => 'lien-he',
                'description'     => 'Thông tin liên hệ và hỗ trợ khách hàng',
                'content'         => '<h2>Liên hệ với chúng tôi</h2>
<p>Chúng tôi luôn sẵn sàng hỗ trợ bạn. Hãy liên hệ qua các kênh dưới đây:</p>
<div class="row">
  <div class="col-md-6">
    <h3>📞 Hotline hỗ trợ</h3>
    <p><strong>0392853609</strong><br>Thứ 2 - Chủ nhật: 8:00 - 22:00</p>
    <h3>📧 Email</h3>
    <p><strong>support@zonmart.vn</strong></p>
    <h3>💬 Chat trực tuyến</h3>
    <p>Nhấn vào biểu tượng chat ở góc phải màn hình để được hỗ trợ ngay.</p>
  </div>
  <div class="col-md-6">
    <h3>🏪 Địa chỉ cửa hàng</h3>
    <p><strong>Hà Nội:</strong><br>123 Đường Công Nghệ, Cầu Giấy, Hà Nội</p>
    <p><strong>TP. Hồ Chí Minh:</strong><br>456 Đường Điện Tử, Quận 1, TP.HCM</p>
    <h3>⏰ Giờ làm việc</h3>
    <p>Thứ 2 - Thứ 7: 8:00 - 21:00<br>Chủ nhật: 9:00 - 18:00</p>
  </div>
</div>',
                'is_active'       => true,
                'template'        => 'default',
                'seo_title'       => 'Liên hệ - ZonMart',
                'seo_description' => 'Liên hệ ZonMart để được hỗ trợ mua sắm, bảo hành và giải đáp thắc mắc.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ];

        foreach ($pages as $page) {
            // Tránh duplicate nếu chạy seeder nhiều lần
            \Illuminate\Support\Facades\DB::table('pages')
                ->updateOrInsert(['permalink' => $page['permalink']], $page);
        }

        $this->command->info('✅ Đã tạo ' . count($pages) . ' trang mẫu thành công!');
    }
}
