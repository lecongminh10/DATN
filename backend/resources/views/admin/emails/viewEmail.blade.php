@extends('admin.layouts.app')

@section('libray_css')
    <!-- quill css -->
    <link href="{{ asset('theme/assets/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/assets/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
    <style>
        #emailSearch {
            cursor: pointer;
        }

        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
        }

        .form-check-label {
            cursor: pointer;
        }

    </style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Email</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                            <li class="breadcrumb-item active">Email</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="orderList">
                    <div class="card-header border-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Email</h5>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.email.sendEmail') }}" id="sendEmailForm" method="post">
                        @csrf
                        <div class="card-body border border-dashed border-bottom-0 border-end-0 border-start-0">
                            
                            <h4 class="mb-3">Tin nhắn mới</h4>
                            
                            <!-- To (Multi-Select Dropdown) -->
                            <div class="mb-3">
                                <label for="toEmail" class="form-label">Gửi:</label>
                            
                                <!-- Input field for displaying and searching -->
                                <input type="text" id="emailSearch" name="toEmail" class="form-control" placeholder="Chọn hoặc tìm kiếm email...">
                            
                                <!-- Dropdown menu -->
                                <div class="dropdown mt-2">
                                    <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Danh sách Email
                                    </button>
                                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton" id="emailDropdown">
                                        <!-- Email Options -->
                                        <li class="ms-3">
                                            <div class="form-check">
                                                <input class="form-check-input email-option" type="checkbox" id="allEmails" value="0">
                                                <label class="form-check-label" for="allEmails">Tất cả</label>
                                            </div>
                                        </li>
                                        @foreach ($userEmail as $item)
                                            <li class="ms-3">
                                                <div class="form-check">
                                                    <input class="form-check-input email-option" type="checkbox" id="email_{{ $item->id }}" name="toEmail[]" value="{{ $item->email }}">
                                                    <label class="form-check-label" for="email_{{ $item->id }}"> {{ $item->email }} </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                
                            <!-- Subject -->
                            <div class="mb-3">
                                <label for="subject" class="form-label">Tiêu đề:</label>
                                <input type="text" id="subject" name="subject" class="form-control" placeholder="Tiêu đề">
                            </div>
                
                            <!-- Message Body -->
                            <div class="mb-3">
                                <label for="message" class="form-label">Tin nhắn:</label>
                                {{-- <textarea id="message" class="form-control" rows="4" placeholder="Write your message here"></textarea> --}}
                                <textarea class="ckeditor-classic" id="message" name="message"></textarea>
                                {{-- <textarea class="snow-editor" style="height: 300px;" id="message" name="message"></textarea> --}}
                            </div>

                            <input type="hidden" name="scheduleDate" id="hiddenScheduleDate">
                
                            <!-- Footer Buttons -->
                            <div class="d-flex justify-content-start align-items-center">
                                <button type="reset" class="btn btn-ghost-danger waves-effect waves-light me-3">Xóa bỏ</button>
                
                                <!-- Send Button with Dropdown -->
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success">Gửi</button>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" style="border-radius: 0 4px 4px 0 " data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="visually-hidden"></span> {{--mũi tên trỏ xuống --}}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#scheduleSendModal">
                                                <i class="ri-timer-line me-2"></i> Lịch trình gửi
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Schedule Send Modal -->
                    <div class="modal fade" id="scheduleSendModal" tabindex="-1" aria-labelledby="scheduleSendLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scheduleSendLabel">Lịch trình gửi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="scheduleDate" class="form-label">Chọn ngày và giờ:</label>
                                    <input type="datetime-local" id="scheduleDate" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="button" class="btn btn-primary" onclick="scheduleSend()">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
</div>

<!-- Success Modal -->
@if(session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Thành công</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Error Modal -->
@if(session('error'))
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Lỗi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('error') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@section('script_libray')
    <!--ckeditor js-->
    {{-- <script src="{{ asset('theme/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script> --}}
    <!-- mailbox init -->
    {{-- <script src="{{ asset('theme/assets/js/pages/mailbox.init.js') }}"></script> --}}


    {{-- <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script> --}}

    <!-- ckeditor -->
    <script src="{{ asset('theme/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <!-- quill js -->
    <script src="{{ asset('theme/assets/libs/quill/quill.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ asset('theme/assets/js/pages/form-editor.init.js') }}"></script>
@endsection

@section('scripte_logic')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const emailOptions = document.querySelectorAll('.email-option');
            const emailSearch = document.getElementById('emailSearch');
            const emailDropdown = document.getElementById('emailDropdown');
            const allEmailsOption = document.getElementById('allEmails');

            // Cập nhật ô input khi chọn email
            emailOptions.forEach(option => {
                option.addEventListener('change', () => {
                    const selectedEmails = Array.from(emailOptions)
                        .filter(opt => opt.checked && opt !== allEmailsOption)
                        .map(opt => opt.nextElementSibling.innerText);

                    // Logic cho "Tất cả"
                    if (allEmailsOption.checked) {
                        emailOptions.forEach(opt => opt.checked = true); // Chọn tất cả
                        emailSearch.value = "Tất cả"; // Cập nhật ô input
                    } else {
                        emailSearch.value = selectedEmails.join(', ') || ''; // Hiển thị các email đã chọn
                    }
                });
            });

            // Tự động bỏ chọn "Tất cả" nếu chọn mục khác
            allEmailsOption.addEventListener('change', () => {
                if (allEmailsOption.checked) {
                    // Nếu chọn "Tất cả", chọn tất cả các email khác
                    emailOptions.forEach(opt => {
                        if (opt !== allEmailsOption) {
                            opt.checked = true;
                        }
                    });
                    emailSearch.value = "Tất cả"; // Cập nhật ô input
                } else {
                    // Nếu bỏ chọn "Tất cả", bỏ chọn tất cả các email khác
                    emailOptions.forEach(opt => opt.checked = false);
                    emailSearch.value = ''; // Xóa ô input
                }
            });

            // Tìm kiếm trong dropdown
            emailSearch.addEventListener('input', () => {
                const searchTerm = emailSearch.value.toLowerCase();

                // Lọc các mục theo từ khóa
                Array.from(emailDropdown.querySelectorAll('.form-check')).forEach(item => {
                    const label = item.querySelector('.form-check-label').innerText.toLowerCase();
                    if (label.includes(searchTerm)) {
                        item.parentElement.style.display = ''; // Hiển thị nếu khớp
                    } else {
                        item.parentElement.style.display = 'none'; // Ẩn nếu không khớp
                    }
                });
            });
        });

        // Modal thông báo
        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('successModal')) {
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            }

            if (document.getElementById('errorModal')) {
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            }
        });

        // Gửi mail theo lịch trình
        function scheduleSend() {
            const scheduleDate = document.getElementById('scheduleDate').value;
            document.getElementById('hiddenScheduleDate').value = scheduleDate;
            document.getElementById('sendEmailForm').submit();
        }


    </script>
@endsection