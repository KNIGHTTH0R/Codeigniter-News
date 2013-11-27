<h1>Dashboard</h1>
<h2>News Admin</h2>
<table width="100%" border="0">
  <tr>
    <td>ID</td>
    <td>TITLE</td>
    <td>EDIT</td>
    <td>DELETE</td>
  </tr>
<?php foreach ($records as $item):?>
<tr>
<td><a href="<?php echo base_url(); ?>news/story/<?php echo $item['id'];?>"><?php echo $item['id'];?></a></td>
<td><a href="<?php echo base_url(); ?>news/story/<?php echo $item['id'];?>"><?php echo $item['title'];?></a></td>
<td><a href="<?php echo base_url(); ?>news/update/<?php echo $item['id'];?>">Edit</a></td>
<td><a href="<?php echo base_url(); ?>news/delete/<?php echo $item['id'];?>" onclick="return confirm('Do you really want to delete this story?')">Delete</a></td>
</tr>
<?php endforeach;?>
</table>
<?php echo $this->pagination->create_links(); ?>

<h2>Categories</h2>
<table width="100%" border="0">
  <tr>
    <td>ID</td>
    <td>TITLE</td>
    <td>EDIT</td>
    <td>DELETE</td>
  </tr>
<?php
$sql = "SELECT * FROM news_cat";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
?>
<tr>
<td><a href="<?php echo base_url(); ?>news/category/<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
<td><a href="<?php echo base_url(); ?>news/category/<?php echo $row['id']; ?>"><?php echo $row['category']; ?></a></td>
<td><a href="<?php echo base_url(); ?>news/updatecategory/<?php echo $row['id']; ?>">EDIT</a></td>
<td><a href="<?php echo base_url(); ?>news/deletecategory/<?php echo $row['id']; ?>" onclick="return confirm('Do you really want to delete this category?')">DELETE</a></td>
</tr>
<?php } ?>
</table>

<h2>Users</h2>
<p>Below is a list of the users.</p>

<div id="infoMessage"><?php echo $message;?></div>

<table width="100%" cellpadding=0 cellspacing=10>
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Groups</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	<?php foreach ($users as $user):?>
		<tr>
			<td><?php echo $user->first_name;?></td>
			<td><?php echo $user->last_name;?></td>
			<td><?php echo $user->email;?></td>
			<td>
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
                <?php endforeach?>
			</td>
			<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, 'Active') : anchor("auth/activate/". $user->id, 'Inactive');?></td>
			<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
		</tr>
	<?php endforeach;?>
</table>

<p><a href="<?php echo site_url('auth/create_user');?>">Create a new user</a> | <a href="<?php echo site_url('auth/create_group');?>">Create a new group</a></p>