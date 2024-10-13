<!-- <?php var_dump($courseids); ?> -->
<div class =row>
    <?php foreach ($courseids as $course): ?>
    <div class = col-4>
        <div class = mb-3>
        <a href = "<?php echo base_url(); ?>course/<?php echo $course['courseid']; ?>" role = "button" class ="btn btn-success btn-block"> <?php echo $course['courseid']; ?></a>
    </div>
    </div>
    <?php endforeach; ?>
        
</div>
<?php $courses = ['COMP3400', 'INFS3202']?>




<div>
    <br><br>
    <h2> <label for = "course">Enrol in a course: </label></h2>
    <!-- Add a search bar and a button -->
    <?php echo form_open(base_url()."dashboard/enrol");?>

        <div class="autocompelte" style = "width:300px;">
            <input id="selectedCourse" type="text" name="selectedCourse" placeholder="Course ID">
            <button type="submit" class="btn btn-primary">Enrol</button>    
        </div>

    <?php echo form_close();?>
</div>
