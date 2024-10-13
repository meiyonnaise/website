<!DOCTYPE html>
<html lang="en">

<?php
$uri = uri_string();
$course = explode("/", $uri)[1];
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INFS3202 Project</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <script src="<?php echo base_url(); ?>assets/js/drag-and-drop.js" defer></script>
    <script src="<?php echo base_url(); ?>assets/js/add-to-favourites.js" defer></script>
    <script src="<?php echo base_url(); ?>assets/js/search-for-post.js" defer></script>
</head>

<!-- Displays the search bar and New Post button. -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 ">
            <br>
            <p> <input class="form-control mr-sm-2" type="search" id="search" placeholder="Search" aria-label="Search"> </p>
            <div id="suggestions" class="suggestion-box"> </div>
            <p> <button class="btn input-block-level form-control btn-outline-success my-2 my-sm-0 " id="createPost"> New Post </button> </p>
            <?php foreach ($id as $post) : ?>
                <div class="mb-3">
                    <button class="coursePost btn input-block-level form-control btn-outline-primary" data-id="<?php echo $post['id']; ?>" data-title="<?php echo $post['title']; ?>"> <?php echo $post['title']; ?> </button>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Displays the posts, comments and comment form -->
        <div class="col-md-8">
            <br>
            <div id="createPost-info"></div>
            <?php if (isset($specificPost)) { ?>
                <div id="specificPost">
                    <h2> <?php echo $specificPost['title'] ?> </h2>
                    <p class="text-secondary"> views: <?php echo $specificPost['numViews'] ?></p>
                    <button id='addToFavourites'> Add To Favourite </Button>
                    <p> <?php echo $specificPost['message'] ?> </p>
                </div>
            <?php } ?>

            <div id="post-info"></div>
            <div id="comments-info"></div>
            <div id="add-comments"></div>
            <div id="comment-form"></div>
        </div>
    </div>
</div>

<!-- This is to display the createPostForm -->
<script>
    const createPostInformation = document.getElementById("createPost-info");
    const createPostButton = document.getElementById("createPost");


    let requestCreatePost = new XMLHttpRequest();
    requestCreatePost.open('GET', '<?php echo base_url() . 'course/' . $course . '/showCreatePostForm'; ?>');
    requestCreatePost.responseType = "document";

    createPostButton.addEventListener("click", function() {
        let baseURL = "<?php echo base_url() ?>";
        let course = "<?php echo $course ?>";

        requestCreatePost.onload = function() {
            let response = requestCreatePost.response;
            let createPostContent = response.body.innerHTML;
            createPostInformation.innerHTML = createPostContent;
            initApp();
            getText();
        }
        requestCreatePost.send();
    });
</script>

<!-- This is to get the post information, comments and write a comment. -->
<script>
    const postInformation = document.getElementById("post-info");
    const specificPostInformation = document.getElementById("specificPost");
    const commentInformation = document.getElementById("comments-info");
    const addCommentInformation = document.getElementById("add-comments");
    const postButtons = document.getElementsByClassName("coursePost");

    <?php
    $uri = uri_string();
    $course = explode("/", $uri)[1];
    ?>

    for (var i = 0; i < postButtons.length; i++) {
        postButtons[i].addEventListener("click", function() {
            var idOfPost = this.getAttribute("data-id");
            var requestPosts = new XMLHttpRequest();
            var requestIncreaseViews = new XMLHttpRequest();
            var requestComments = new XMLHttpRequest();
            var requestAddComment = new XMLHttpRequest();

            var baseURL = "<?php echo base_url() ?>";
            var course = "<?php echo $course ?>";

            // remove specific post.

            if (specificPostInformation != null) {
                specificPostInformation.innerHTML = "";
            }

            requestPosts.open('GET', '<?php echo base_url() . 'course/' . $course . '/posts'; ?>');
            requestPosts.responseType = 'json';

            requestIncreaseViews.open('POST', '<?php echo base_url() . 'course/' . $course . '/postsIncr/'; ?>' + idOfPost);

            requestComments.open('GET', ' <?php echo base_url() . 'course/' . $course . '/comments'; ?>');
            requestComments.responseType = 'json';

            requestAddComment.open('GET', `${baseURL}course/${course}/posts/${idOfPost}/getForm`);
            requestAddComment.responseType = 'text';

            requestPosts.onload = function() {
                var responsePosts = requestPosts.response;
                var postContent = "";

                for (var i = 0; i < responsePosts.length; i++) {
                    if (responsePosts[i].id === idOfPost) {
                        postContent += "<h2 class='container p-3 my-3 bg-dark text-white'>" + responsePosts[i].title + "</h2>" + " <p class='text-secondary'>" +
                            "views: " + responsePosts[i].numViews + "</p>" + "<button id = 'addToFavourites' > Add To Favourite </Button>";
                        postContent += "<p>" + responsePosts[i].message + "</p>";
                    }
                }

                postInformation.innerHTML = postContent;

                addToFavourites(idOfPost);

                requestComments.onload = function() {
                    var responseComments = requestComments.response;
                    var commentContent = "";
                    commentContent += "<h3> Comment Section </h3>";

                    for (var i = 0; i < responseComments.length; i++) {
                        if (responseComments[i].postID === idOfPost) {
                            commentContent += "<h4>" + responseComments[i].firstName + " " + responseComments[i].lastName + "</h4>";
                            commentContent += "<p>" + responseComments[i].comment + "</p>";
                        }
                    }

                    commentInformation.innerHTML = commentContent;

                    requestAddComment.onload = function() {
                        var responseAddComment = requestAddComment.response;
                        addCommentInformation.innerHTML = responseAddComment;

                    }
                    requestAddComment.send();
                }
                requestComments.send();
            };
            requestIncreaseViews.send();
            requestPosts.send();

        });

    };
</script>