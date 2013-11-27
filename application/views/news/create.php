<h2>Create a news item</h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('news/create') ?>

	<label for="title">Title</label><br />
	<input type="input" name="title" /><br />

	<label for="category">Category</label><br />
	<select name="category" id="category">
<?php
$sql = "SELECT * FROM news_cat";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['category']; ?></option>
<?php } ?>
	</select><br />

	<label for="text">Text</label><br />
	<textarea name="text"></textarea><br />
	
	<label for="text">Image</label><br />
	<input type="file" name="userfile" size="20" /><br />

	<input type="submit" name="submit" value="Create news item" /> 

</form>