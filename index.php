<!DOCTYPE html>
<?php
include("config/main_function.php");
$secure = "-%eA|y).m0%%1A7";
$connection = connectDB($secure);
$add="";
?>
<html lang="en">
<style>
    body#kt_body {
        flex-direction: unset;
    }

    .CSSgal {
        position: relative;
        overflow-x: hidden;
        align-self: center;

        /* Or set a fixed height */
    }

    /* SLIDER */

    .CSSgal .slider {
        height: 100%;
        white-space: nowrap;
        font-size: 0;
        transition: 0.8s;
    }

    /* SLIDES */

    .CSSgal .slider>* {
        font-size: 1rem;
        display: inline-block;
        white-space: normal;
        vertical-align: top;
        height: 100%;
        width: 100%;
        background: none 50% no-repeat;
        background-size: cover;
    }

    /* PREV/NEXT, CONTAINERS & ANCHORS */

    .CSSgal .prevNext {
        position: absolute;
        z-index: 1;
        top: 50%;
        width: 100%;
        height: 0;
    }

    .CSSgal .prevNext>div+div {
        visibility: hidden;
        /* Hide all but first P/N container */
    }

    .CSSgal .prevNext a {
        background: #000;
        position: absolute;
        width: 60px;
        height: 60px;
        line-height: 60px;
        text-align: center;
        opacity: 0.7;
        -webkit-transition: 0.3s;
        transition: 0.3s;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        left: 0;
    }

    .CSSgal .prevNext a:hover {
        opacity: 1;
    }

    .CSSgal .prevNext a+a {
        left: auto;
        right: 0;
    }

    /* NAVIGATION */

    .CSSgal .bullets {
        position: absolute;
        z-index: 2;
        bottom: 0;
        padding: 10px 0;
        width: 100%;
        text-align: center;
    }

    .CSSgal .bullets>a {
        display: inline-block;
        width: 30px;
        height: 30px;
        line-height: 30px;
        text-decoration: none;
        text-align: center;
        background: rgba(255, 255, 255, 1);
        -webkit-transition: 0.3s;
        transition: 0.3s;
    }

    .CSSgal .bullets>a+a {
        background: rgba(255, 255, 255, 0.5);
        /* Dim all but first */
    }

    .CSSgal .bullets>a:hover {
        background: rgba(255, 255, 255, 0.7) !important;
    }

    /* NAVIGATION BUTTONS */
    /* ALL: */
    .CSSgal>s:target~.bullets>* {
        background: rgba(255, 255, 255, 0.5);
    }

    /* ACTIVE */
    #s1:target~.bullets>*:nth-child(1) {
        background: rgba(255, 255, 255, 1);
    }

    #s2:target~.bullets>*:nth-child(2) {
        background: rgba(255, 255, 255, 1);
    }


    /* More slides? Add here more rules */

    /* PREV/NEXT CONTAINERS VISIBILITY */
    /* ALL: */
    .CSSgal>s:target~.prevNext>* {
        visibility: hidden;
    }

    /* ACTIVE: */
    #s1:target~.prevNext>*:nth-child(1) {
        visibility: visible;
    }

    #s2:target~.prevNext>*:nth-child(2) {
        visibility: visible;
    }


    /* More slides? Add here more rules */

    /* SLIDER ANIMATION POSITIONS */

    #s1:target~.slider {
        transform: translateX(0%);
        -webkit-transform: translateX(0%);
    }

    #s2:target~.slider {
        transform: translateX(-100%);
        -webkit-transform: translateX(-100%);
    }


    /* More slides? Add here more rules */


    /* YOU'RE THE DESIGNER! 
   ____________________
   All above was mainly to get it working :)
   CSSgal CUSTOM STYLES / OVERRIDES HERE: */

    .CSSgal {
        color: #fff;
        text-align: center;
    }

    .CSSgal .slider h2 {
        margin-top: 40vh;
        font-weight: 200;
        letter-spacing: -0.06em;
        word-spacing: 0.2em;
        font-size: 3em;
    }

    .CSSgal a {
        border-radius: 50%;
        margin: 0 3px;
        color: rgba(0, 0, 0, 0.8);
        text-decoration: none;
    }

    .CSSgal {
        display: none;
    }

    div#io111 {
        display: flex;
    }

    img#imgwidth222 {
        width: 60%;
    }

    @media screen and (max-width:1024px) {
        .CSSgal {
            display: block;
        }

        div#io111 {
            display: none;
        }

        img#imgwidth222 {
            width: 65%;
        }
    }

    @media screen and (max-width:600px) {
        img#imgwidth222 {
            width: 100%;
        }
    }
</style>

<head>
    <title>Menu</title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Blazor, Django, Flask & Laravel Admin Dashboard Theme" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/html" />
    <link rel="shortcut icon" href="template/assets/media/logos/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="template/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="template/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" data-bs-offset="200" class="bgi-position-bottom bgi-size-cover bgi-no-repeat" style="background-image: url(template/img_menu/bg.jpg)">
    <div class="flex-column flex-root" id="io111">
        <div class="mt-sm-n20">
            <div class="padtb111">
                <div class="container">
                    <div class="d-flex flex-column container pt-lg-20">
                        <div class="text-center" id="kt_pricing">
                            <div class="row g-10">
                                <div class="col-sm-6 col-lg-4 col-xl-4 col-xxl-3">
                                    <a href="https://awareness.albatross.co.th/user/index.php" class="btn btn-hover-rise" target="_blank">
                                        <div class="w-300px h-600px bgi-size-cover bgi-position-center " style="background-image: url(template/img_menu/Awareness.png)">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6 col-lg-4 col-xl-4 col-xxl-3">
                                    <a href="https://bigsara-service.com/email/admin/index.php" class="btn btn-hover-rise" target="_blank">
                                        <div class="w-300px h-600px bgi-size-cover bgi-position-center" style="background-image: url(template/img_menu/Drill.png)">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="CSSgal">
        <!-- Don't wrap targets in parent -->
        <s id="s1"></s>
        <s id="s2"></s>


        <div class="slider">

            <a href="https://awareness.albatross.co.th/user/index.php">
                <img src="template/img_menu/Awareness.png" id="imgwidth222"></a>


            <a href="https://bigsara-service.com/email/admin/index.php">
                <img src="template/img_menu/Drill.png" id="imgwidth222"></a>

        </div>

        <div class="prevNext">
            <div><a href="#s4"><img src="template/img_menu/left-arrow1.png" style="width: 30%;"></a><a href="#s2"><img src="template/img_menu/right-arrow1.png" style="width: 30%;"></a></a></div>
            <div><a href="#s1"><img src="template/img_menu/left-arrow1.png" style="width: 30%;"></a><a href="#s3"><img src="template/img_menu/right-arrow1.png" style="width: 30%;"></a></div>

        </div>


    </div>


    <script src="template/assets/plugins/global/plugins.bundle.js"></script>
    <script src="template/assets/js/scripts.bundle.js"></script>
</body>



</html>
