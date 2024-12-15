@extends('admin.layouts.app')
@section('title')
    Nhập dữ liệu sản phẩm
@endsection
@section('style_css')
    <style>

        .import-type{
            margin-bottom: 10px;
        }

        .check-box{
            display: flex;
            margin: 17px 0 17px 0;
        }

        .custom-checkbox {
            appearance: none; /* Xóa kiểu hộp kiểm mặc định */
            width: 23px;
            height: 23px;
            border: 1px solid gainsboro;
            border-radius: 4px; /* Góc bo tròn */
            position: relative;
            margin-right: 10px; /* Khoảng cách giữa hộp kiểm và nhãn */
            cursor: pointer;
        }

        .custom-checkbox:checked {
            background-color: #405189; /* Đảm bảo nền vẫn màu xanh khi được chọn */
        }

        .custom-checkbox:checked::after {
            content: '✔'; /* ✔ */
            font-size: 18px;
            color: white;
            position: absolute;
            top: -2px;
            left: 3px;
            padding-bottom: 5px;

        }

        .text-checkbox{
            line-height: 1.2rem;
        }

        .text-checkbox .title{
            font-size: 15px;
            margin-top: 3px;
        }

        .chunk-size {
            margin-top: 11.5px;
        }

        /* .chunk-size .title{
            font-size: 16.5px;
        } */

        .chunk-size input{
            font-size: 16.5px;
           
        }

        /* Hiện lại mũi tên trong input */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: auto; /* Đặt lại về giá trị mặc định */
            height: 20px;
            margin-top: 2.8px;
            transform: scale(1.1); /* Tăng kích thước mũi tên lên 1.5 lần */
        }

        input[type=number] {
            -moz-appearance: number-input; /* Đặt lại về giá trị mặc định trên Firefox */
        }

        .file-upload-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .file-upload-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            background-color: #eef3f6;
            border: 1.5px dashed #d1d5db;
            border-radius: 8px;
            color: #374151;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .file-upload-container.drag-over {
            background-color: #d9e6f1;
        }

        .file-upload-container h3 {
            font-size: 16px;
        }

        /* Ẩn hoàn toàn input file */
        .file-input {
            display: none;
        }

        .file-info {
            display: flex;
            align-items: center;
            background-color: #eef3f6;
            border-radius: 8px;
            padding: 10px;
            margin-right: 20px;
            font-size: 16px;
            color: #374151;
        }

        .file-info .file-icon {
            font-size: 24px;
            margin-right: 10px;
        }

        /* .file-info .file-delete {
            color: red;
            cursor: pointer;
            margin-left: auto;
            font-size: 18px;
        } */

        .text-span{
            margin-top: 5px;
            color: #a0a1a3;
        }

        .table-thead{
            text-transform: uppercase; 
            color: rgb(148, 146, 146);
            font-style: inherit;
        }

        .button{
            background-color: #eef3f6;
        }

        /* Style cho modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 115px; /* Khoảng cách từ trên cùng */
            left: 1195px; /* Khoảng cách từ bên phải */
            width: 300px; /* Chiều rộng modal */
            height: auto;
            border-radius: 10px; /* Góc bo tròn */
            animation: slideIn 0.5s ease-out forwards; /* Hiệu ứng xuất hiện */
        }
        .text-modal{
            font-size: 16px;
        }

        /* Hiệu ứng xuất hiện */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(50%); /* Ban đầu nằm ngoài màn hình */
            }
            to {
                opacity: 1;
                transform: translateX(0); /* Vị trí ban đầu */
            }
        }

        /* Nội dung modal */
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px; /* Góc bo tròn */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
            text-align: center;
        }

        /* Nút đóng */
        .close {
            color: #aaa;
            font-size: 16px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        /* Nút "Xong" */
        .btn-modal {
            background-color: #405189;
            color: #e9ecff;
            border: none;
            padding: 4px 7px;
            /* margin-left: 176px; */
            border-radius: 5px;
            /* width: 75px; */
            cursor: pointer;
            font-size: 16px;
            margin-top: 13px;
        }

        button:hover {
            background-color: #4e62a2; /* Màu xanh đậm hơn khi hover */
            color: #e9ecff;
        }
    </style>

    
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        @include('admin.layouts.component.page-header', [
                'title' => 'Xuất - Nhập',
                'breadcrumb' => [
                    ['name' => 'Quản lí', 'url' => 'javascript: void(0);'],
                    ['name' => 'Nhập sản phẩm', 'url' => '#'],
                ],
            ])

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="orderList">
                    <div class="card-header border border-dashed border-end-0 border-start-0 border-top-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Nhập sản phẩm</h5>
                            </div>
                        </div>
                    </div>
        
                    <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                        <div class="import-type">
                            <h5>Loại nhập <span style="color: rgb(224, 5, 5)">*</span></h5>
                            <select name="import-type" class="form-control" id="import-type" onchange="handleImportTypeChange()">
                                <option value="products">Sản phẩm</option>
                                <option value="product_variants">Biến thể</option>
                            </select>
                        </div>
        
                        <!-- Phần tải lên tệp -->
                        <div class="file-upload-container" onclick="document.getElementById('fileInput').click()"
                            ondragover="event.preventDefault()" ondrop="handleDrop(event)" id="fileUploadContainer">
                            <h3 id="fileUploadText">Kéo và thả tập tin vào đây hoặc nhấp để tải lên</h3>
                            <input type="file" id="fileInput" class="file-input" accept=".csv, .xls, .xlsx" onchange="showFileName()" />
                        </div>
        
                        <div class="text-span">
                            <span>Chọn một tệp có phần mở rộng sau: csv, xls, xlsx.</span>
                        </div>
                    </div>
        
                    <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0 button">
                        <div class="btn-footer">
                            <button id="importButton" class="btn btn-success me-2" disabled>Nhập</button>
                            <a href="{{ route('admin.export-import.view-export-import') }}"><button class="btn btn-primary me-2">Quay lại</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="orderList">
                    <div class="card-header">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Quy tắc</h5>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped" id="products-table">
                        <thead class="table-thead">
                            <tr>
                                <th class="ps-3"> Cột</th>
                                <th> Quy tắc</th>
                            </tr>
                        </thead>
                        
                        <tbody class="table-tbody">
                            @foreach($columnsData as $column)
                                <tr>
                                    <td class="w-50 ps-3">{{ $column['name'] }}</td>
                                    <td>{{ $column['type'] }}:  {{$column['comments']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table table-striped" id="product-variants-table" hidden>
                        <thead class="table-thead">
                            <tr>
                                <th class="ps-3"> Cột</th>
                                <th> Quy tắc</th>
                            </tr>
                        </thead>
                        
                        <tbody class="table-tbody">
                            @foreach($columnsDataVariant  as $column)
                                <tr>
                                    <td class="w-50 ps-3">{{ $column['name'] }}</td>
                                    <td>{{ $column['type'] }}:  {{$column['comments']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Modal --}}
<div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <h5 class="text-modal">Nhập dữ liệu thành công!</h5>
        <button class="btn-modal" onclick="reloadPage()">Xong</button>
    </div>
</div>

<div id="warningModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>
        <h5 class="text-modal">Nhập sai file. Hãy thử lại!</h5>
        <button class="btn-modal" onclick="reloadPage()">Ok</button>
    </div>
</div>
@endsection

@section('script_libray')
    
@endsection

@section('scripte_logic')
    <script>
        // JavaScript function to handle onchange event
        function handleImportTypeChange() {
            const importType = document.getElementById('import-type').value;
            
            // Get references to both table divs
            const productsTable = document.getElementById('products-table');
            const productVariantsTable = document.getElementById('product-variants-table');
        
            // Toggle visibility based on the selected value
            if (importType === 'products') {
                productsTable.hidden = false;
                productVariantsTable.hidden = true;
            } else if (importType === 'product_variants') {
                productsTable.hidden = true;
                productVariantsTable.hidden = false;
            }
        }
        </script>
    <script>
        // Thả và kéo hoặc chọn tệp tin
        const fileUploadContainer = document.getElementById('fileUploadContainer');
        const fileInput = document.getElementById('fileInput');
        const importButton = document.getElementById('importButton'); // Lấy nút nhập

        function showFileName() {
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                replaceContainerWithFileInfo(file);
                importButton.disabled = false; // Kích hoạt nút nhập khi có tệp
            }
        }

        function handleDrop(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                replaceContainerWithFileInfo(files[0]);
                importButton.disabled = false; // Kích hoạt nút nhập khi có tệp
            }
        }

        function replaceContainerWithFileInfo(file) {
            const fileSize = (file.size / 1024 / 1024).toFixed(2); // Kích thước file tính bằng MB

            fileUploadContainer.innerHTML = `
                <div class="file-info" id="fileInfoContainer">
                    <span class="file-icon">📄</span>
                    <span>${file.name}</span>
                    <span>${fileSize} MB</span>
                    <span class="file-delete" onclick="resetFileUpload()">🗑️</span>
                </div>
            `;
        }

        function resetFileUpload() {
            // Xóa file đã chọn mà không hiện lại nút chọn tệp
            fileInput.value = ''; // Xóa giá trị của input

            // Cập nhật lại giao diện
            fileUploadContainer.innerHTML = `
                <h3 id="fileUploadText">Kéo và thả tập tin vào đây hoặc nhấp để tải lên</h3>
            `;

            // Thêm sự kiện để hiển thị lại input file khi nhấp vào vùng tải lên
            fileUploadContainer.onclick = () => fileInput.click();

            importButton.disabled = true; // Vô hiệu hóa nút nhập khi không có tệp
        }

        // Nhập dữ liệu
        document.getElementById('importButton').addEventListener('click', function () {
            if (!fileInput || fileInput.files.length === 0) {
                alert('Vui lòng chọn một tệp trước khi nhập.');
                return;
            }

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('import-type', document.getElementById('import-type').value);

            fetch("import-products", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showModal(); // Hiển thị modal thành công
                } else {
                    showWarningModal(); // Hiển thị modal cảnh báo khi nhập sai tệp
                }
            })
            .catch(error => console.error('Lỗi khi nhập tệp:', error));
            // showWarningModal(); // Hiển thị modal cảnh báo khi có lỗi trong quá trình nhập
        });

        // Hiển thị modal
        function showModal() {
            document.getElementById('successModal').style.display = 'block';
        }

        // Hiển thị modal cảnh báo
        function showWarningModal() {
            document.getElementById('warningModal').style.display = 'block';
        }       

        // Đóng modal
        function closeModal() {
            document.getElementById('successModal').style.display = 'none';
        }

        function closeWarningModal() {
            document.getElementById('warningModal').style.display = 'none';
        }

        // Tải lại trang
        function reloadPage() {
            location.reload();
        }

    </script>
@endsection