<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $images = [];
        foreach ($this->order->items as $item) {
            if ($item->product->productVariant && !empty($item->product->productVariant->variant_image)) {
                // Lấy đường dẫn từ variant
                $images[] = storage_path('app/public/' . $item->product->productVariant->variant_image);
            } else {
                // Lấy đường dẫn từ ảnh chính
                $mainImage = $item->product->getMainImage();
                $images[] = $mainImage ? storage_path('app/public/' . $mainImage->image_gallery) : public_path('images/default-image.jpg');
            }
        }

        // Lấy phí ship từ bảng shipping_methods
        $shippingFee = $this->order->shippingMethod->shipping_fee ?? 0;  // Truyền phí ship vào biến

        // Lấy giá trị giảm giá từ coupon_usage
        $discount = 0;

        // Kiểm tra xem order có sử dụng coupon hay không
        if ($this->order->couponUsage) {
            // Lấy giá trị discount_value từ bảng coupons_usage
            $discount = $this->order->couponUsage->discount_value ?? 0;
        }

        return $this->view('emails.order_placed')
                    ->subject('Bạn đã mua hàng thành công')
                    ->with(['order' => $this->order,
                        'images' => $images,  // Truyền ảnh vào view
                        'shippingFee' => $shippingFee, // Truyền phí ship vào view
                        'discount' => $discount, // Truyền giá trị giảm giá vào view
                        ]);
    }
}