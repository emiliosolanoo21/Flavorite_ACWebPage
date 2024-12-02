<?php
// Include the database connection
global $pdo;
include('dbconnection.php');

try {
    // Query to get all categories
    $query = $pdo->query("SELECT id, name FROM commerce_category");
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);

    // Query to get all statuses except those with id = -1
    $query = $pdo->query("SELECT id, name FROM commerce_status WHERE id != -1");
    $statuses = $query->fetchAll(PDO::FETCH_ASSOC);

    // Query to get all sales channels
    $query = $pdo->query("SELECT id, name FROM sales_channels");
    $sales_channels = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error retrieving data: " . $e->getMessage());
}

try {
    // General Commerces Query
    $query = $pdo->query("SELECT c.name AS commerce_name, cs.name AS status_name, cs.id AS status_id, cc.id AS category_id, cc.name AS category_name,
                                 c.logo, c.restrictions, c.priority,
                                 IF(c.external_codes_enabled = 1, c.external_codes_description, NULL) AS external_codes_description,
                                 GROUP_CONCAT(DISTINCT p.name SEPARATOR ', ') AS products,
                                 GROUP_CONCAT(DISTINCT sc.name SEPARATOR ', ') AS channels,
                                 GROUP_CONCAT(DISTINCT sc.id SEPARATOR ', ') AS channels_ids
                          FROM commerce c
                          JOIN flavorite.commerce_status cs ON cs.id = c.status
                          JOIN flavorite.commerce_sales_channels csc ON c.id = csc.commerce_id
                          JOIN flavorite.sales_channels sc ON sc.id = csc.sales_channel_id
                          JOIN flavorite.commerce_category cc ON c.commerce_category_id = cc.id
                          LEFT JOIN flavorite.user u ON c.id = u.commerce_id
                              AND u.superadmin = 0
                              AND u.active = 1
                              AND u.commerce_id IS NOT NULL
                          LEFT JOIN flavorite.external_code ec ON c.id = ec.commerce_id
                          LEFT JOIN flavorite.product p ON p.id = ec.product_id
                          WHERE c.status != -1
                          GROUP BY c.name, cs.name, cs.id, cc.id, cc.name, c.logo, c.restrictions, c.external_codes_description, c.priority
                          ORDER BY c.priority ASC
                          ");
    $commerces = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error retrieving data: " . $e->getMessage());
}
?>

<html lang="en-US" class="jetpack-lazy-images-js-enabled">
<head>
    <meta http-equiv="refresh" content="Az520Inasey3TAyqLyojQa8MnmCALSEU29yQFW8dePZ7xQTvSt73pHazLFTK5f7SyLUJSo2uKLesEtEa9aUYcgMAAACPeyJvcmlnaW4iOiJodHRwczovL2dvb2dsZS5jb206NDQzIiwiZmVhdHVyZSI6IkRpc2FibGVUaGlyZFBhcnR5U3RvcmFnZVBhcnRpdGlvbmluZyIsImV4cGlyeSI6MTcyNTQwNzk5OSwiaXNTdWJkb21haW4iOnRydWUsImlzVGhpcmRQYXJ0eSI6dHJ1ZX0=">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <!-- Metas -->
    <meta name="facebook-domain-verification" content="ijsd0qgxeddpdc1djekp2wl9tngy7z">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="@toxsl">
    <!-- Title  -->
    <title>Flavorite</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://flavorite.io/wp-content/uploads/2022/08/Recurso-1-100.jpg">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700" rel="stylesheet">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 0.07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
        .btn-flavorite {
            background-color: #ff6633;
            color: #ffffff;
        }
        .btn-flavorite:hover {
            background-color: #ff3300; /* A brighter shade of orange */
        }
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <link rel="stylesheet" id="wp-block-library-css" href="https://c0.wp.com/c/6.3.1/wp-includes/css/dist/block-library/style.min.css" type="text/css" media="all">
    <style id="wp-block-library-inline-css" type="text/css">
        .has-text-align-justify{text-align:justify;}
    </style>
    <link rel="stylesheet" id="mediaelement-css" href="https://c0.wp.com/c/6.3.1/wp-includes/js/mediaelement/mediaelementplayer-legacy.min.css" type="text/css" media="all">
    <link rel="stylesheet" id="wp-mediaelement-css" href="https://c0.wp.com/c/6.3.1/wp-includes/js/mediaelement/wp-mediaelement.min.css" type="text/css" media="all">
    <style id="classic-theme-styles-inline-css" type="text/css">
        /*! This file is auto-generated */
        .wp-block-button__link{color:#fff;background-color:#32373c;border-radius:9999px;box-shadow:none;text-decoration:none;padding:calc(.667em + 2px) calc(1.333em + 2px);font-size:1.125em}.wp-block-file__button{background:#32373c;color:#fff;text-decoration:none}
    </style>
    <style id="global-styles-inline-css" type="text/css">
        body{--wp--preset--color--black: #000000;--wp--preset--color--cyan-bluish-gray: #abb8c3;--wp--preset--color--white: #ffffff;--wp--preset--color--pale-pink: #f78da7;--wp--preset--color--vivid-red: #cf2e2e;--wp--preset--color--luminous-vivid-orange: #ff6900;--wp--preset--color--luminous-vivid-amber: #fcb900;--wp--preset--color--light-green-cyan: #7bdcb5;--wp--preset--color--vivid-green-cyan: #00d084;--wp--preset--color--pale-cyan-blue: #8ed1fc;--wp--preset--color--vivid-cyan-blue: #0693e3;--wp--preset--color--vivid-purple: #9b51e0;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%);--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%);--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%);--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%);--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%);--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%);--wp--preset--gradient--blush-light-purple: linear-gradient(135deg,rgb(255,206,236) 0%,rgb(152,150,240) 100%);--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,rgb(254,205,165) 0%,rgb(254,45,45) 50%,rgb(107,0,62) 100%);--wp--preset--gradient--luminous-dusk: linear-gradient(135deg,rgb(255,203,112) 0%,rgb(199,81,192) 50%,rgb(65,88,208) 100%);--wp--preset--gradient--pale-ocean: linear-gradient(135deg,rgb(255,245,203) 0%,rgb(182,227,212) 50%,rgb(51,167,181) 100%);--wp--preset--gradient--electric-grass: linear-gradient(135deg,rgb(202,248,128) 0%,rgb(113,206,126) 100%);--wp--preset--gradient--midnight: linear-gradient(135deg,rgb(2,3,129) 0%,rgb(40,116,252) 100%);--wp--preset--font-size--small: 13px;--wp--preset--font-size--medium: 20px;--wp--preset--font-size--large: 36px;--wp--preset--font-size--x-large: 42px;--wp--preset--spacing--20: 0.44rem;--wp--preset--spacing--30: 0.67rem;--wp--preset--spacing--40: 1rem;--wp--preset--spacing--50: 1.5rem;--wp--preset--spacing--60: 2.25rem;--wp--preset--spacing--70: 3.38rem;--wp--preset--spacing--80: 5.06rem;--wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);}:where(.is-layout-flex){gap: 0.5em;}:where(.is-layout-grid){gap: 0.5em;}body .is-layout-flow > .alignleft{float: left;margin-inline-start: 0;margin-inline-end: 2em;}body .is-layout-flow > .alignright{float: right;margin-inline-start: 2em;margin-inline-end: 0;}body .is-layout-flow > .aligncenter{margin-left: auto !important;margin-right: auto !important;}body .is-layout-constrained > .alignleft{float: left;margin-inline-start: 0;margin-inline-end: 2em;}body .is-layout-constrained > .alignright{float: right;margin-inline-start: 2em;margin-inline-end: 0;}body .is-layout-constrained > .aligncenter{margin-left: auto !important;margin-right: auto !important;}body .is-layout-constrained > :where(:not(.alignleft):not(.alignright):not(.alignfull)){max-width: var(--wp--style--global--content-size);margin-left: auto !important;margin-right: auto !important;}body .is-layout-constrained > .alignwide{max-width: var(--wp--style--global--wide-size);}body .is-layout-flex{display: flex;}body .is-layout-flex{flex-wrap: wrap;align-items: center;}body .is-layout-flex > *{margin: 0;}body .is-layout-grid{display: grid;}body .is-layout-grid > *{margin: 0;}:where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}:where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}.has-black-color{color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-color{color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-color{color: var(--wp--preset--color--white) !important;}.has-pale-pink-color{color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-color{color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-color{color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-color{color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-color{color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-color{color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-color{color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-color{color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-color{color: var(--wp--preset--color--vivid-purple) !important;}.has-black-background-color{background-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-background-color{background-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-background-color{background-color: var(--wp--preset--color--white) !important;}.has-pale-pink-background-color{background-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-background-color{background-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-background-color{background-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-background-color{background-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-background-color{background-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-background-color{background-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-background-color{background-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-background-color{background-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-background-color{background-color: var(--wp--preset--color--vivid-purple) !important;}.has-black-border-color{border-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-border-color{border-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-border-color{border-color: var(--wp--preset--color--white) !important;}.has-pale-pink-border-color{border-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-border-color{border-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-border-color{border-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-border-color{border-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-border-color{border-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-border-color{border-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-border-color{border-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-border-color{border-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-border-color{border-color: var(--wp--preset--color--vivid-purple) !important;}.has-vivid-cyan-blue-to-vivid-purple-gradient-background{background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;}.has-light-green-cyan-to-vivid-green-cyan-gradient-background{background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;}.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;}.has-luminous-vivid-orange-to-vivid-red-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;}.has-very-light-gray-to-cyan-bluish-gray-gradient-background{background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;}.has-cool-to-warm-spectrum-gradient-background{background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;}.has-blush-light-purple-gradient-background{background: var(--wp--preset--gradient--blush-light-purple) !important;}.has-blush-bordeaux-gradient-background{background: var(--wp--preset--gradient--blush-bordeaux) !important;}.has-luminous-dusk-gradient-background{background: var(--wp--preset--gradient--luminous-dusk) !important;}.has-pale-ocean-gradient-background{background: var(--wp--preset--gradient--pale-ocean) !important;}.has-electric-grass-gradient-background{background: var(--wp--preset--gradient--electric-grass) !important;}.has-midnight-gradient-background{background: var(--wp--preset--gradient--midnight) !important;}.has-small-font-size{font-size: var(--wp--preset--font-size--small) !important;}.has-medium-font-size{font-size: var(--wp--preset--font-size--medium) !important;}.has-large-font-size{font-size: var(--wp--preset--font-size--large) !important;}.has-x-large-font-size{font-size: var(--wp--preset--font-size--x-large) !important;}
        .wp-block-navigation a:where(:not(.wp-element-button)){color: inherit;}
        :where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}
        :where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}
        .wp-block-pullquote{font-size: 1.5em;line-height: 1.6;}
    </style>
    <!-- <link rel='stylesheet' id='wpcf7-redirect-script-frontend-css' href='https://flavorite.io/wp-content/plugins/wpcf7-redirect/build/css/wpcf7-redirect-frontend.min.css?ver=6.3.1' type='text/css' media='all' /> -->
    <!-- <link rel='stylesheet' id='contact-form-7-css' href='https://flavorite.io/wp-content/plugins/contact-form-7/includes/css/styles.css?ver=5.6.1' type='text/css' media='all' /> -->
    <link rel='stylesheet' id='flavorite-plugins-css' href='https://flavorite.io/wp-content/themes/flavorite/css/plugins.css?ver=6.3.1' type='text/css' media='all' />
    <link rel='stylesheet' id='flavorite-style-css' href='https://flavorite.io/wp-content/themes/flavorite/style.css?ver=6.3.1' type='text/css' media='all' />
    <link rel='stylesheet' id='flavorite-responsive-css' href='https://flavorite.io/wp-content/themes/flavorite/css/responsive.css?ver=6.3.1' type='text/css' media='all' />
    <!-- <link rel='stylesheet' id='qlwapp-css' href='https://flavorite.io/wp-content/plugins/wp-whatsapp-chat/build/frontend/css/style.css?ver=6.3.1' type='text/css' media='all' /> -->
    <link rel="stylesheet" type="text/css" href="//flavorite.io/wp-content/cache/wpfc-minified/2mmskbm/a16x1.css" media="all">
    <link rel="stylesheet" id="jetpack_css-css" href="https://c0.wp.com/p/jetpack/11.8.5/css/jetpack.css" type="text/css" media="all">
    <script src="//flavorite.io/wp-content/cache/wpfc-minified/l1fnxf0c/a16x1.js" type="text/javascript"></script>
    <!-- <script type='text/javascript' src='https://flavorite.io/wp-content/plugins/google-analytics-for-wordpress/assets/js/frontend-gtag.min.js?ver=8.20.1' id='monsterinsights-frontend-script-js'></script> -->
    <script data-cfasync="false" data-wpfc-render="false" type="text/javascript" id="monsterinsights-frontend-script-js-extra">/* <![CDATA[ */
        var monsterinsights_frontend = {"js_events_tracking":"true","download_extensions":"doc,pdf,ppt,zip,xls,docx,pptx,xlsx","inbound_paths":"[{\"path\":\"\\\/go\\\/\",\"label\":\"affiliate\"},{\"path\":\"\\\/recommend\\\/\",\"label\":\"affiliate\"}]","home_url":"https:\/\/flavorite.io","hash_tracking":"false","v4_id":"G-W1TQ0866G2"};/* ]]> */
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" id="my_voter_script-js-extra">
        /* <![CDATA[ */
        var myAjax = {"ajaxurl":"https:\/\/flavorite.io\/wp-admin\/admin-ajax.php"};
        /* ]]> */
    </script>
    <script src="//flavorite.io/wp-content/cache/wpfc-minified/2zur7cjh/a16x1.js" type="text/javascript"></script>
    <!-- <script type='text/javascript' src='https://flavorite.io/wp-content/themes/flavorite/js/my_voter_script.js?ver=6.3.1' id='my_voter_script-js'></script> -->
    <link rel="https://api.w.org/" href="https://flavorite.io/wp-json/"><link rel="alternate" type="application/json" href="https://flavorite.io/wp-json/wp/v2/pages/88"><link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://flavorite.io/xmlrpc.php?rsd">
    <meta name="generator" content="WordPress 6.3.1">
    <link rel="shortlink" href="https://wp.me/Pc8r9s-1q">
    <link rel="alternate" type="application/json+oembed" href="https://flavorite.io/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fflavorite.io%2Fcontactanos%2F">
    <link rel="alternate" type="text/xml+oembed" href="https://flavorite.io/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fflavorite.io%2Fcontactanos%2F&amp;format=xml">
    <style>img#wpstats{display:none}</style>
    <script>
        document.documentElement.className = document.documentElement.className.replace( 'no-js', 'js' );
    </script>
    <style>
        .no-js img.lazyload { display: none; }
        figure.wp-block-image img.lazyloading { min-width: 150px; }
        .lazyload, .lazyloading { opacity: 0; }
        .lazyloaded {
            opacity: 1;
            transition: opacity 400ms;
            transition-delay: 0ms;
        }
    </style>
    <style type="text/css">
        /* If html does not have either class, do not show lazy loaded images. */
        html:not( .jetpack-lazy-images-js-enabled ):not( .js ) .jetpack-lazy-image {
            display: none;
        }
    </style>
    <script>
        document.documentElement.classList.add(
            'jetpack-lazy-images-js-enabled'
        );
    </script>
    <!-- <link rel="stylesheet" type="text/css" id="wp-custom-css" href="https://flavorite.io/?custom-css=0f33f0200c" /> -->
    <link rel="stylesheet" type="text/css" href="//flavorite.io/wp-content/cache/wpfc-minified/mk3bwwxe/a16x1.css" media="all"><style type="text/css" title="dynamic-css" class="options-output">.site-title{color:#f2673a;}</style>			<style>
        :root {
            --qlwapp-scheme-font-family:inherit;--qlwapp-scheme-font-size:18px;--qlwapp-scheme-icon-size:60px;--qlwapp-scheme-icon-font-size:24px;--qlwapp-button-animation-name:none;				}
    </style>
    <style type="text/css">
        @font-face {
            font-weight: 400;
            font-style:  normal;
            font-family: circular;

            src: url('chrome-extension://liecbddmkiiihnedobmlmillhodjkdmb/fonts/CircularXXWeb-Book.woff2') format('woff2');
        }

        @font-face {
            font-weight: 700;
            font-style:  normal;
            font-family: circular;

            src: url('chrome-extension://liecbddmkiiihnedobmlmillhodjkdmb/fonts/CircularXXWeb-Bold.woff2') format('woff2');
        }</style>
    <script type="text/javascript" src="https://c0.wp.com/p/jetpack/11.8.5/modules/contact-form/js/form-styles.js" id="contact-form-styles-js"></script>
    <script type="text/javascript" src="https://c0.wp.com/p/jetpack/11.8.5/_inc/build/photon/photon.min.js" id="jetpack-photon-js"></script>
    <script type="text/javascript" id="wpcf7-redirect-script-js-extra">
        /* <![CDATA[ */
        var wpcf7r = {"ajax_url":"https:\/\/flavorite.io\/wp-admin\/admin-ajax.php"};
        /* ]]> */
    </script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/plugins/wpcf7-redirect/build/js/wpcf7r-fe.js?ver=1.1" id="wpcf7-redirect-script-js"></script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/plugins/contact-form-7/includes/js/index.js?ver=5.6.1" id="contact-form-7-js"></script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/themes/flavorite/js/popper.min.js?ver=20151215" id="flavorite-popper-js"></script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/themes/flavorite/js/bootstrap.min.js?ver=20151215" id="flavorite-bootstrap-js"></script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/themes/flavorite/js/custom.js?ver=20151215" id="flavorite-custom-js"></script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/themes/flavorite/js/wow.min.js?ver=20151215" id="flavorite-wow-js"></script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/themes/flavorite/js/owl.carousel.js?ver=20151215" id="flavorite-carousel-js"></script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/plugins/wp-whatsapp-chat/build/frontend/js/index.js?ver=5cf11c421167aee95e6c" id="qlwapp-js"></script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/plugins/jetpack/jetpack_vendor/automattic/jetpack-lazy-images/dist/intersection-observer.js?minify=false&amp;ver=83ec8aa758f883d6da14" id="jetpack-lazy-images-polyfill-intersectionobserver-js"></script>
    <script type="text/javascript" id="jetpack-lazy-images-js-extra">
        /* <![CDATA[ */
        var jetpackLazyImagesL10n = {"loading_warning":"Images are still loading. Please cancel your print and try again."};
        /* ]]> */
    </script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/plugins/jetpack/jetpack_vendor/automattic/jetpack-lazy-images/dist/lazy-images.js?minify=false&amp;ver=54eb31dc971b63b49278" id="jetpack-lazy-images-js"></script>    </script>
    <script type="text/javascript" src="https://flavorite.io/wp-content/plugins/wp-smushit/app/assets/js/smush-lazy-load.min.js?ver=3.12.4" id="smush-lazy-load-js"></script>
    <script defer="" type="text/javascript" src="https://flavorite.io/wp-content/plugins/akismet/_inc/akismet-frontend.js?ver=1659708687" id="akismet-frontend-js"></script>

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <!--end::Fonts-->

    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

    <!--end::Page Vendors Styles-->

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles-->

    <!--begin::Layout Themes(used by all pages)-->
    <link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/themes/layout/brand/light.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/themes/layout/aside/light.css" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <style>/* Hide mobile header on screens wider than a certain breakpoint */
        @media (min-width: 769px) {
            #kt_header_mobile {
                display: none;
            }
        }

        /* Hide desktop header on screens narrower than a certain breakpoint */
        @media (max-width: 768px) {
            .container-fluid.header {
                display: none;
            }
            .main-content {
                margin-top: 55px; /* Adjust the value as needed */
            }
        }
        /* Style the mobile menu */
        #mobile-menu {
            display: none;
            position: absolute;
            top: 45px;
            right: 0;
            background: #fff;
            border: 1px solid #ccc;
            padding: 10px;
        }

        #mobile-menu ul {
            list-style: none;
            padding: 0;
        }

        #mobile-menu ul li {
            margin-bottom: 10px;
        }

    </style>

    <!--Carousel Styles-->
    <style>
        .carousel-section {
            height: auto;
            background-size: cover !important;
            width: 100%;
            margin-bottom: 50px;
            background-repeat: no-repeat !important;
        }

        .carousel {
            position: relative;
            max-width: 1250px; /* Adjust the size as needed */
            margin: auto;
            overflow: hidden;
        }

        .carousel-container {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-image {
            min-width: 100%; /* Ensure each image takes up 100% of the container */
            box-sizing: border-box;
        }

        .carousel img {
            width: 100%;
            height: auto;
        }

        .carousel-navigation {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .carousel-indicators {
            display: flex;
            justify-content: center;
            margin-top: 10px; /* Spacing between the carousel and indicators */
            margin-bottom: 10px;
            z-index: 8;
        }

        .indicator {
            height: 10px; /* Indicator size */
            width: 10px; /* Indicator size */
            margin: 0 5px; /* Spacing between indicators */
            border-radius: 50%; /* Circular shape */
            background-color: lightgray; /* Base color */
            cursor: pointer; /* Changes the cursor when hovering */
            transition: background-color 0.3s; /* Smooth color change */
        }

        .indicator.active {
            background-color: #ff8209; /* Color when active (#ff8209) */
        }

        .prev, .next {
            background: linear-gradient(45deg, #ff6b2c, #ff8209); /* Gradient on the buttons */
            color: white; /* Arrow color */
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 18px;
            border-radius: 5px; /* Rounded borders for a better look */
            transition: background 0.3s ease; /* Smooth transition effect */
        }

        .prev:hover, .next:hover {
            background: linear-gradient(45deg, #ff6b2c, #ff8209); /* Swap colors on hover */
        }

    </style>

    <!--Carousel JS-->
    <script>
        let currentIndex = 0;
        let autoplayInterval;

        function showSlide(index) {
            const slides = document.querySelectorAll('.carousel-image');
            const indicators = document.querySelectorAll('.indicator');

            if (index >= slides.length) currentIndex = 0; // If it exceeds the last slide, go back to the first one
            else if (index < 0) currentIndex = slides.length - 1; // If it goes before the first slide, go to the last one
            else currentIndex = index;

            const offset = -currentIndex * 100; // Negative offset to move the current image
            document.querySelector('.carousel-container').style.transform = `translateX(${offset}%)`;

            // Update indicators
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === currentIndex);
            });
        }

        function nextSlide() {
            showSlide(currentIndex + 1);
            resetAutoplay(); // Restart autoplay when navigating
        }

        function prevSlide() {
            showSlide(currentIndex - 1);
            resetAutoplay(); // Restart autoplay when navigating
        }

        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 7000); // Change image every 7 seconds
        }

        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }

        function resetAutoplay() {
            stopAutoplay(); // Stop current autoplay
            startAutoplay(); // Start a new autoplay
        }

        // Show the first image when the page loads
        window.onload = function() {
            showSlide(currentIndex);
            startAutoplay();
        };

        // Stop autoplay when interacting with controls
        document.querySelector('.prev').addEventListener('click', resetAutoplay);
        document.querySelector('.next').addEventListener('click', resetAutoplay);
        document.querySelectorAll('.indicator').forEach(indicator => {
            indicator.addEventListener('click', resetAutoplay);
        });
    </script>

    <!--Filters Styles-->
    <style>

        .radio-item {
            margin-bottom: 5px; /* Adjust the value as needed */
            margin-top: 5px;
            height: 25px;
            transition: all 0.3s ease-in-out;
        }

        .radio-item.hiddenCAT {
            margin-bottom: 5px;
            margin-top: 5px;
            display: none;
            height: 25px
        }

        .radio-item.hiddenSC {
            margin-bottom: 5px;
            margin-top: 5px;
            display: none;
            height: 25px
        }

        .show-moreCAT {
            margin-top: 10px; /* Adds space between options and the button */
            color: #ff8209;
        }

        .show-lessCAT {
            margin-top: 10px; /* Adds space between options and the button */
            color: #ff8209;
        }

        .show-moreSC {
            margin-top: 10px; /* Adds space between options and the button */
            color: #ff8209;
        }

        .show-lessSC {
            margin-top: 10px; /* Adds space between options and the button */
            color: #ff8209;
        }

        /* Change color when hovering over "Show More" buttons */
        .show-moreCAT:hover, .show-moreSC:hover {
            color: #ff6b2c; /* New color on hover */
            text-decoration: underline; /* Optional, adds underline for interactivity */
            transition: color 0.3s ease; /* Smooth color transition */
        }

        /* Change color when hovering over "Show Less" buttons */
        .show-lessCAT:hover, .show-lessSC:hover {
            color: #ff6b2c; /* New color on hover */
            text-decoration: underline; /* Optional */
            transition: color 0.3s ease; /* Smooth color transition */
        }

        .radio-item input[type="radio"]:checked + span {
            background: linear-gradient(45deg, #ff6b2c, #ff8209); /* 'Checked' colors */
        }

    </style>

    <!--Filters JQuery-->
    <script>
        $(document).ready(function () {
            const showMoreButton = $(".show-moreCAT");
            const showLessButton = $(".show-lessCAT");
            const hiddenItems = $(".radio-item.hiddenCAT");

            // Show more items
            showMoreButton.on("click", function (event) {
                event.preventDefault();
                hiddenItems.removeClass("hiddenCAT"); // Remove the 'hidden' class
                showMoreButton.hide(); // Hide the "Show more" button
                showLessButton.show(); // Display the "Show less" button
            });

            // Show fewer items
            showLessButton.on("click", function (event) {
                event.preventDefault();
                hiddenItems.addClass("hiddenCAT"); // Add the 'hidden' class
                showMoreButton.show(); // Display the "Show more" button
                showLessButton.hide(); // Hide the "Show less" button
            });
        });

        $(document).ready(function () {
            const showMoreButton = $(".show-moreSC");
            const showLessButton = $(".show-lessSC");
            const hiddenItems = $(".radio-item.hiddenSC");

            // Show more items
            showMoreButton.on("click", function (event) {
                event.preventDefault();
                hiddenItems.removeClass("hiddenSC"); // Remove the 'hidden' class
                showMoreButton.hide(); // Hide the "Show more" button
                showLessButton.show(); // Display the "Show less" button
            });

            // Show fewer items
            showLessButton.on("click", function (event) {
                event.preventDefault();
                hiddenItems.addClass("hiddenSC"); // Add the 'hidden' class
                showMoreButton.show(); // Display the "Show more" button
                showLessButton.hide(); // Hide the "Show less" button
            });
        });
    </script>

    <!--Ribbons Styles-->
    <style>
        /* Labels (Ribbons) with derived colors */
        .bg-orange-light {
            background-color: #ff8209/*#ffa33b*/; /* Lighter color */
            color: #fff;
        }

        .bg-orange-dark {
            background-color: #e67300; /* Darker color */
            color: #fff;
        }

        .bg-orange-muted {
            background-color: #ffd1a6; /* Muted/desaturated color */
            color: #000;
        }

        /* General styling for labels */
        .ribbon-target {
            padding: 5px 10px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 3px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .ribbon-target.bg-orange-popover {
            background: #e67300/*#ff9f43*/; /* Color derived from #ff8209 */
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer; /* Indicates interactivity */
        }
    </style>

    <!--Ribbons JS-->
    <script>
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'hover',
                html: true // Allow HTML content in the popover
            });
        });
    </script>

    <!-- Filtering JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Global variables
            let category = 'all';
            let status = 'all';
            let sales_channel = 'all';
            let search = '';
            let page = 1; // Current page
            let country = 'GT';
            const container = document.getElementById('merchants-container');
            const loader = document.getElementById('loader');
            let isLoading = false; // Prevents multiple simultaneous requests
            let hasMoreItems = true; // Controls if more items are available

            // Initialize data on page load
            resetAndFetch();

            // Reset state and reload data
            function resetAndFetch() {
                page = 1; // Reset page
                hasMoreItems = true; // Reset loading state
                container.innerHTML = ''; // Clear container
                fetchMerchantsData(); // Load the first page
            }

            // Logic to load merchant data
            function fetchMerchantsData() {
                if (isLoading || !hasMoreItems) return; // Exit if already loading or no more data

                isLoading = true;
                loader.style.display = 'block'; // Show loader

                const data = {
                    category,
                    status,
                    sales_channel,
                    search,
                    page,
                    country
                };

                fetch('webpage_merchants.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.merchants.length === 0) {
                            hasMoreItems = false; // No more items available
                        } else {
                            displayMerchants(data.merchants);
                            page++; // Increment page if results exist
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error))
                    .finally(() => {
                        isLoading = false;
                        loader.style.display = 'none'; // Hide loader
                    });
            }

            // Display merchants data
            function displayMerchants(data) {
                data.forEach(merchant => {
                    const ribbonHTML = generateRibbon(merchant);

                    const cardHTML = `
            <div class="col-md-4 col-lg-12 col-xxl-4 commerce-card observer-target">
                <div class="card card-custom gutter-b card-stretch position-relative">
                    <div class="d-flex flex-row position-absolute" style="top: 10px; left: 10px;">
                        ${ribbonHTML}
                    </div>
                    <div class="card-body d-flex flex-column rounded bg-light justify-content-between">
                        <div class="text-center rounded mb-7">
                            <img src="${merchant.logo}" alt="${merchant.commerce_name}" class="mw-100 w-200px">
                        </div>
                        <div>
                            <h4 class="font-size-h5">
                                <span href="#" class="text-dark-75 font-weight-bolder">${merchant.commerce_name}</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        `;
                    container.innerHTML += cardHTML;
                });

                initializePopovers(); // Initialize popovers after rendering
                attachObserver(); // Attach observer to the last element
            }

            // Generate ribbon based on merchant status
            function generateRibbon(merchant) {
                if (merchant.status_id === 1) {
                    return `<div class="ribbon-target bg-orange-light mr-2">Nuevo</div>`;
                } else if (merchant.status_id === 2) {
                    return `<div class="ribbon-target bg-orange-light mr-2">Destacado</div>`;
                } else if (merchant.status_id === 3) {
                    return `<div class="ribbon-target bg-orange-light mr-2">Próximamente</div>`;
                } else if (merchant.status_id === 4 && merchant.external_codes_description) {
                    return `
            <div class="ribbon-target bg-orange-popover mr-2"
                 data-toggle="popover"
                 data-placement="top"
                 data-content="${merchant.external_codes_description}"
                 data-trigger="hover">
                 Código Externo
            </div>
        `;
                }
                return '';
            }

            // Initialize popovers
            function initializePopovers() {
                $(function () {
                    $('[data-toggle="popover"]').popover();
                });
            }

            // Observer to detect the last element
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !isLoading) {
                        fetchMerchantsData(); // Load more data when the last element becomes visible
                    }
                });
            });

            // Attach the observer to the last element
            function attachObserver() {
                const targets = document.querySelectorAll('.observer-target');
                const lastTarget = targets[targets.length - 1];
                if (lastTarget) {
                    observer.observe(lastTarget); // Observe the last element
                }
            }

            // Listeners for filters and search bar
            document.querySelectorAll('input[name="category"]').forEach(element => {
                element.addEventListener('change', () => {
                    category = element.value;
                    resetAndFetch();
                });
            });

            document.querySelectorAll('input[name="status"]').forEach(element => {
                element.addEventListener('change', () => {
                    status = element.value;
                    resetAndFetch();
                });
            });

            document.querySelectorAll('input[name="sales_channel"]').forEach(element => {
                element.addEventListener('change', () => {
                    sales_channel = element.value;
                    resetAndFetch();
                });
            });

            document.getElementById('kt_datatable_search_query').addEventListener('input', function () {
                search = this.value;
                resetAndFetch();
            });
        });
    </script>

    <!-- Mobile Menu Button Styles -->
    <style>
        /* Hide the sidebar by default on mobile devices */
        #kt_profile_aside {
            display: none;
            position: fixed;
            top: 55px;
            padding-bottom: 45px;
            left: 0;
            background: white;
            height: 100%;
            width: 80%;
            z-index: 8;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        /* Show the button on mobile devices */
        #toggle-filters-btn {
            display: block;
            background: linear-gradient(45deg, #ff6b2c, #ff8209);
            margin-bottom: 0 !important;
            margin-left: 25px !important;
            color: whitesmoke;
        }

        /* Show the sidebar on large screens */
        @media (min-width: 992px) {
            #kt_profile_aside {
                display: block;
                position: relative;
                padding-bottom: 24px;
                top: 0;
                height: auto;
                width: auto;
                box-shadow: none;
            }

            #toggle-filters-btn {
                display: none;
            }
        }
    </style>

    <!--Mobile Menu Button JS-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggle-filters-btn');
            const filtersAside = document.getElementById('kt_profile_aside');
            const body = document.body;

            // Function to handle Aside visibility on resize
            function handleResize() {
                if (window.innerWidth >= 768) { // Define breakpoint (e.g., 768px for tablets and larger)
                    filtersAside.style.display = 'block'; // Always show Aside on wider screens
                    toggleBtn.textContent = 'Ocultar filtros';
                } else if (filtersAside.style.display !== 'block') {
                    filtersAside.style.display = 'none'; // Keep it hidden on smaller screens
                    toggleBtn.textContent = 'Mostrar filtros';
                }
            }

            // Initial call to set visibility based on current screen size
            handleResize();

            // Listen for screen size changes
            window.addEventListener('resize', handleResize);

            // Toggle menu visibility on button click
            toggleBtn.addEventListener('click', function (event) {
                event.stopPropagation();
                if (filtersAside.style.display === 'block') {
                    filtersAside.style.display = 'none';
                    toggleBtn.textContent = 'Mostrar filtros';
                } else {
                    filtersAside.style.display = 'block';
                    toggleBtn.textContent = 'Ocultar filtros';
                }
            });

            // Close menu when clicking outside
            body.addEventListener('click', function (event) {
                const clickedInsideFilters = filtersAside.contains(event.target);
                const clickedOnButton = toggleBtn.contains(event.target);

                if (!clickedInsideFilters && !clickedOnButton && filtersAside.style.display === 'block' && window.innerWidth < 768) {
                    filtersAside.style.display = 'none';
                    toggleBtn.textContent = 'Mostrar filtros';
                }
            });

            // Prevent menu from closing when interacting with elements inside
            filtersAside.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        });
    </script>

</head>
<body class="inner-page" style="padding-top: 98.0625px; background: #FFFFFF" data-new-gr-c-s-check-loaded="14.1134.0" data-gr-ext-installed="">
<header id="header-main">
    <nav class="navbar navbar-expand-lg">
        <div class="container container-big">
            <!-- Logo -->
            <a class="logo" href="https://flavorite.io/">
                <img src="https://flavorite.io/wp-content/themes/flavorite/img/logo.png" class="w-100" alt="">
            </a>
            <button class="hamburger hamburger--spring navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="hamburger-box">
<span class="hamburger-inner"></span>
</span>
            </button>
            <!-- navbar links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="logo d-lg-none" href="https://flavorite.io/">
                    <img src="https://flavorite.io/wp-content/themes/flavorite/img/logo.png" class="w-100" alt="">
                </a>
                <ul id="primary-menu" class="navbar-nav ml-auto"><li id="menu-item-161" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-161 nav-item"><a href="https://flavorite.io/servicios/" class="nav-link">Servicios</a></li>
                    <li id="menu-item-164" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-164 nav-item current_page_item"><a href="https://flavorite.io/comercios/" aria-current="page" class="nav-link">Comercios afiliados</a></li>
                    <li id="menu-item-160" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-164 nav-item"><a href="https://flavorite.io/contactanos/" class="nav-link">Contáctanos</a></li>
                    <li id="menu-item-160" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-88 menu-item-160 nav-item"><a href="https://flavorite.io/saldo/" class="nav-link">Saldo</a></li>
                </ul>        </div>
        </div>
    </nav>
</header>

<!--Carousel Section-->
<section class="carousel-section">
    <div class="carousel">
        <div class="carousel-container">
            <img src="images/LaiLai.png" alt="Imagen 1" class="carousel-image">
            <img src="images/LaiLai.png" alt="Imagen 2" class="carousel-image">
            <img src="images/LaiLai.png" alt="Imagen 3" class="carousel-image">
            <img src="images/LaiLai.png" alt="Imagen 4" class="carousel-image">
        </div>
        <div class="carousel-navigation">
            <button class="carousel-button prev" onclick="prevSlide()">&#10094;</button>
            <button class="carousel-button next" onclick="nextSlide()">&#10095;</button>
        </div>
        <div class="carousel-indicators">
            <span class="indicator" onclick="showSlide(0)"></span>
            <span class="indicator" onclick="showSlide(1)"></span>
            <span class="indicator" onclick="showSlide(2)"></span>
            <span class="indicator" onclick="showSlide(3)"></span>
        </div>
    </div>
</section>

<!--Filters, Searching Bar & CA Section-->
<section class="fca-container">
    <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <div class="container">

            <!--begin::Upper Layout-->
            <div class="d-flex flex-row">
                <!--begin::Searching Bar-->
                <div class="input-icon" style="width: 315px; margin: auto; border-color: #ff8209;">
                    <label for="kt_datatable_search_query"></label>
                    <input type="text" class="form-control" placeholder="Buscar comercios afiliados..." id="kt_datatable_search_query" style="border-color: #ff8209; color: #333;">
                    <span style="right: 0; top: 5px; left: 3px;">
                    <i class="flaticon2-search-1" style="color: #ff8209;"></i>
                </span>
                </div>
                <!--end::Searching Bar-->

                <!--begin::Mobile Menu Button-->
                <button id="toggle-filters-btn" class="btn btn-secondary d-lg-none mb-4">
                    Mostrar filtros
                </button>
                <!--end::Mobile Menu Button-->
            </div>
            <!--end::Upper Layout-->

            <!--begin::Page Layout-->
            <div class="d-flex flex-row">

                <!--begin::Aside (Filter section, collapsible on small screens)-->
                <div class="flex-column offcanvas-mobile w-300px w-xl-325px" id="kt_profile_aside">
                    <!--begin::Forms Widget 15-->
                    <div class="card card-custom gutter-b">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Form-->
                            <form>
                                <!--begin::Categories-->
                                <div class="form-group mb-7">
                                    <label class="font-size-h3 font-weight-bolder text-dark mb-7">Categorías</label>
                                    <div class="radio-list" id="category-filters">
                                        <div class="radio-item">
                                            <label class="radio radio-lg mb-7">
                                                <input type="radio" name="category" value="all" checked>
                                                <span></span>
                                                <div class="font-size-lg text-dark-75 font-weight-bold">Todos</div>
                                            </label>
                                        </div>
                                        <?php $counter = 1; ?>
                                        <?php foreach ($categories as $category): ?>
                                            <div class="radio-item <?= $counter >= 5 ? 'hiddenCAT' : '' ?>">
                                                <label class="radio radio-lg mb-7">
                                                    <input type="radio" name="category" value="<?= htmlspecialchars($category['id']) ?>">
                                                    <span></span>
                                                    <div class="font-size-lg text-dark-75 font-weight-bold"><?= htmlspecialchars($category['name']) ?></div>
                                                </label>
                                            </div>
                                            <?php $counter++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="show-moreCAT btn btn-link">Mostrar más</button>
                                    <button class="show-lessCAT btn btn-link" style="display: none;">Mostrar menos</button>
                                </div>
                                <!--end::Categories-->

                                <!--begin::Status-->
                                <div class="form-group mb-7">
                                    <label class="font-size-h3 font-weight-bolder text-dark mb-7">Estado</label>
                                    <div class="radio-list" id="status-filters">
                                        <div class="radio-item">
                                            <label class="radio radio-lg mb-7">
                                                <input type="radio" name="status" value="all" checked>
                                                <span></span>
                                                <div class="font-size-lg text-dark-75 font-weight-bold">Todos</div>
                                            </label>
                                        </div>
                                        <?php $counter = 0; ?>
                                        <?php foreach ($statuses as $status): ?>
                                            <div class="radio-item <?= $counter >= 5 ? 'hidden2' : '' ?>">
                                                <label class="radio radio-lg mb-7">
                                                    <input type="radio" name="status" value="<?= htmlspecialchars($status['id']) ?>">
                                                    <span></span>
                                                    <div class="font-size-lg text-dark-75 font-weight-bold"><?= htmlspecialchars($status['name']) ?></div>
                                                </label>
                                            </div>
                                            <?php $counter++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <!--end::Status-->

                                <!--begin::Sales Channels-->
                                <div class="form-group mb-7">
                                    <label class="font-size-h3 font-weight-bolder text-dark mb-7">Modalidad de venta</label>
                                    <div class="radio-list" id="sc-filters">
                                        <div class="radio-item">
                                            <label class="radio radio-lg mb-7">
                                                <input type="radio" name="sales_channel" value="all" checked>
                                                <span></span>
                                                <div class="font-size-lg text-dark-75 font-weight-bold">Todos</div>
                                            </label>
                                        </div>
                                        <?php $counter = 1; ?>
                                        <?php foreach ($sales_channels as $sales_channel): ?>
                                            <div class="radio-item <?= $counter >= 5 ? 'hiddenSC' : '' ?>">
                                                <label class="radio radio-lg mb-7">
                                                    <input type="radio" name="sales_channel" value="<?= htmlspecialchars($sales_channel['id']) ?>">
                                                    <span></span>
                                                    <div class="font-size-lg text-dark-75 font-weight-bold"><?= htmlspecialchars($sales_channel['name']) ?></div>
                                                </label>
                                            </div>
                                            <?php $counter++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="show-moreSC btn btn-link">Mostrar más</button>
                                    <button class="show-lessSC btn btn-link" style="display: none;">Mostrar menos</button>
                                </div>
                                <!--end::Sales Channels-->

                                <button type="submit" class="btn btn-secondary font-weight-bolder mr-2 px-8" style="background: #ff6b2c; color: whitesmoke;">Quitar filtros</button>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Forms Widget 15-->
                </div>
                <!--end::Aside-->

                <!--begin::Layout-->
                <div class="flex-row-fluid ml-lg-8">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-body">
                            <div class="row" id="merchants-container">
                                <?php foreach ($commerces as $commerce): ?>
                                    <div class="col-md-4 col-lg-12 col-xxl-4 commerce-card">
                                        <div class="card card-custom gutter-b card-stretch position-relative">
                                            <!--begin::Ribbons-->
                                            <div class="d-flex flex-row position-absolute" style="top: 10px; left: 10px;">
                                                <?php if ($commerce['status_id'] === 1): ?>
                                                    <div class="ribbon-target bg-orange-light mr-2">Nuevo</div>
                                                <?php endif; ?>
                                                <?php if ($commerce['status_id'] === 2): ?>
                                                    <div class="ribbon-target bg-orange-light mr-2">Destacado</div>
                                                <?php endif; ?>
                                                <?php if ($commerce['status_id'] === 3): ?>
                                                    <div class="ribbon-target bg-orange-light mr-2">Próximamente</div>
                                                <?php endif; ?>
                                                <?php if ($commerce['status_id'] === 4 && !empty($commerce['external_codes_description'])): ?>
                                                    <div class="ribbon-target bg-orange-popover mr-2"
                                                         data-toggle="popover"
                                                         data-placement="top"
                                                         data-content="<?= htmlspecialchars($commerce['external_codes_description'], ENT_QUOTES, 'UTF-8'); ?>">
                                                        Código Externo
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <!--end::Ribbons-->

                                            <!--begin::Card Content-->
                                            <div class="card-body d-flex flex-column rounded bg-light justify-content-between">
                                                <div class="text-center rounded mb-7">
                                                    <img src="<?= htmlspecialchars($commerce['logo']) ?>" alt="<?= htmlspecialchars($commerce['commerce_name']) ?>" class="mw-100 w-200px">
                                                </div>
                                                <div>
                                                    <h4 class="font-size-h5">
                                                        <span class="text-dark-75 font-weight-bolder"><?= htmlspecialchars($commerce['commerce_name']) ?></span>
                                                    </h4>
                                                </div>
                                            </div>
                                            <!--end::Card Content-->
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- Loader (hidden initially) -->
                            <div id="loader" style="display:none; text-align: center;">
                                <p>Cargando...</p>
                        </div>
                    </div>
                </div>
                <!--end::Layout-->
            </div>
        </div>
    </div>
    <!--end::Entry-->
</div>
</section>

<footer class="main-footer">
    <div class="footer-top-wrap pt-50 pb-35">
        <div class="container container-big">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget mb-50 pr-80">
                        <li id="media_image-2" class="widget widget_media_image"><img width="250" height="65" src="https://i0.wp.com/flavorite.io/wp-content/uploads/2020/04/Blanco-Transparente.png?fit=250%2C65&amp;ssl=1" class="image wp-image-654 attachment-250x65 size-250x65 jetpack-lazy-image jetpack-lazy-image--handled" alt="" decoding="async" style="max-width: 100%; height: auto;" srcset="https://i0.wp.com/flavorite.io/wp-content/uploads/2020/04/Blanco-Transparente.png?w=795&amp;ssl=1 795w, https://i0.wp.com/flavorite.io/wp-content/uploads/2020/04/Blanco-Transparente.png?resize=300%2C78&amp;ssl=1 300w, https://i0.wp.com/flavorite.io/wp-content/uploads/2020/04/Blanco-Transparente.png?resize=768%2C200&amp;ssl=1 768w" data-lazy-loaded="1" sizes="(max-width: 250px) 100vw, 250px" loading="eager"></li>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget mb-50 mt-25 text-white">
                        <div class="fw-link">
                            <div class="footer-widget mb-50 mt-25 text-white"><div class="menu-menu-1-container"><ul id="menu-menu-1" class="menu"><li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-161"><a href="https://flavorite.io/servicios/" class="nav-link">Servicios</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-164"><a href="https://flavorite.io/comercios/" class="nav-link">Comercios afiliados</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-88 current_page_item menu-item-160"><a href="https://flavorite.io/contactanos/" aria-current="page" class="nav-link">Contáctanos</a></li>
                                    </ul></div></div>							            			</div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="footer-widget mt-25 mb-50">
                        <div class="widget_text footer-widget mt-25 mb-50"><div class="textwidget custom-html-widget"><a href="https://apps.apple.com/gt/app/flavorite/id1569689509?itsct=apps_box_badge&amp;itscg=30200" style="display: inline-block; overflow: hidden; border-radius: 13px; width: 250px; height: 83px;"><img src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/es-mx?size=250x83&amp;releaseDate=1623888000&amp;h=a847cd82af59c830400b68860c3a044c" alt="Descargalo en el  App Store" style="border-radius: 13px; width: 250px; height: 83px;" class="jetpack-lazy-image jetpack-lazy-image--handled" data-lazy-loaded="1" loading="eager"><noscript><img data-lazy-fallback="1" src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/es-mx?size=250x83&amp;releaseDate=1623888000&h=a847cd82af59c830400b68860c3a044c" alt="Descargalo en el  App Store" style="border-radius: 13px; width: 250px; height: 83px;"  /></noscript></a>
                                <div>
                                    <br>
                                </div>
                                <a href="https://play.google.com/store/apps/details?id=io.flavorite.plus&amp;pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1"><img alt="Disponible en Google Play" src="https://i0.wp.com/flavorite.io/wp-content/uploads/2021/06/Asset-4xhdpi.png?w=640&amp;ssl=1" style="border-radius: 13px; width: 250px; height: 83px;" data-recalc-dims="1" class="jetpack-lazy-image jetpack-lazy-image--handled" data-lazy-loaded="1" loading="eager"><noscript><img data-lazy-fallback="1" alt='Disponible en Google Play' src='https://i0.wp.com/flavorite.io/wp-content/uploads/2021/06/Asset-4xhdpi.png?w=640&#038;ssl=1' style="border-radius: 13px; width: 250px; height: 83px;" data-recalc-dims="1"  /></noscript></a>
                                <div>
                                    <br>
                                </div>
                                <a href="https://appgallery.huawei.com/#/app/C104490853"><img alt="Explora aqui App Gallery" src="https://i0.wp.com/flavorite.io/wp-content/uploads/2021/08/Huawei.png?w=640&amp;ssl=1" style="border-radius: 13px; width: 250px; height: 83px;" data-recalc-dims="1" data-lazy-src="https://i0.wp.com/flavorite.io/wp-content/uploads/2021/08/Huawei.png?w=640&amp;is-pending-load=1#038;ssl=1" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class=" jetpack-lazy-image"><noscript><img data-lazy-fallback="1" alt='Explora aqui App Gallery' src='https://i0.wp.com/flavorite.io/wp-content/uploads/2021/08/Huawei.png?w=640&#038;ssl=1' style="border-radius: 13px; width: 250px; height: 83px;" data-recalc-dims="1"  /></noscript></a>
                            </div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright  2024 Flavorite | All Rights Reserved | Developed by Emilio Solano [21212] - UVG | Hosted by jiWebHosting.com -->
</footer>
</body>
</html>
