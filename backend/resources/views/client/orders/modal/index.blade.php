<div class="modal fade" id="editAddressModal" tabindex="-1"
aria-labelledby="editAddressModalLabel" aria-hidden="true" data-bs-backdrop="static"
data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editAddressModalLabel">Địa Chỉ Của Tôi</h5>
            <button type="button" class="btn-close-address" data-bs-dismiss="modal"
                aria-label="Đóng">×</button>
        </div>
        <div class="modal-body" id="address-content">
            <!-- Địa chỉ hiện tại -->
            <div class="">
                <div>
                    @php
                        $displayAddress = Auth::check()
                            ? Auth::user()->addresses
                            : collect();
                    @endphp
                    <div
                        class="user-info d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="username">
                                {{ Auth::check() ? Auth::user()->username : '' }}</h6>
                            <p class="phone-number">
                                {{ Auth::check() ? Auth::user()->phone_number : '' }}
                            </p>
                        </div>
                        @if (count($displayAddress) < 3)
                            <button type="button"
                                class="btn btn-primary add-address-button"
                                id="btnAddAddress" data-bs-toggle="modal"
                                data-bs-target="#addAddressModal">
                                + Thêm Địa Chỉ Mới
                            </button>
                        @endif
                    </div>
                    @if ($displayAddress->isNotEmpty())
                        @foreach ($displayAddress as $address)
                            <div class="form-check address-item py-2">
                                <input class="form-check-input address-checkbox"
                                    type="radio" value="{{ $address->id }}"
                                    name="address" id="address{{ $address->id }}"
                                    @if ($address->active) checked @endif>
                                <label class="form-check-label address-label"
                                    for="address{{ $address->id }}">
                                    <div class="address-info">
                                        <span class="address-text">
                                            {{ $address->specific_address }},
                                            {{ $address->ward }},
                                            {{ $address->district }},
                                            {{ $address->city }}
                                        </span>
                                        @if ($address->active)
                                            <span class="small-title">Mặc định</span>
                                        @endif
                                    </div>
                                    <a href="#"
                                        class="text-primary edit-address-link"
                                        data-id="{{ $address->id }}"
                                        data-name="{{ Auth::user()->username ?? '' }}"
                                        data-phone="{{ Auth::user()->phone_number ?? '' }}"
                                        data-specific-address="{{ $address->specific_address }}"
                                        data-ward="{{ $address->ward }}"
                                        data-district="{{ $address->district }}"
                                        data-city="{{ $address->city }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateAddressModal">Cập
                                        nhật</a>
                                </label>
                            </div>
                        @endforeach
                    @else
                        <p class="no-address">Chưa có địa chỉ</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btnHuy" id="btnHuy"
                data-bs-dismiss="modal">Hủy</button>
            <button type="button" class="btnBack" id="btnBack"
                style="display: none;">Trở Lại</button>
            <button type="button" class="btnEdit" id="btnConfirm"
                data-bs-dismiss="modal" aria-label="Đóng">Xác nhận</button>
        </div>
    </div>
</div>
</div>

{{-- Modal Cập nhật Địa chỉ --}}
<div class="modal fade" id="updateAddressModal" tabindex="-1"
aria-labelledby="updateAddressModalLabel" aria-hidden="true"
data-bs-backdrop="static" data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="updateAddressModalLabel">Cập Nhật Địa Chỉ</h5>
            <button type="button" class="btn-close-address" data-bs-dismiss="modal"
                aria-label="Đóng">×</button>
        </div>
        <!-- Form cập nhật địa chỉ -->
        <div class="modal-body" id="update-address-form">
            <form id="updateAddressForm">
                <!-- Họ và tên + Số điện thoại cùng hàng -->
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <input type="text" class="form-control"
                            placeholder="Họ và tên" id="updateName">
                    </div>
                    <div class="col-md-6 mb-1">
                        <input type="text" class="form-control"
                            placeholder="Số điện thoại" id="updatePhone">
                    </div>
                    <input type="hidden" name="id_address" id="id_address">
                </div>
                <!-- Tỉnh/Thành phố, Quận/Huyện, Phường/Xã -->
                <div class="mb-2">
                    <select class="form-control city" name="city" id="city">
                        <option value="">Tỉnh/Thành phố</option>
                    </select>
                    <select class="form-control district" name="district"
                        id="district">
                        <option value="">Quận/Huyện</option>
                    </select>
                    <select class="form-control ward" name="ward" id="ward">
                        <option value="">Phường/Xã</option>
                    </select>
                    <input type="text" class="form-control"
                        placeholder="Địa chỉ cụ thể" id="updateAddress">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btnHuy" id="btnCancelUpdate"
                data-bs-dismiss="modal">Hủy</button>
            <button type="button" class="btnBack" id="btnBackToEdit"
                style="display: inline-block;">Trở Lại</button>
            <button type="button" class="btnEdit" id="btnConfirmUpdate"
                data-bs-dismiss="modal" aria-label="Đóng">Xác nhận</button>
        </div>
    </div>
</div>
</div>

{{-- End modal --}}

{{-- Modal Thêm địa chỉ --}}
<div class="modal fade" id="addAddressModal" tabindex="-1"
aria-labelledby="addAddressModalLabel" aria-hidden="true" data-bs-backdrop="static"
data-bs-keyboard="false">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addAddressModalLabel">Thêm địa chỉ</h5>
            <button type="button" class="btn-close-address" data-bs-dismiss="modal"
                aria-label="Đóng">×</button>
        </div>

        <!-- Form thêm địa chỉ mới -->
        <div class="modal-body" id="new-address-form">
            <form id="addAddressForm">
                <!-- Họ và tên + Số điện thoại cùng hàng -->
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <input type="text" class="form-control" name="username"
                            placeholder="Họ và tên" id="newName"
                            value="{{ Auth::check() ? Auth::user()->username : '' }}">
                    </div>
                    <div class="col-md-6 mb-1">
                        <input type="phone" class="form-control" name="phone"
                            placeholder="Số điện thoại" id="newPhone"
                            value="{{ Auth::check() ? Auth::user()->phone_number : '' }}">
                    </div>
                </div>
                <!-- Tỉnh/Thành phố, Quận/Huyện, Phường/Xã -->
                <div class="mb-2">
                    <select class="form-control" name="city" id="newCity">
                        <option value="">Tỉnh/Thành phố</option>
                    </select>
                    <select class="form-control" name="district" id="newDistrict">
                        <option value="">Quận/Huyện</option>
                    </select>
                    <select class="form-control" name="ward" id="newWard">
                        <option value="">Phường/Xã</option>
                    </select>
                </div>
                <!-- Địa chỉ cụ thể -->
                <div class="mb-2">
                    <input type="text" class="form-control" name="newAddress"
                        placeholder="Địa chỉ cụ thể" id="newAddress">
                </div>
                <!-- Đặt làm địa chỉ mặc định -->
                {{-- <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="newDefaultAddressCheck">
                <label class="form-check-label" for="newDefaultAddressCheck"> Đặt làm địa chỉ mặc định </label>
            </div> --}}
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btnHuy" id="btnHuy"
                data-bs-dismiss="modal">Hủy</button>
            <button type="button" class="btnAdd" id="btnAdd"
                data-bs-dismiss="modal" aria-label="Đóng">Thêm địa chỉ</button>
        </div>
    </div>
</div>
</div>