<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" dir="ltr" lang="ja">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" dir="ltr" lang="ja">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" dir="ltr" lang="ja">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html dir="ltr" lang="ja">
    <!--<![endif]-->
    <head>
        <?php echo $head01; ?>
    </head><!-- <head> -->
    <body class="home blog <?php if ($loginuser) echo ' logged-in admin-bar '; ?> single-author two-column right-sidebar">
        <div id="page" class="hfeed">
            <?php echo $header01; ?>
            <div id="main">
                <?php echo $primary01; ?>
                <?php echo $secondary01; ?>
            </div><!-- #main -->
            <?php echo $footer01; ?>
        </div><!-- #page -->
   <?php if ($loginuser) echo $adminbar; ?>
    </body>
</html>
