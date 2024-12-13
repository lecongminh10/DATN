@extends('admin.layouts.app')
@section('title')
    Nhập dữ liệu danh mục
@endsection
@section('style_css')
    <style>
        .chunk-size {
            margin-top: 11.5px;
        }

        .chunk-size .title{
            font-size: 16.5px;
        }

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
            /* background-color: #4CAF50; Màu xanh lá */
            /* color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 10px;
            margin-top: 15px; */

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
                    ['name' => 'Nhập danh mục', 'url' => '#'],
                ],
            ])

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="orderList">
                    <div class="card-header border border-dashed border-end-0 border-start-0 border-top-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Nhập danh mục</h5>
                            </div>
                        </div>
                    </div>

                    <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
                        <div class="file-upload-container" onclick="document.getElementById('fileInput').click()"
                            ondragover="event.preventDefault()" ondrop="handleDrop(event)" id="fileUploadContainer">
                            <h3 id="fileUploadText">Kéo và thả tập tin vào đây hoặc nhấp để tải lên</h3>
                            <input type="file" id="fileInput" class="file-input" accept=".csv, .xls, .xlsx" onchange="showFileName()" />
                        </div>

                        <div class="text-span">
                            <span>Chọn một tệp có phần mở rộng sau: csv, xls, xlsx.</span>
                        </div>

                        {{-- <div class="chunk-size">
                            <label for="" class="title">Kích thước khối</label>
                            <input type="number" class="form-control" value="1000"/>
                            <div class="text-span">
                                <span>Số lượng hàng được nhập tại một thời điểm được xác định bởi kích thước khối. 
                                    Tăng giá trị này nếu bạn có tệp lớn và dữ liệu được nhập rất nhanh. Giảm giá trị 
                                    này nếu bạn gặp phải giới hạn bộ nhớ hoặc sự cố hết thời gian chờ cổng khi nhập dữ liệu.</span>
                            </div>
                        </div> --}}
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
                    <table class="table table-striped">
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
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
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
        <h5 class="text-modal">Nhập sai file. Hãy thử lại với file có tên (import-categories)!</h5>
        <button class="btn-modal" onclick="reloadPage()">Ok</button>
    </div>
</div>
@endsection

@section('script_libray')
    
@endsection

@section('scripte_logic')
    <script>

       

        // Thả và kéo hoặc chọn tệp tin
        const fileUploadContainer = document.getElementById('fileUploadContainer');
        const fileInput = document.getElementById('fileInput');
        const importButton = document.getElementById('importButton');

        function showFileName() {
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                replaceContainerWithFileInfo(file);
                importButton.disabled = false;
            }
        }

        function handleDrop(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                replaceContainerWithFileInfo(files[0]);
                importButton.disabled = false;
            }
        }

        function replaceContainerWithFileInfo(file) {
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
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

            fetch("import-categories", {
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