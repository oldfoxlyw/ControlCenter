<?php echo $header; ?>
<?php echo $meta_data; ?>
<body id="login">
    <div id="login-wrapper" class="png_bg">
        <div id="login-top">
            <h1><?php echo $title ?></h1>
            <!-- Logo (221px width) -->
            <img id="logo" src="<?php echo $root_path; ?>resources/images/logo.png" alt="<?php echo $title ?>" />
        </div> <!-- End #logn-top -->
        <div id="login-content">
            <?php echo $message; ?>
            <div style="color:#FFFF00;font-weight:bold;line-height:50px;text-align:right;">
                <?php echo $returned; ?>
            </div>
        </div> <!-- End #login-content -->
    </div> <!-- End #login-wrapper -->
</body>
<?php echo $footer; ?>