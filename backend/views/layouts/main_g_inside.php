<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

$bundle = yiister\gentelella\assets\Asset::register($this);


use backend\libraries\RBAC;

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title hidden-small" style="border: 0;">
                    <?= Html::img('@web/asset_files/images/logo-light-sms.png', ['alt' => 'Logo','width' => '200px', 'style' => 'padding: 30px;','class'=>'img-responsive']) ?>
                </div>
                <div class="clearfix"></div>

               

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <h3></h3>
                        <?php 
                        if (!Yii::$app->user->isGuest) {
                        ?>
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => [
                                    ["label" => "Dashboard", "url" => ["site/index"], "icon" => "dashboard"],
                                    ["label" => "Clients", "url" => ["clients/index"], "icon" => "cogs", 'visible' => RBAC::can(RBAC::manage_clients)],
                                    
                                    
                                    [
                                        "label" => "User Management",
                                        "icon" => "users",
                                        "url" => "#",
                                        'visible' => RBAC::can(RBAC::manage_users),
                                        "items" => [
                                            ["label" => "Users", "url" => ["user/index"], 'visible' => RBAC::can(RBAC::manage_users)],
                                            ["label" => "Groups", "url" => ["groups/index"], 'visible' => RBAC::can(RBAC::manage_groups)],
                                            ["label" => "User Groups", "url" => ["user-groups/index"], 'visible' => RBAC::can(RBAC::manage_user_groups)],
                                            ["label" => "Permissions", "url" => ["permissions/index"], 'visible' => RBAC::can(RBAC::manage_permissions)],
                                            ["label" => "Actions", "url" => ["actions/index"], 'visible' => RBAC::can(RBAC::manage_actions)],
                                        ],
                                    ],
                                    [
                                        "label" => "Reports",
                                        "icon" => "fa fa-bar-chart-o",
                                        "url" => "#",
                                        'visible' => TRUE,
                                        "items" => [
                                            ["label" => "User Audits", "url" => ["user-audits/index"], 'visible' => RBAC::can(RBAC::view_user_audits)],
                                            
                                        ],
                                    ],
                                    ["label" => "Logout", "url" => ["site/logout"], "icon" => "lock"],
                                    
                                    
                                ],
                            ]
                        )
                        ?>
                        <?php 
                        }else{
                        ?>
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                                "items" => [
                                    
                                    ["label" => "Login", "url" => ["site/login"], "icon" => "lock"],
                                    
                                    
                                ],
                            ]
                        )
                        ?>

                        <?php
                        }
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <?php 
                        if (!Yii::$app->user->isGuest) {
                    ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i> <?php echo Yii::$app->user->identity->names ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                <?= Html::a( '<i class="fa fa-user pull-right"></i> Profile', ['user/view-profile'], $options = [] ) ?>
                                </li>
                                
                                <li>
                                <?= Html::a( '<i class="fa fa-sign-out pull-right"></i> Logout', ['site/logout'], $options = [] ) ?>
                                </li>
                            </ul>
                        </li>

                        
                            </ul>
                        </li>

                    </ul>
                    <?php 
                        }
                        ?>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>

            <?= $this->render('_alerts_partial.php') ?>
            <?= $content ?>
        </div>
        <!-- /page content -->
        
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
