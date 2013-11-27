<div id="sidebar">
<h2>Categories</h2>
<ul>
<?php
$sql = "SELECT * FROM news_cat";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
?>
<li><a href="<?php echo base_url(); ?>news/category/<?php echo $row['id']; ?>"><?php echo $row['category']; ?></a></li>
<?php } ?>
</ul>
</div>