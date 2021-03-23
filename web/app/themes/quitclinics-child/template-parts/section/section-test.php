<section style="height: 400px; width: 100%; padding: 60px 0; background-color: var(--color-blue);">
    <div class="container-fluid p-0">
        <div class="row wrapper-1360">
            <div class="col-2 p-0">
                <!-- Slider main container -->
                <div class="swiper-container">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <div class="swiper-slide" style="width: 100%; height: 280px; background-color: red;">Slide 1</div>
                        <div class="swiper-slide" style="width: 100%; height: 280px; background-color: beige;">Slide 2</div>
                        <div class="swiper-slide" style="width: 100%; height: 280px; background-color: orange;">Slide 3</div>
                        ...
                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination"></div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                    <!-- If we need scrollbar -->
                    <div class="swiper-scrollbar"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php


//        swiper slider styles
wp_enqueue_style( 'swiper', get_theme_file_uri( '/assets/css/swiper-bundle.min.css' ));
//        swiper slider scripts
wp_enqueue_script( 'swiperjs-2222', get_theme_file_uri( '/assets/js/swiper-bundle.min.js' ), array('jquery'), '1', true );

?>


