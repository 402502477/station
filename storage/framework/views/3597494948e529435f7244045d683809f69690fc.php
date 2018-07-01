<?php $__env->startSection('title','后台登陆'); ?>
<?php $__env->startSection('content'); ?>
    <div class="left">
        <div class="content">
            <div class="header">
                <div class="logo text-center"><img src="<?php echo e(asset('ui/img/logo-dark.png')); ?>" alt="Klorofil Logo"></div>
                <p class="lead">Login to your account</p>
            </div>
            <form class="form-auth-small" action="<?php echo e(route('login')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="signin-email" class="control-label sr-only">Email</label>
                    <input type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" id="signin-email" value="<?php echo e(old('email')); ?>" name="email" placeholder="Email">
                    <?php if($errors->has('email')): ?>
                        <span class="invalid-feedback">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="signin-password" class="control-label sr-only">Password</label>
                    <input type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" id="signin-password" name="password" value="<?php echo e(old('password')); ?>" placeholder="Password">
                    <?php if($errors->has('password')): ?>
                        <span class="invalid-feedback">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="form-group clearfix">
                    <label class="fancy-checkbox element-left">
                        <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                        <span>Remember me</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                <div class="bottom">
                    <span class="helper-text"><i class="fa fa-lock"></i> <a href="<?php echo e(route('password.request')); ?>">Forgot password?</a></span>
                </div>
            </form>
        </div>
    </div>
    <div class="right">
        <div class="overlay"></div>
        <div class="content text">
            <h1 class="heading">Free Bootstrap dashboard template</h1>
            <p>by The Develovers</p>
        </div>
    </div>
    <div class="clearfix"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>