<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
  <!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="<?=$description;?>" />
    <meta name="author" content="" />
    <title><?=$title;?></title>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/main.css" />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/main.scss" />
    <link rel="stylesheet" href="<?=base_url();?>assets/css/responsive.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.cdnfonts.com/css/samsung-sharp-sans" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
  </head>
  <body>
    <!-- FOR HEADER -->

    <header class="header-2">
      <div class="container">
        <div class="navbar-container" id="navbar">
          <nav class="navbar navbar-expand-lg main_nav">
            <a class="navbar-brand" href="<?=base_url();?>">
              <img src="<?=base_url();?>assets/images/Logo-header.png" class="no-filter" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation" >
              <span class="nav-toggle__text"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
              <ul class="navbar-nav ml-auto no-filter">
                <li class="nav-item active">
                  <a href="<?=base_url();?>about">ABOUT US</a>
                </li>
                <li class="nav-item">
                  <a href="<?=base_url();?>services">SERVICES</a>
                </li>
                <li class="nav-item">
                  <a href="<?=base_url();?>scheduling">SCHEDULING</a>
                </li>
                <li class="nav-item">
                  <a href="<?=base_url();?>faqs">FAQS</a>
                </li>
                <li class="nav-item">
                  <a href="<?=base_url();?>testimonials">Testimonials</a>
                </li>
                <li class="nav-item">
                  <a href="<?=base_url();?>contact">CONTACT US</a>
                </li>
               
              </ul>
            </div>
            <div class="btn">
              <button onclick="window.location.href='/scheduling/intro'">BOOK NOW</button>
            </div>
          </nav>
        </div>
      </div>
    </header>