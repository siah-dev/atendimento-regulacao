<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - Dashboard</title>
    <?php $this->head() ?>
    <link href="<?= Yii::$app->urlManager->baseUrl ?>/css/datepicker3.css" rel="stylesheet">
    <link href="<?= Yii::$app->urlManager->baseUrl ?>/css/styles.css" rel="stylesheet">

    <!--Icons-->
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/lumino.glyphs.js"></script>

    <!--[if lt IE 9]>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/html5shiv.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<?php $this->beginBody() ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span><?= Html::encode($this->title) ?></span> Admin</a>
            <!--
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
                        <li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
                        <li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
                    </ul>
                </li>
            </ul>
            -->
        </div>

    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <!--
    <form role="search">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </form>
    -->
    <ul class="nav menu">
        <li class="active"><a href=""><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
        <li><a href="<?= Yii::$app->urlManager->createUrl('users/index') ?>"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Usuário</a></li>
        <li><a href="<?= Yii::$app->urlManager->createUrl('relatorios/index') ?>"><svg class="glyph stroked app-window"><use xlink:href="#stroked-app-window"></use></svg> Relatórios</a></li>
        <li><a href="<?= Yii::$app->urlManager->createUrl('unidades/index') ?>"><svg class="glyph stroked app-window"><use xlink:href="#stroked-app-window"></use></svg> Unidades</a></li>
        <!--
        <li class="parent ">
            <a href="#">
                <span data-toggle="collapse" href="#sub-item-1"><svg class="glyph stroked chevron-down"><use xlink:href="#stroked-chevron-down"></use></svg></span> Dropdown
            </a>
            <ul class="children collapse" id="sub-item-1">
                <li>
                    <a class="" href="#">
                        <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Sub Item 1
                    </a>
                </li>
                <li>
                    <a class="" href="#">
                        <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Sub Item 2
                    </a>
                </li>
                <li>
                    <a class="" href="#">
                        <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg> Sub Item 3
                    </a>
                </li>
            </ul>
        </li>
        -->
        <li role="presentation" class="divider"></li>
        <li><a href="<?= Yii::$app->urlManager->createUrl('user/logout') ?>"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Sair</a></li>
    </ul>

</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => Yii::t('yii', 'Painel'),
                'url' => ['painel/index'],
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
</div><!--/.row-->

<div class="row">
        <?= $content ?>

</div><!--/.row-->
</div><!--/.row-->


<script src="<?= Yii::$app->urlManager->baseUrl ?>/js/chart.min.js"></script>
<script src="<?= Yii::$app->urlManager->baseUrl ?>/js/chart-data.js"></script>
<script src="<?= Yii::$app->urlManager->baseUrl ?>/js/easypiechart.js"></script>
<script src="<?= Yii::$app->urlManager->baseUrl ?>/js/easypiechart-data.js"></script>
<script src="<?= Yii::$app->urlManager->baseUrl ?>/js/bootstrap-datepicker.js"></script>
<script>
    $('#calendar').datepicker({
    });

    !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>