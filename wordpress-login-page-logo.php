<?php

// WordPress login page logo

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url('https://acceleratedstore.com/wp-content/uploads/2018/12/accelerated-store-logo.png');
			height:85px;
			width:350px;
			background-size: 350px 85px;
			background-repeat: no-repeat;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Accelerated Store Demo';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
