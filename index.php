<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'header.php'; ?>
</head>
<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="img/logo.PNG" style="margin-right:.3rem;margin-bottom:3px;width:2.2rem;height:2.2rem;">Your Guider</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#features">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#map">Start</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- First page -->
  <header class="masthead" style="background-image: url(img/bg.jpg); background-size: cover;">
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-lg-12 my-auto">
          <div class="header-content mx-auto">
            <h1 class="mb-5">Your guider is a route planner that will help aged find the most effortless route!</h1>
            <a href="#intro" class="btn btn-outline btn-xl js-scroll-trigger">Learn more</a>
          </div>
        </div>
      </div>
    </div>
  </header>

  
<!-- Yellow section -->
<section class="yellow bg-primary" id="intro">
    <div class="container">
      <div class="section-heading text-center">
        <h2>Have you met these problems?</h2>
        <br>
        <i class="fa fa-arrow-circle-down" style="font-size:4rem;color:black;"></i>
    </div>
  </section>


  <!-- Problem section -->
  <section class="showcase" style="padding-top:0px;padding-bottom:0px;">
    
    <div class="container-fluid p-0">
      <div class="row no-gutters">
        <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/crowd.jpg');"></div>
        <div class="col-lg-6 order-lg-1 my-auto showcase-text">
          <h2>Scare being pushed</h2>
          <p class="lead mb-0" style="padding-left:0px;padding-top:0px;">When you walk within the crowd, are you worried others bumping into you? </p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-lg-6 text-white showcase-img" style="background-image: url('img/seats.jpg');"></div>
        <div class="col-lg-6 my-auto showcase-text">
          <h2>Cannot find seats</h2>
          <p class="lead mb-0" style="padding-left:0px;padding-top:0px;">When you want to have a rest after a long walk, are you worried no seat available on the street?</p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/steep.jpg');"></div>
        <div class="col-lg-6 order-lg-1 my-auto showcase-text">
          <h2>Steeply roads</h2>
          <p class="lead mb-0" style="padding-left:0px;padding-top:0px;">When you face a steep street behind you, are you afraid of falling? </p>
        </div>
      </div>
    </div>
  </section>


   <!-- Feature section -->

   <section class="yellow bg-primary" id="features">
    <div class="container">
      <div class="section-heading text-center">
        <h2>Our features</h2>
        <hr id="hrstyle" style="width: 50%; margin-top: 40px;">
    </div>
  </section>

   <section class="features" style="padding-top:50px;padding-bottom:50px;">
    <div class="container">
      <div class="section-heading text-center">
      <div class="row">
        <div class="col-lg-12 my-auto">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-screen-smartphone text-primary"></i>
                  <h3>Device Mockups</h3>
                  <p class="text-muted">Ready to use HTML/CSS device mockups, no Photoshop required!</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-camera text-primary"></i>
                  <h3>Flexible Use</h3>
                  <p class="text-muted">Put an image, video, animation, or anything else in the screen!</p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-present text-primary"></i>
                  <h3>Free to Use</h3>
                  <p class="text-muted">As always, this theme is free to download and use for any purpose!</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="feature-item">
                  <i class="icon-lock-open text-primary"></i>
                  <h3>Open Source</h3>
                  <p class="text-muted">Since this theme is MIT licensed, you can use it commercially!</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

    
  <section class="yellow bg-primary" id="contact">
      <div class="container">
        <h2>Welcome
          <i class="fas fa-heart"></i>
          new friend!</h2>
      </div>
    </section>
  
  <!-- 从这里的a标签挑战到新的页面，也就是有map功能的那个页面 -->
    <section class="cta" id="map">
      <div class="cta-content">
        <div class="container">
          <h2>Stop waiting.<br>Start exploring.</h2>
          <a href="map.php" class="btn btn-outline btn-xl js-scroll-trigger">Let's Get Started!</a>
        </div>
      </div>
      <div class="overlay"></div>
    </section>
  


  <footer>
      <?php include 'footer.php'; ?>
  </footer>

</body>

</html>
