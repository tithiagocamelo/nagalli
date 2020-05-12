<div class="row" id="fotos">
<?php if($module == 0) {$largura = 3;$i = 3;} else { $i = 2;$largura = 4; }
	
	foreach ($banners as $banner) { ?>
  <div class="col-lg-<?php echo $largura; ?> col-sm-<?php echo $largura; ?> col-md-<?php echo $largura; ?> col-xs-<?php echo $largura; ?>">
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" class="img-responsive"></a>
  </div>
<?php if($i==0){break;} $i--; } ?>
</div>

<?php if(false) { ?>
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
<?php } ?>
<script type="text/javascript"><!--
$('#carousel<?php echo $module; ?>').owlCarousel({
	items: 6,
	autoPlay: 3000,
	navigation: true,
	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
	pagination: true
});
--></script>