<h2>Add a category</h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('news/addcategory') ?>

	<label for="category">Category</label> 
	<input type="input" name="category" /><br />

	<input type="submit" name="submit" value="Create category" /> 

</form>