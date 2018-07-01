<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('ui/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('ui/vendor/font-awesome/css/font-awesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('ui/vendor/linearicons/style.css')); ?>">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('ui/css/main.css')); ?>">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="<?php echo e(asset('ui/css/demo.css')); ?>">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('ui/img/apple-icon.png')); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('ui/img/favicon.png')); ?>">
</head>

<body>
<!-- WRAPPER -->
<div id="wrapper">
    <div class="vertical-align-wrap">
        <div class="vertical-align-middle">
            <div class="auth-box ">
                <?php $__env->startSection('content'); ?>
                <?php echo $__env->yieldSection(); ?>
            </div>
        </div>
    </div>
</div>
<!-- END WRAPPER -->
</body>
</html>
