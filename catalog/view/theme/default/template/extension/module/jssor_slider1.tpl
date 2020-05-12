    <!-- Jssor Slider Begin -->
    <!-- You can move inline styles to css file or css block. --> 
    <div id="slider1_container" style="position: relative; width: 1140px;
        height: 380px; overflow: hidden;">
        <!-- Loading Screen --> 
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block; background-color: #000; top: 0px; left: 0px;width: 100%; height:100%;"> 
            </div> 
            <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center; top: 0px; left: 0px;width: 100%;height:100%;">
            </div> 
        </div> 
        <!-- Slides Container --> 
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1140px; height: 380px;
            overflow: hidden;">
            <?php foreach ($banners as $banner) { ?>
            	<?php if ($banner['link']) { ?>
                    <div>
                        <img u="image" src="<?php echo $banner['image']; ?>" />
                        <div u=caption t="*" class="captionOrange"  style="position:absolute; left:20px; top: 30px; width:300px; height:30px;">
                            <?php echo $banner['title']; ?>
                        </div>
                        <a class="captionOrange" u="caption" t="*" d=-300 href="<?php echo $banner['link']; ?>" style="position:absolute;left:720px;top:280px;width:220px;height:40px;font-size:36px;color:#fff;line-height:40px; text-decoration:none">Shop Now</a>
                    </div>
            	<?php } else { ?>
                    <div>
                        <img u="image" src="<?php echo $banner['image']; ?>" />
                        <div u=caption t="*" class="captionOrange"  style="position:absolute; left:20px; top: 30px; width:300px; height:30px;">
                            <?php echo $banner['title']; ?>
                        </div>
                    </div>
          		<?php } ?>
            <?php } ?>
        </div> 
        <!-- Bullet Navigator Skin Begin -->
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb03" style="position: absolute; bottom: 16px; left: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype" style="POSITION: absolute; WIDTH: 21px; HEIGHT: 21px; text-align:center; line-height:21px; color:White; font-size:12px;"><NumberTemplate></NumberTemplate></div>
        </div>
        <!-- Bullet Navigator Skin End -->
        
        <!-- Arrow Navigator Skin Begin -->
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora20l" style="width: 55px; height: 55px; top: 123px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora20r" style="width: 55px; height: 55px; top: 123px; right: 8px">
        </span>
        <!-- Arrow Navigator Skin End -->
        <a style="display: none" href="http://www.jssor.com">javascript</a>
    </div> 
    <!-- Jssor Slider End --> 