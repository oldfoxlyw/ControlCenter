<?php echo $header; ?>
<body id="login">
    <div id="login-wrapper" class="png_bg">
        <div id="login-top">
            <h1><?php echo $title ?></h1>
            <!-- Logo (221px width) -->
            <img id="logo" src="<?php echo $root_path; ?>resources/images/logo.png" alt="<?php echo $title ?>" />
        </div> <!-- End #logn-top -->
        <div id="login-content">
            <form action="login/validate" method="post">
                <div class="notification information png_bg">
                    <div>
                        Just click "Sign In". No password needed.
                    </div>
                </div>
                <p>
                    <label>Username</label>
                    <input name="userName" type="text" class="text-input" id="userName" />
                </p>
                <div class="clear"></div>
                <p>
                    <label>Password</label>
                    <input name="userPass" type="password" class="text-input" id="userPass" />
                </p>
                <div class="clear"></div>
                <p>
                    <label>Platform</label>
                    <select name="selectEntrance" id="selectEntrance" class="text-input">
                        <option value="1">进入网站管理中心</option>
                        <option value="2">进入报表中心</option>
                        <option value="3">进入运维中心</option>
                      </select>
                </p>
                <div class="clear"></div>
                <p id="remember-password">
                    <input type="checkbox" />Remember me
                </p>
                <div class="clear"></div>
                <p>
                    <input class="button" type="submit" value="Sign In" />
                </p>
            </form>
        </div> <!-- End #login-content -->
    </div> <!-- End #login-wrapper -->
</body>
<?php echo $footer; ?>