<!DOCTYPE html>
<html lang="en" >

<head>
    <?php include 'header.php'; ?>
    <style>


        @media (max-width: 1200px) {
            .center { margin: 0 auto; width:930px; height:600px;}
        }
        @media (max-width: 995px) {
            .center { margin: 0 auto; width:600px; height:360px;}
        }
        @media (max-width: 765px) {
            .center { margin: 0 auto; width:450px; height:250px;}
        }
        @media (max-width: 486px) {
            .container h2{font-size: 19px; margin-bottom: 0px;}
            .center { margin: 0 auto; width:300px; height:190px;}
        }
        @media (max-width: 340px) {
            .container h2{}
            .center { margin: 0 auto; width:200px; height:150px;}
        }
    </style>
</head>

<body >

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
                    <a class="nav-link js-scroll-trigger" href="mapbox.php">Map</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<section class="yellow bg-primary" id="contact">
    <div class="container">
        <h2>Helpful Video
            <i class="fas fa-heart"></i>
            </h2>

        <video class="center" controls>
            <source src="video.MP4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</section>






<footer>
    <?php include 'footer.php'; ?>
</footer>

</body>
</html>