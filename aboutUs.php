<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
</head>
<style>
    .showcase hr {
        width:0px;
    }
    </style>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.html"><img src="img/logo.PNG" style="margin-right:.3rem;margin-bottom:3px;width:2.2rem;height:2.2rem;">Your Guider</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="map.php">Map</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#">About us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="yellow bg-primary" id="features">
    <div class="container">
        <div class="section-heading text-center">
            <h2>About us</h2>
            <hr id="hrstyle" style="width: 50%; margin-top: 40px;">
        </div>
    </div>
</section>

<section class="showcase" style="padding-top:0px;padding-bottom:0px;">
<div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-lg-6 order-lg-2 text-white" style="background-image: url('img/team.jpg'); height: 500px; background-size: cover;" ></div>
            <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                <h2>We are Gizmo Gurus!</h2>
                <hr>
                <p class="lead mb-0" style="padding-left:0px;padding-top:0px;">We are students from Monash University. Hope our website can provide useful information for you!</p>
            </div>
        </div>
    </div>
</section>

<section class="yellow bg-primary" id="contact">
    <div class="container">
        <h2>Meet the team</h2>
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
                                    <div class="card">
                                        <img class="card-imd-top" style="height:420px;width:325px;" src="img/yueyi.jpg">
                                        <div class="card-body">
                                            <h4 class="card-title">Yueyi Zhao</h4>
                                            <p class="card-text">Yueyi Zhao is from Master of Information Technology.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <div class="card">
                                        <img class="card-imd-top" style="height:420px;width:325px;" src="img/yu.jpg">
                                        <div class="card-body">
                                            <h4 class="card-title">Yu Li</h4>
                                            <p class="card-text">Yu Li is from Master of Data Science.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <div class="card">
                                        <img class="card-imd-top" style="height:420px;width:325px;" src="img/cui.jpg">
                                        <div class="card-body">
                                            <h4 class="card-title">Lu Cui</h4>
                                            <p class="card-text">Lu Cui is from Master of Business Information System.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <div class="card">
                                        <img class="card-imd-top" style="height:420px;width:325px;" src="img/binh.jpg">
                                        <div class="card-body">
                                            <h4 class="card-title">Thuy Tri Binh Tran</h4>
                                            <p class="card-text">Binh is from Master of Business Information System.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>







<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>


</html>