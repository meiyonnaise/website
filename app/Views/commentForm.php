
<?php echo form_open(base_url().'course/'.$course.'/posts/'.$postID.'/addComment'); ?>
    <h2 class="text-left">Add a comment</h2>       
        <div class="form-group">
            <input  type="text" class="form-control" placeholder="Your Comment" required="required" name="addComment">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block bg-dark">Post</button>
        </div>
<?php echo form_close(); ?>

