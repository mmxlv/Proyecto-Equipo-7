<?php include_once ("header.php") ?>
      <section>
        <div class="banner">
          <img src="images/banner.jpg" alt="banner" width="100%">
        </div>
        <article class="main-product">
          <img src="images/img6.jpg" alt="New product" width="100%">
        </article>
        <article class="products">
          <img src="images/img1.jpg" alt="">
          <img src="images/img2.jpg" alt="">
          <img src="images/img3.jpg" alt="">
          <img src="images/img4.jpg" alt="">
          <img src="images/img1.jpg" alt="">
          <img src="images/img2.jpg" alt="">
        </article>
        <article class="products-slider">
          <div class="slideshow-container">
            <div class="mySlides fade">
              <div class="numbertext">1 / 3</div>
              <img src="images/img5.jpg" style="width:100%">
            </div>
            <div class="mySlides fade">
              <div class="numbertext">2 / 3</div>
              <img src="images/img2.jpg" style="width:100%">
            </div>
            <div class="mySlides fade">
              <div class="numbertext">3 / 3</div>
              <img src="images/img3.jpg" style="width:100%">
            </div>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
          </div>
          <br>
          <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
          </div>
        </article>
      </section>
      <script src="js/slider.js"></script>
<?php include_once ("footer.php") ?>
