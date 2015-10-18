<!doctype html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>YourDraft</title>
    <meta name="keywords" content="YourDraft" />
    <meta name="description" content="Социалната мрежа на твоите идеи!" />
    <meta name="author" content="DANGAM" />
    <link href="<?php echo $url; ?>css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>images/favicon.ico" rel="shortcut icon" />
    <script type="text/javascript" src="<?php echo $url; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/jquery.watermark.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/script.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var myImages = ["images/bg/Background1.jpg", "images/bg/Background2.jpg", "images/bg/Background3.jpg", "images/bg/Background4.jpg", "images/bg/Background5.jpg", "images/bg/Background6.jpg", "images/bg/Background7.jpg", "images/bg/Background8.jpg", "images/bg/Background9.jpg", "images/bg/Background10.jpg", "images/bg/Background11.jpg"];
            var imgShown = document.body.style.backgroundImage;
            var newImgNumber =Math.floor(Math.random()*myImages.length);
            document.body.style.backgroundImage = 'url('+myImages[newImgNumber]+')';
        });
    </script>
    </head>
    <body class="bg">
        <div id="content">