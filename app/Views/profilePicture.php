<div class = "container-fluid">

    <div class = "row">
        
        <div class = "col-md-4">
        <?php if (isset($image_url)) { ?>
            <img src="<?php echo $original; ?>" alt="Profile picture">
        <?php } ?>
            <p> Profile pic </p>
            <?php echo form_open_multipart(base_url()."profile/imageUpload")?>
            <div class="form-group">
                <label for="image">Update profile picture</label>
                <input type="file" name="image" id="image">
            </div>
            <button type="submit">Upload</button>
            <?php echo form_close() ?>