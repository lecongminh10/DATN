@extends('admin.layouts.app')
@section('style_css')
    <style>
        .chat-input-links {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.links-list-item {
    position: relative;
}

.emoji-btn {
    background-color: transparent;
    border: none;
    color: #007bff;
    font-size: 20px;
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 5px;
    transition: color 0.3s;
}

.emoji-btn:hover {
    color: #0056b3;
}

.emoji-btn .fa-paperclip {
    margin-right: 5px;
}

.file-browser {
    font-size: 1.2rem;
}

#fileInput {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
                <div class="chat-leftsidebar">
                    <div class="px-4 pt-4 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="mb-4">Chats</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom"
                                    title="Add Contact">

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-soft-success btn-sm">
                                        <i class="ri-add-line align-bottom"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="search-box">
                            <input type="text" class="form-control bg-light border-light" placeholder="Search here...">
                            <i class="ri-search-2-line search-icon"></i>
                        </div>
                    </div> <!-- .p-4 -->

                    <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#chats" role="tab">
                                Chats
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#contacts" role="tab">
                                Contacts
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="chats" role="tabpanel">
                            <div class="chat-room-list pt-3" data-simplebar>

                                <div class="chat-message-list">

                                    <ul class="list-unstyled chat-list chat-user-list" id="userList">
                                        @foreach ($users as $item)
                                            @php
                                                if ($item->profile_picture !== null) {
                                                    $avatar = Storage::url($item->profile_picture);
                                                } else {
                                                    $avatar = '/theme/assets/images/users/avatar-3.jpg';
                                                }
                                            @endphp
                                            <li id="contact-id-{{ $item->id }}" class=""
                                                data-id="{{ $item->id }}" data-name="{{ $item->username }}"
                                                data-avatar={{ $avatar }}>
                                                <a href="javascript: void(0);" class="unread-msg-user">
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                            <div class="avatar-xxs"> <img src="{{ $avatar }}"
                                                                    class="rounded-circle img-fluid userprofile"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-truncate mb-0">{{ $item->username }}</p>
                                                        </div>

                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="chat-message-list">

                                    <ul class="list-unstyled chat-list chat-user-list mb-0" id="channelList">
                                    </ul>
                                </div>
                                <!-- End chat-message-list -->
                            </div>
                        </div>
                        <div class="tab-pane" id="contacts" role="tabpanel">
                            <div class="chat-room-list pt-3" data-simplebar>
                                <div class="sort-contact">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end tab contact -->
                </div>
                <!-- end chat leftsidebar -->
                <!-- Start User chat -->
                <div class="user-chat w-100 overflow-hidden">

                    <div class="chat-content d-lg-flex">
                        <!-- start chat conversation section -->
                        <div class="w-100 overflow-hidden position-relative">
                            <!-- conversation user -->
                            <div class="position-relative">


                                <div class="position-relative" id="users-chat">
                                    <div class="p-3 user-chat-topbar">
                                        <div class="row align-items-center">
                                            <div class="col-sm-4 col-8">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 d-block d-lg-none me-3">
                                                        <a href="javascript: void(0);" class="user-chat-remove fs-18 p-1"><i
                                                                class="ri-arrow-left-s-line align-bottom"></i></a>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                                <img src="" class="rounded-circle avatar-xs"
                                                                    id="avartar-xs" alt="">
                                                                <span class="user-status"></span>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <h5 class="text-truncate mb-0 fs-16"><a
                                                                        class="text-reset username"
                                                                        data-bs-toggle="offcanvas"
                                                                        href="#userProfileCanvasExample"
                                                                        aria-controls="userProfileCanvasExample"
                                                                        id="usernampo">
                                                                    </a></h5>
                                                                <p class="text-truncate text-muted fs-14 mb-0 userStatus">
                                                                    <small>Online</small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-8 col-4">
                                                <ul class="list-inline user-chat-nav text-end mb-0">
                                                    <li class="list-inline-item m-0">
                                                        <div class="dropdown">
                                                            <button class="btn btn-ghost-secondary btn-icon" type="button"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <i data-feather="search" class="icon-sm"></i>
                                                            </button>
                                                            <div
                                                                class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                                                                <div class="p-2">
                                                                    <div class="search-box">
                                                                        <input type="text"
                                                                            class="form-control bg-light border-light"
                                                                            placeholder="Search here..."
                                                                            onkeyup="searchMessages()" id="searchMessage">
                                                                        <i class="ri-search-2-line search-icon"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class="list-inline-item d-none d-lg-inline-block m-0">
                                                        <button type="button" class="btn btn-ghost-secondary btn-icon"
                                                            data-bs-toggle="offcanvas"
                                                            data-bs-target="#userProfileCanvasExample"
                                                            aria-controls="userProfileCanvasExample">
                                                            <i data-feather="info" class="icon-sm"></i>
                                                        </button>
                                                    </li>

                                                    <li class="list-inline-item m-0">
                                                        <div class="dropdown">
                                                            <button class="btn btn-ghost-secondary btn-icon"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <i data-feather="more-vertical" class="icon-sm"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item d-block d-lg-none user-profile-show"
                                                                    href="#"><i
                                                                        class="ri-user-2-fill align-bottom text-muted me-2"></i>
                                                                    View Profile</a>
                                                                <a class="dropdown-item" href="#"><i
                                                                        class="ri-inbox-archive-line align-bottom text-muted me-2"></i>
                                                                    Archive</a>
                                                                <a class="dropdown-item" href="#"><i
                                                                        class="ri-mic-off-line align-bottom text-muted me-2"></i>
                                                                    Muted</a>
                                                                <a class="dropdown-item" href="#"><i
                                                                        class="ri-delete-bin-5-line align-bottom text-muted me-2"></i>
                                                                    Delete</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- end chat user head -->
                                    <div class="chat-conversation p-3 p-lg-4 " id="chat-conversation" data-simplebar>

                                        <ul class="list-unstyled chat-conversation-list" id="users-conversation">

                                        </ul>

                                    </div>
                                    <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show "
                                        id="copyClipBoard" role="alert">
                                        Message copied
                                    </div>
                                </div>

                                <!-- end chat-conversation -->

                                <div class="chat-input-section p-3 p-lg-4">

                                    <form id="chatinput-form" enctype="multipart/form-data">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-auto">
                                                <div class="chat-input-links me-2">
                                                    <div class="links-list-item">
                                                        <button type="button"
                                                            class="btn btn-link text-decoration-none emoji-btn"
                                                            id="emoji-btn">
                                                            <i class="ri-image-add-fill"></i> <input type="file" id="fileInput" accept="image/*">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="chat-input-feedback">
                                                    Please Enter a Message
                                                </div>

                                                <input type="hidden" id="idUser" name="idUser">

                                                <input type="text"
                                                    class="form-control chat-input bg-light border-light" id="chat-input"
                                                    placeholder="Type your message..." autocomplete="off">
                                            </div>
                                            <div class="col-auto">
                                                <div class="chat-input-links ms-2">
                                                    <div class="links-list-item">
                                                        <button type="submit"
                                                            class="btn btn-success chat-send waves-effect waves-light">
                                                            <i class="ri-send-plane-2-fill align-bottom"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>

                                <div class="replyCard">
                                    <div class="card mb-0">
                                        <div class="card-body py-3">
                                            <div class="replymessage-block mb-0 d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <h5 class="conversation-name"></h5>
                                                    <p class="mb-0"></p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <button type="button" id="close_toggle"
                                                        class="btn btn-sm btn-link mt-n2 me-n3 fs-18">
                                                        <i class="bx bx-x align-middle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end chat-wrapper -->



        </div>
    </div>
@endsection
@section('script_libray')
    @vite('resources/js/app.js')
    <script src="{{ asset('theme/assets/libs/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('theme/assets/libs/fg-emoji-picker/fgEmojiPicker.js') }}"></script>
    <script src="{{ asset('theme/assets/js/pages/chat.init.js') }}"></script>
@endsection

@section('scripte_logic')
    <script type="module">
        const form = document.getElementById('chatinput-form');
        const chatInput = document.getElementById('chat-input');
        const idUser = document.getElementById('idUser');
        const userIdAdmin = @json(Auth::user()->id);

        document.addEventListener("DOMContentLoaded", () => {
            const listItems = document.querySelectorAll('li[data-id]');
            const userDisplayName = document.getElementById('usernampo');
            let currentChannel = null;

            listItems.forEach(item => {
                item.addEventListener('click', () => {
                    const chatList = document.getElementById('users-conversation'); 
                    chatList.innerHTML = ''; 
                    const userId = item.getAttribute('data-id');
                    const userName = item.getAttribute('data-name');
                    const avatarUser = item.getAttribute('data-avatar');
                    getDataChatMessageUserById(userId ,avatarUser);
                    document.getElementById("avartar-xs").src = avatarUser
                    idUser.value = userId;
                    userDisplayName.textContent = userName;

                    if (currentChannel) {
                        currentChannel.stopListening('MessageSent');
                    }

                    form.addEventListener('submit', async (event) => {
                        event.preventDefault();
                        const fileInput = document.getElementById('fileInput');
                        const file = fileInput.files[0]; // Lấy tệp được tải lên
                        const message = chatInput.value.trim();
                        let formData = new FormData();
                        formData.append('message', message);
                        formData.append('receiver_id', userId);
                        if(file){
                            formData.append('file', file); 
                        }

                        if (message || file) {
                            try {
                                await axios.post('/chat/send-message',formData ,{
                                    headers: {
                                        'Content-Type': 'multipart/form-data', // Đảm bảo gửi dưới dạng form data
                                    },
                                });
                                chatInput.value = ''; // Clear the input field
                            } catch (error) {
                                console.error('Error sending message:', error);
                            }
                        }
                    });
                    Echo.private(`chat.` + userId)
                        .listen('MessageSent', (e) => {
                            console.log(e);
                            
                            renderMessage(e, userIdAdmin, userId)
                        });
                });
            });
        });

        function renderMessage(e, userIdAdmin, idUser) {
            if (e !== null) {
                const messageElement = document.createElement('li');
                messageElement.classList.add('chat-list');

                // Phân loại class dựa trên người gửi và người nhận
                if (e.sender.id === userIdAdmin) {
                    messageElement.classList.add('right', 'my-2');
                }
                if (e.receiver.id === idUser) {
                    messageElement.classList.add('left', 'my-2');
                }
                messageElement.innerHTML = `
                    <div class="conversation-list">
                        ${e.sender.id !== userIdAdmin ? `
                                                <div class="chat-avatar">
                                                    <img src="{{ Storage::url('${e.sender.profile_picture}') }}" alt="">
                                                </div>
                                            ` : ''}
                        <div class="user-chat-content">
                            <div class="ctext-wrap">
                                <div class="ctext-wrap-content" id="${e.id}">
                                    <p class="mb-0 ctext-content">${e.message}</p>
                                </div>
                                <div class="dropdown align-self-start message-box-drop">
                                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-more-2-fill"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item reply-message" href="#"><i class="ri-reply-line me-2 text-muted align-bottom"></i>Reply</a>
                                        <a class="dropdown-item" href="#"><i class="ri-share-line me-2 text-muted align-bottom"></i>Forward</a>
                                        <a class="dropdown-item copy-message" href="#"><i class="ri-file-copy-line me-2 text-muted align-bottom"></i>Copy</a>
                                        <a class="dropdown-item" href="#"><i class="ri-bookmark-line me-2 text-muted align-bottom"></i>Bookmark</a>
                                        <a class="dropdown-item delete-item" href="#"><i class="ri-delete-bin-5-line me-2 text-muted align-bottom"></i>Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="conversation-name">
                                <span class="d-none name">${e.sender.name}</span>
                                <small class="text-muted time">${formatDateTime(new Date())}</small>
                                ${e.sender.id === userIdAdmin ? `
                                                        <span class="text-success check-message-icon">
                                                            <i class="bx bx-check-double"></i>
                                                        </span>
                                                    ` : ''}
                            </div>
                        </div>
                    </div>
                `;

                // Gắn phần tử vào danh sách chat
                const chatList = document.getElementById('users-conversation'); // Đảm bảo bạn có id này trong DOM
                chatList.appendChild(messageElement);

                if(e.image!==null){
                    const messageElementPath = document.createElement('li');
                    messageElementPath.classList.add('chat-list');
                    if (e.sender.id === userIdAdmin) {
                        
                        messageElementPath.classList.add('right', 'my-2');
                    } else {
                        messageElementPath.classList.add('left', 'my-2');
                    }

                    messageElementPath.innerHTML = `
                <div class="conversation-list">
                                        ${e.sender.id !== userIdAdmin ? `
                                            <div class="chat-avatar">
                                                <img src="{{ Storage::url('${e.sender.profile_picture}') }}" alt="">
                                            </div>
                                        ` : ''}
                    <div class="user-chat-content">
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content" id="${e.id}">
                               <img src="{{ Storage::url('${e.image}') }}" alt="message-image" class="img-fluid" width="200px" height="auto"/>
                            </div>
                            <div class="dropdown align-self-start message-box-drop">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item reply-message" href="#"><i class="ri-reply-line me-2 text-muted align-bottom"></i>Reply</a>
                                    <a class="dropdown-item" href="#"><i class="ri-share-line me-2 text-muted align-bottom"></i>Forward</a>
                                    <a class="dropdown-item copy-message" href="#"><i class="ri-file-copy-line me-2 text-muted align-bottom"></i>Copy</a>
                                    <a class="dropdown-item" href="#"><i class="ri-bookmark-line me-2 text-muted align-bottom"></i>Bookmark</a>
                                    <a class="dropdown-item delete-item" href="#"><i class="ri-delete-bin-5-line me-2 text-muted align-bottom"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                        <div class="conversation-name">
                            <span class="d-none name">${e.sender_name || 'Unknown'}</span>
                            <small class="text-muted time">${formatDateTime(new Date())}</small>
                            ${e.sender.id === userIdAdmin ? `
                                                        <span class="text-success check-message-icon">
                                                            <i class="bx bx-check-double"></i>
                                                        </span>
                                                    ` : ''}
                        </div>
                    </div>
                </div>
            `;

                    // Gắn phần tử vào danh sách chat
                    chatList.appendChild(messageElementPath);
                }

                // Cuộn xuống cuối danh sách
                chatList.scrollTop = chatList.scrollHeight;
            }
            
        }

        async function getDataChatMessageUserById(userId,avatarUser) {
            let url = '{{ route('chat.getDataChatAdmin') }}';
            try {
                const response = await axios.post(url, {
                    userId: userId,
                    _token: '{{ csrf_token() }}'
                });

                const data = response.data[1]; 
                renderMessageData(data,avatarUser);
            } catch (error) {
                console.error('Error fetching chat messages:', error);
            }
        }

        function renderMessageData(data,avatarUser) {
            const chatList = document.getElementById('users-conversation');  
            chatList.innerHTML = ''; 

            data.forEach((e) => {
                console.log(e);
                
                if (e !== null) {
                    const messageElement = document.createElement('li');
                    messageElement.classList.add('chat-list');
                    if (e.sender_id === userIdAdmin) {
                        messageElement.classList.add('right', 'my-2');
                    } else {
                        messageElement.classList.add('left', 'my-2');
                    }

                    messageElement.innerHTML = `
                <div class="conversation-list">
                    ${e.sender_id !== userIdAdmin ? `
                                            <div class="chat-avatar">
                                                <img src="${avatarUser || 'assets/images/users/avatar-1.jpg'}" alt="">
                                            </div>
                                        ` : ''}
                    <div class="user-chat-content">
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content" id="${e.id}">
                                <p class="mb-0 ctext-content">${e.message}</p>
                            </div>
                            <div class="dropdown align-self-start message-box-drop">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item reply-message" href="#"><i class="ri-reply-line me-2 text-muted align-bottom"></i>Reply</a>
                                    <a class="dropdown-item" href="#"><i class="ri-share-line me-2 text-muted align-bottom"></i>Forward</a>
                                    <a class="dropdown-item copy-message" href="#"><i class="ri-file-copy-line me-2 text-muted align-bottom"></i>Copy</a>
                                    <a class="dropdown-item" href="#"><i class="ri-bookmark-line me-2 text-muted align-bottom"></i>Bookmark</a>
                                    <a class="dropdown-item delete-item" href="#"><i class="ri-delete-bin-5-line me-2 text-muted align-bottom"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                        <div class="conversation-name">
                            <span class="d-none name">${e.sender_name || 'Unknown'}</span>
                            <small class="text-muted time">${formatDateTime(e.created_at)}</small>
                            ${e.sender_id === userIdAdmin ? `
                                                        <span class="text-success check-message-icon">
                                                            <i class="bx bx-check-double"></i>
                                                        </span>
                                                    ` : ''}
                        </div>
                    </div>
                </div>
            `;

                    // Gắn phần tử vào danh sách chat
                    chatList.appendChild(messageElement);

                    if(e.media_path!==null){
                    const messageElementPath = document.createElement('li');
                    messageElementPath.classList.add('chat-list');
                    if (e.sender_id === userIdAdmin) {
                        messageElementPath.classList.add('right', 'my-2');
                    } else {
                        messageElementPath.classList.add('left', 'my-2');
                    }

                    messageElementPath.innerHTML = `
                <div class="conversation-list">
                                        ${e.sender_id !== userIdAdmin ? `
                                            <div class="chat-avatar">
                                                <img src="${avatarUser || 'assets/images/users/avatar-1.jpg'}" alt="">
                                            </div>
                                        ` : ''}
                    <div class="user-chat-content">
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content" id="${e.id}">
                               <img src="{{ Storage::url('${e.media_path}') }}" alt="message-image" class="img-fluid" width="200px" height="auto"/>
                            </div>
                            <div class="dropdown align-self-start message-box-drop">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-more-2-fill"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item reply-message" href="#"><i class="ri-reply-line me-2 text-muted align-bottom"></i>Reply</a>
                                    <a class="dropdown-item" href="#"><i class="ri-share-line me-2 text-muted align-bottom"></i>Forward</a>
                                    <a class="dropdown-item copy-message" href="#"><i class="ri-file-copy-line me-2 text-muted align-bottom"></i>Copy</a>
                                    <a class="dropdown-item" href="#"><i class="ri-bookmark-line me-2 text-muted align-bottom"></i>Bookmark</a>
                                    <a class="dropdown-item delete-item" href="#"><i class="ri-delete-bin-5-line me-2 text-muted align-bottom"></i>Delete</a>
                                </div>
                            </div>
                        </div>
                        <div class="conversation-name">
                            <span class="d-none name">${e.sender_name || 'Unknown'}</span>
                            <small class="text-muted time">${formatDateTime(e.created_at)}</small>
                            ${e.sender_id === userIdAdmin ? `
                                                        <span class="text-success check-message-icon">
                                                            <i class="bx bx-check-double"></i>
                                                        </span>
                                                    ` : ''}
                        </div>
                    </div>
                </div>
            `;

                    // Gắn phần tử vào danh sách chat
                    chatList.appendChild(messageElementPath);
                }
                }
            });

            // Cuộn xuống cuối danh sách
            chatList.scrollTop = chatList.scrollHeight;
        }
        function formatDateTime(dateTime) {
            const date = new Date(dateTime);

            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); 
            const year = date.getFullYear();

            return `${hours}:${minutes}, ${day}-${month}-${year}`;
        }


        // Echo.join('usersonline')
        //     .here(users => {
        //         console.log('Users online:', users);
        //     })
        //     .joining(user => {
        //         console.log(`${user.username} joined the chat.`);
        //     })
        //     .leaving(user => {
        //         console.log(`${user.username} left the chat.`);
        //     })
        //     .listen('UserOnline', e => {
        //         console.log('UserOnline event received:', e);
        //     })
        //     .listen('UserOffline', e => {
        //         console.log('UserOffline event received:', e);
        //     });
    </script>
@endsection
