<div id="post">
<?php if (!empty($news_item['userfile'])) { ?>
<img id="storyimage" src="<?php echo base_url(); ?>/uploads/<?php echo $news_item['userfile'];?>" title="<?php echo $news_item['title'];?>">
<?php } ?>
<h2><?php echo $news_item['title'];?></h2>
<?php echo $news_item['text'];?>
</div>