<?php
/** @var \Newsite\Models\Entities\NewsEntity $news */

?>
<?php
echo '<pre>';
print_r($news);
echo '</pre>';
?>
<div class="content_container">
	<?php foreach ($news as $new):?>
	<div class="posts_container">
		<div class="post_container">
			<div class="post_menu">
				<div class="post_menu_author">
					<img class="post_menu_author__photo" src="/public/img/layout_img/user_photo__test.jpg" alt="author_photo">
					<div class="post_menu_author__name">
						<?= $new->getName()?>
					</div>
					<div class="post_menu_author__surname">
						<?= $new->getSurname()?>
					</div>
					<div class="post_menu_author__date">
						<?= $new->getDateUpdate() ?>
					</div>
					<div class="post_menu_settings">
						<img src="/public/img/icons/star.svg" alt="settings">
					</div>
				</div>

			</div>
			<a class="post_title__a" href="/posts">
				<div class="post_title">
					<?= $new->getTitle() ?>
				</div>
			</a>
			<div class="post_description">
				<?= $new->getDescription() ?>
			</div>
			<div class="post_tags">
				<?php  $tagsArray = explode(',',$new->getTags());?>
				<?php foreach ($tagsArray as $tag):?>
					<a class="post_tags__tag_link" href="#<?php echo $tag ?>"><span class="post_tags__tag"><?php echo $tag ?></span></a>
				<?php endforeach;?>
			</div>
		</div>
		<?php endforeach;?>

	</div>
</div>