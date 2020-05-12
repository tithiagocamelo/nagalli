<dir style="height: 381px; width: 1140px;">
<?php $i = 1; foreach ($banners as $banner) { ?>
  <div style="width: <?php print $i * 570 ?>px; float: left;">
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" style="max-width: 570px; max-height: 380px"></a>
  </div>
<?php if($i==0){break;} $i--; } ?>
</dir>

<!--<div id="carousel<?php echo $module; ?>" class="owl-carousel">
  <?php foreach ($banners as $banner) { ?>
  <div class="item text-center">
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
  </div>
  <?php } ?>
</div>-->
<script type="text/javascript"><!--
$('#carousel<?php echo $module; ?>').owlCarousel({
	items: 6,
	autoPlay: 3000,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: true
});
--></script>