
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="justify-content-center">
        <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>
        <div class="card col-8" style="padding: 16px;"">
            <div class=" card-body">
            <h4 class="card-title"><?php echo e(trans('message.edit_user')); ?></h4>
            <p class="card-description"><?php echo e(trans('message.edit_in_user')); ?></p>
            <?php echo Form::model($user, ['route' => ['users.update', $user->id], 'method'=>'PATCH']); ?>

            <div class="form-group row">
                <div class="col-sm-6">
                    <p><b>ชื่อ (ภาษาไทย)</b></p>
                    <input type="text" name="fname_th" value="<?php echo e($user->fname_th); ?>" class="form-control" placeholder="<?php echo e($user->fname_th); ?>">
                </div>
                <div class="col-sm-6">
                    <p><b>นามสกุล (ภาษาไทย)</b></p>
                    <input type="text" name="lname_th" value="<?php echo e($user->lname_th); ?>" class="form-control" placeholder="<?php echo e($user->lname_th); ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <p><b>First Name (English)</b></p>
                    <input type="text" name="fname_en" value="<?php echo e($user->fname_en); ?>" class="form-control" placeholder="<?php echo e($user->fname_en); ?>">
                </div>
                <div class="col-sm-6">
                    <p><b>Last Name (English)</b></p>
                    <input type="text" name="lname_en" value="<?php echo e($user->lname_en); ?>" class="form-control" placeholder="<?php echo e($user->lname_en); ?>">
                </div>
            </div>
            <div class="form-group row">
                <p class="col-sm-3"><b>Email</b></p>
                <div class="col-sm-8">
                    <input type="text" name="email" value="<?php echo e($user->email); ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <p class="col-sm-3"><b>Password</b></p>
                <div class="col-sm-8">
                    <input type="password" name="password" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <p class="col-sm-3"><b>Confirm Password</b></p>
                <div class="col-sm-8">
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <p class="col-sm-3"><b>Role</b></p>
                <div class="col-sm-8">
                    <?php echo Form::select('roles[]', $roles, $userRole, array('class' => 'selectpicker','multiple data-live-search'=>"true")); ?>

                </div>
            </div>
            
            <div class="form-group row">
                <p class="col-sm-3"><b>Status</b></p>
                <div class="col-sm-8">
                    <select id='status' class="form-control" style='width: 200px;' name="status">
                        <option value="1" <?php echo e("1" == $user->status ? 'selected' : ''); ?>>กำลังศึกษา</option>
                        <option value="2" <?php echo e("2" == $user->status ? 'selected' : ''); ?>>จบการศึกษา</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <p for="category"><b>Department <span class="text-danger">*</span></b></p>
                    <select class="form-control" name="cat" id="cat" style="width: 100%;" required>
                        <option>Select Category</option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e($user->program->department_id == $cat->id  ? 'selected' : ''); ?>>
                            <?php echo e($cat->department_name_en); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <p for="category"><b>Program <span class="text-danger">*</span></b></p>
                    <select class="form-control select2" name="sub_cat" id="subcat" required>
                        <option>Select Category</option>
                        <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e($user->program->id == $cat->id  ? 'selected' : ''); ?>>
                            <?php echo e($cat->program_name_en); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>


            </div>

            <button type="submit" class="btn btn-primary mt-5">Submit</button>
            <a class="btn btn-light mt-5" href="<?php echo e(route('users.index')); ?>">Cancel</a>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<script>
    $('#cat').on('change', function(e) {
        var cat_id = e.target.value;
        $.get('/ajax-get-subcat?cat_id=' + cat_id, function(data) {
            $('#subcat').empty();
            $.each(data, function(index, areaObj) {
                $('#subcat').append('<option value="' + areaObj.id + '" >' + areaObj
                    .program_name_en + '</option>');
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboards.users.layouts.user-dash-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\File\CS Term 6\SoftEnProject\git-group-repository-group-2-sec-1\InitialProject\SourceCode\resources\views/users/edit.blade.php ENDPATH**/ ?>