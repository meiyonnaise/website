<body>
    <?php
    $uri = uri_string();
    $course = explode("/", $uri)[1];
    ?>
    <div class="container drop_zone" width="500" height="500">
        <label for="title"> Title </label>
        <input type="text" name="title" id="title">
        <p>
            <label for="question"> Question </label>
            <textarea rows="5" cols="30" name="question" id="question"> </textarea><br>
        </p>
        <!-- <input type="file" name="files[]" id="files" multiple>
        <label for="files"> Choose Or Drop Photos </label> -->
        <p> Drop one or more files! </p>
        <button type="submit" class="btn btn-primary" id="postQuestionButton">Post Question</button>
    </div>
</body>