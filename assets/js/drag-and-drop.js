let formData = new FormData();

const handleDrop = (e) => {
    e.preventDefault();
    const files = e.dataTransfer.files;
    const fileArray = Array.from(files);
    console.log(fileArray);

    fileArray.forEach((file, index) => {
        formData.append('files[' + index + ']', file);
    });
}
// Gets the title and question and uploads the title and question as well as any files to Course Controller.
const getText = () => {
    const postButton = document.getElementById('postQuestionButton');

    const course = window.location.pathname.split('/')[3];
    const request = new XMLHttpRequest();
    request.open("POST", `https://infs3202-5b41c573.uqcloud.net/demo/course/${course}/processCreatePost`);

    postButton.addEventListener("click", function () {
        const title = document.getElementById('title').value;
        const question = document.getElementById('question').value;
        formData.append('title', title);
        formData.append('question', question);
        request.onload = function () {
                window.location.reload(); // reload the page
        }
        request.send(formData);
        formData = new FormData();
    });
}

const initApp = () => {
    const dropArea = document.querySelector(".drop_zone");
    const active = () => dropArea.classList.add("border-warning", "border-3");
    const inactive = () => {
        dropArea.classList.remove("border-warning", "border-3");
        dropArea.classList.add("border-primary", "border-3");
    }

    const prevents = (e) => e.preventDefault();

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evtName => {
        dropArea.addEventListener(evtName, prevents);
    });

    ['dragenter', 'dragover'].forEach(evtName => {
        dropArea.addEventListener(evtName, active);
    });

    ['dragleave', 'drop'].forEach(evtName => {
        dropArea.addEventListener(evtName, inactive);
    });

    dropArea.addEventListener("drop", handleDrop);
}