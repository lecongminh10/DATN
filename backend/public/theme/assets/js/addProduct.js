// Logic Attribute

document
    .getElementById("addAttributeButton")
    .addEventListener("click", function () {
        const attributeForm = document.getElementById("attributeForm");
        if (attributeForm.style.display === "flex") {
            attributeForm.style.display = "none";
            document.getElementById("addNewAttribute").style.display = "none";
        } else {
            attributeForm.style.display = "flex";
            document.getElementById("addNewAttribute").style.display = "block";
        }
    });

document
    .getElementById("selectImageButton")
    .addEventListener("click", function () {
        document.getElementById("imageInput").click();
    });

document
    .getElementById("imageInput")
    .addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                
                const imgElement = document.createElement("img");
                imgElement.src = e.target.result;
                imgElement.alt = "Selected Image";
                imgElement.style.maxWidth = "100px";
                imgElement.style.marginTop = "10px"; 
                document
                    .getElementById("attributeForm")
                    .appendChild(imgElement);
            };
            reader.readAsDataURL(file);
        }
    });

document
    .getElementById("addNewAttribute")
    .addEventListener("click", function () {
        const newAttributeForm = document.createElement("div");
        newAttributeForm.className = "row mb-3";
        newAttributeForm.innerHTML = `
            <div class="col-lg-4">
                <select class="form-select form-control mb-2">
                    <option value="">Chọn Attribute</option>
                    <option value="attribute1">Attribute 1</option>
                    <option value="attribute2">Attribute 2</option>
                    <option value="attribute3">Attribute 3</option>
                </select>
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-input form-control mb-2" placeholder="Nhập giá trị attribute">
            </div>
            <div class="col-lg-4">
                <input type="file" accept="image/*" style="display: none;">
                <button type="button" class="btn btn-secondary mb-2">Chọn Ảnh</button>
                <button type="button" class="btn btn-danger mb-2" id="removeButton">Xóa</button>
            </div>
        `;

        
        const selectImageButton =
            newAttributeForm.querySelector(".btn-secondary");
        selectImageButton.addEventListener("click", function () {
            const fileInput =
                newAttributeForm.querySelector('input[type="file"]');
            fileInput.click();
        });

        
        const removeButton = newAttributeForm.querySelector("#removeButton");
        removeButton.addEventListener("click", function () {
            newAttributeForm.remove();
        });

        document.getElementById("attributeForm").appendChild(newAttributeForm);
    });

// Logic gallery

// document
//     .getElementById("gallery_default")
//     .addEventListener("change", function (event) {
//         const previewContainer = document.getElementById("preview_container");
//         const mainImageInput = document.getElementById("is_main");
//         previewContainer.innerHTML = "";

//         const files = event.target.files;
//         if (files) {
//             for (let i = 0; i < files.length; i++) {
//                 const file = files[i];
//                 const reader = new FileReader();

//                 reader.onload = function (e) {
//                     const imgElement = document.createElement("img");
//                     imgElement.src = e.target.result;
//                     imgElement.alt = "Selected Image";

//                     const imageContainer = document.createElement("div");
//                     imageContainer.className = "image-container";

//                     const checkbox = document.createElement("input");
//                     checkbox.type = "checkbox";
//                     checkbox.className = "is_main_checkbox";
//                     checkbox.name = "is_main";
//                     checkbox.value = file.name;

//                     checkbox.addEventListener("change", function () {
//                         mainImageInput.value = checkbox.checked
//                             ? checkbox.value
//                             : "";

//                         imgElement.classList.toggle(
//                             "is-main",
//                             checkbox.checked
//                         );

//                         const checkboxContainer = checkbox.parentElement;
//                         if (checkbox.checked) {
//                             checkboxContainer.classList.add("active");
//                         } else {
//                             checkboxContainer.classList.remove("active");
//                         }

//                         const checkboxes =
//                             document.querySelectorAll(".is_main_checkbox");
//                         checkboxes.forEach((cb) => {
//                             if (cb !== checkbox) {
//                                 cb.checked = false;
//                                 cb.parentElement.classList.remove("active");
//                             }
//                         });
//                     });

                    
//                     const removeButton = document.createElement("button");
//                     removeButton.className = "remove-image";
//                     removeButton.innerHTML = "✖";
//                     removeButton.onclick = function () {
//                         imageContainer.remove();
                        
//                         if (checkbox.checked) {
//                             checkbox.checked = false;
//                             mainImageInput.value = "";
//                         }
//                     };

                    
//                     const checkboxContainer = document.createElement("div");
//                     checkboxContainer.className = "checkbox-container";
//                     checkboxContainer.appendChild(checkbox);
//                     imageContainer.appendChild(imgElement);
//                     imageContainer.appendChild(checkboxContainer);
//                     imageContainer.appendChild(removeButton);

//                     previewContainer.appendChild(imageContainer);
//                 };

//                 reader.readAsDataURL(file);
//             }
//         }
//     });


const choices = new Choices("#tags", {
    removeItemButton: true,
    maxItemCount: 3,
    searchResultLimit: 10,
    placeholder: true, 
    placeholderValue: "Add tags...",
});
