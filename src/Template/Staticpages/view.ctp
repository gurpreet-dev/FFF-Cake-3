<?php 
if(!empty($page)){ ?>
<section class="st-about">
<div class="container">
<div class="text-center">
<h1 class="theme-heading"><?php echo $page->title; ?></h1>
</div>
</div>
<div class="overlay">&nbsp;</div>
</section>
<!--st-about-end-->
<?php
	echo str_replace('../../../images', $this->request->webroot.'images', $page->content);
}
?>