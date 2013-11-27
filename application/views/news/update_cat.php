<h2>Edit a category item</h2>
<?php echo validation_errors(); ?>
<?php if ($success){?>
<h3>Category successfully updated</h3>
<?php } ?>
<?php echo form_open_multipart('news/updatecategory/'.$cat_item['id']) ?>
    <label for="title">Category</label>
    <input type="input" name="category" value="<?php echo $cat_item['category'];?>" /><br />
    <input type="submit" name="submit" value="Update category item" />
    </form>