var previewTemplate,
    dropzone,
    dropzonePreviewNode = document.querySelector("#dropzone-preview-list"),
    inputMultipleElements =
        ((dropzonePreviewNode.id = ""),
        dropzonePreviewNode &&
            ((previewTemplate = dropzonePreviewNode.parentNode.innerHTML),
            dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode),
            (dropzone = new Dropzone(".dropzone", {
                url: "https://httpbin.org/post",
                method: "post",
                previewTemplate: previewTemplate,
                previewsContainer: "#dropzone-preview",
            }))),
        FilePond.registerPlugin(
            FilePondPluginFileEncode,
            FilePondPluginFileValidateSize,
            FilePondPluginImageExifOrientation,
            FilePondPluginImagePreview
        ),
        document.querySelectorAll("input.filepond-input-multiple"));
inputMultipleElements &&
    (Array.from(inputMultipleElements).forEach(function (e) {
        FilePond.create(e);
    }),
    FilePond.create(document.querySelector(".filepond-input-circle"), {
        labelIdle:
            'Drag & Drop your picture or <span class="filepond--label-action">Browse</span>',
        imagePreviewHeight: 170,
        imageCropAspectRatio: "1:1",
        imageResizeTargetWidth: 200,
        imageResizeTargetHeight: 200,
        stylePanelLayout: "compact circle",
        styleLoadIndicatorPosition: "center bottom",
        styleProgressIndicatorPosition: "right bottom",
        styleButtonRemoveItemPosition: "left bottom",
        styleButtonProcessItemPosition: "right bottom",
    }));



dropzone.on("addedfile", function(file) {
    // Lấy tất cả các checkbox is_main
    const checkboxes = document.querySelectorAll(".is-main-checkbox");

    // Thêm sự kiện change cho từng checkbox
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            // Nếu checkbox này được chọn, bỏ chọn các checkbox khác
            if (checkbox.checked) {
                checkboxes.forEach(cb => {
                    if (cb !== checkbox) {
                        cb.checked = false;
                    }
                });
                console.log("Main image set to: ", file.name); // Xử lý logic cho ảnh chính
            }
        });
    });
});
