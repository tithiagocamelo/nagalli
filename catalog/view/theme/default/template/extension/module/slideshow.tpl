<!--<div id="slideshow<?php echo $module; ?>" class="owl-carousel" style="opacity: 1;">
  <?php foreach ($banners as $banner) { ?>
  <div class="item">
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
  </div>
  <?php } ?>
</div>
<script type="text/javascript">/*
$('#slideshow<?php echo $module; ?>').owlCarousel({
	items: 6,
	autoPlay: 3000,
  singleItem: true,
	navigation: true,
  navigationText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
  pagination: true
});
*/</script>-->

<div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
    
    <div class="carousel-inner" role="listbox">

      <?php $active='active'; foreach ($banners as $banner) { ?>
      <div class="item <?php print $active; $active=''; ?>">
        <?php if ($banner['link']) { ?>
            <a href="<?php echo $banner['link']; ?>" ><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
        <?php } else { ?>
            <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
        <?php } ?>
      </div>
      <?php } ?>
    </div>

    <a style="background-image: none; top: 50%; bottom: auto;width: 0;" class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span style="font-size: 40px;" class="fa fa-angle-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a style="background-image: none;top: 50%;right: 13px;width: 0;" class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span style="font-size: 40px;" class="fa fa-5x fa-angle-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>