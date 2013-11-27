<?php foreach ($records as $item):?>
<div id="post">
<?php if (!empty($item['userfile'])) { ?>
<a href="<?php echo base_url(); ?>news/story/<?php echo $item['id'];?>" title="<?php echo $item['title']; ?>"><img id="featuredimg" src="<?php echo base_url(); ?>/uploads/<?php echo $item['userfile'];?>"></a>
<?php } ?>
<h1><a href="<?php echo base_url(); ?>news/story/<?php echo $item['id'];?>"><?php echo $item['title'];?></a></h1>
<?php $preview = substr($item['text'],0,250);  ?>
<?php echo $preview;?> 
... <a href="<?php echo base_url(); ?>news/story/<?php echo $item['id'];?>">Read More</a>
</div>
<?php endforeach;?>
<?php echo $this->pagination->create_links(); ?>