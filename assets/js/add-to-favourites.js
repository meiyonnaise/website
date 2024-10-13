const addToFavourites = (idOfPost) => {
    const addToFavouritesButton = document.getElementById('addToFavourites');
    const formData = new FormData();

    const course = window.location.pathname.split('/')[3];
    const request = new XMLHttpRequest();
    request.open("POST", `https://infs3202-5b41c573.uqcloud.net/demo/course/${course}/addToFavourites`);

    addToFavouritesButton.addEventListener("click", function () {
        // need to get the post ID, and send the postID to controller.
        formData.append('postId', idOfPost);
        request.onload = function() {
            window.location.reload();
        }
        request.send(formData);

    });
}