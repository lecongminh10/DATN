<!-- Modal Structure -->
<div class="modal fade" id="applyPriceModal" tabindex="-1" aria-labelledby="applyPriceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyPriceModalLabel">Thông báo </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Modal content -->
                <p>Bạn có muốn áp dụng cho toàn bộ biến thể ?</p>
                <div class="mb-3">
                    <label for="originalPrice" class="form-label">Giá gốc</label>
                    <input type="number" class="form-control" id="originalPrice" placeholder="Nhập giá gốc" value="">
                </div>
                <div class="mb-3">
                    <label for="salePrice" class="form-label">Giá khuyến mãi</label>
                    <input type="number" class="form-control" id="salePrice" placeholder="Nhập giá khuyến mãi" value="">
                </div>
                <div class="mb-3">
                    <label for="salePrice" class="form-label">Số lượng tồn kho</label>
                    <input type="number" class="form-control" id="stockPrice" placeholder="Nhập giá khuyến mãi" value="">
                </div>
                <div class="mb-3">                    
                    <label for="salePrice" class="form-label">Trạng thái </label>
                    <select class="form-control" id="stockStatus">
                        <option value="available">Có sẵn</option>
                        <option value="out_of_stock">Hết hàng </option>
                        <option value="discontinued">Đã ngừng sản xuất</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Thoát</button>
                <button type="button" class="btn btn-primary" id="applyPrices">Lưu</button>
            </div>
        </div>
    </div>
</div>

  