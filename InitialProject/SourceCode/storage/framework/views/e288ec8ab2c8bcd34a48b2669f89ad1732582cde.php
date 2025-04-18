
<style>
    body label:not(.input-group-text) {
        margin-top: 10px;
    }

    body .my-select {
        background-color: #fff;
        color: #212529;
        border: #000 0.2 solid;
        border-radius: 10px;
        padding: 6px 20px;
        width: 100%;
    }
</style>
<?php $__env->startSection('title','Profile'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<?php $__env->startSection('content'); ?>
<div class="container profile">
    <div class="bg-white shadow rounded-lg d-block d-sm-flex">
        <div class="profile-tab-nav border-right">
            <div class="p-4">
                <div class="img-circle text-center mb-3">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle admin_picture" src="<?php echo e(Auth::user()->picture); ?>" alt="User profile picture">
                    </div>
                    <h4 class="text-center p-2"><?php echo e(Auth::user()->fname); ?> <?php echo e(Auth::user()->lname); ?></h4>
                    <input type="file" name="admin_image" id="admin_image" style="opacity: 0;height:1px;display:none">
                    <a href="javascript:void(0)" class="btn btn-primary btn-block btn-sm" id="change_picture_btn"><b>Change picture</b></a>
                </div>

            </div>
            <div class="nav flex-column nav-pills-1" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link " id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
                    <i class="mdi mdi-account-card-details"></i>
                    <span class="menu-title"><?php echo e(trans('message.account')); ?></span>
                </a>
                <a class="nav-link " id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
                    <i class="mdi mdi-key-variant"></i>
                    <span class="menu-title"><?php echo e(trans('message.password')); ?></span>
                </a>
                <?php if(Auth::user()->hasRole('teacher')): ?>
                <a class="nav-link <?php echo e(old('tab') == 'expertise' ? ' active' : null); ?>" id="expertise-tab" data-toggle="pill" href="#expertise" role="tab" aria-controls="expertise" aria-selected="false">
                    <i class="mdi mdi-account-star"></i>
                    <span class="menu-title"><?php echo e(trans('message.expertise')); ?></span>
                </a>
                <a class="nav-link" id="education-tab" data-toggle="pill" href="#education" role="tab" aria-controls="education" aria-selected="false">
                    <i class="mdi mdi-school"></i>
                    <span class="menu-title"><?php echo e(trans('message.education')); ?></span>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
            <!-- <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab"> -->
            <div class="tab-pane " id="account" role="tabpanel" aria-labelledby="account-tab">
                <h3 class="mb-4"><?php echo e(trans('message.profile_setting')); ?></h3>
                <form class="form-horizontal" method="POST" action="<?php echo e(route('adminUpdateInfo')); ?>" id="AdminInfoForm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group col-sm-4">
                                <label><?php echo e(trans('message.prefix')); ?></label>
                                <select class="custom-select my-select " name="title_name_en">
                                    <option value="Mr." <?php echo e(Auth::user()->title_name_en == 'Mr.' ? 'selected' : ''); ?>>Mr.</option>
                                    <option value="Miss" <?php echo e(Auth::user()->title_name_en == 'Miss' ? 'selected' : ''); ?>>Miss</option>
                                    <option value="Mrs." <?php echo e(Auth::user()->title_name_en == 'Mrs.' ? 'selected' : ''); ?>>Mrs.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First name (EN)</label>
                                <input type="text" class="form-control" id="inputfNameEN" placeholder="Name" value="<?php echo e(Auth::user()->fname_en); ?>" name="fname_en">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last name (EN)</label>
                                <input type="text" class="form-control" id="inputlNameEN" placeholder="Name" value="<?php echo e(Auth::user()->lname_en); ?>" name="lname_en">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ชื่อ (TH)</label>
                                <input type="text" class="form-control" id="inputfNameTH" placeholder="Name" value="<?php echo e(Auth::user()->fname_th); ?>" name="fname_th">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>นามสกุล (TH)</label>
                                <input type="text" class="form-control" id="inputlNameTH" placeholder="Name" value="<?php echo e(Auth::user()->lname_th); ?>" name="lname_th">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" id="inputEmail" placeholder="Email" value="<?php echo e(Auth::user()->email); ?>" name="email">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <?php if(Auth::user()->hasRole('teacher')): ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Academic Ranks (EN)</label>
                                <select id="category" class="custom-select my-select" name="academic_ranks_en">
                                    <option value="Professor" <?php echo e(Auth::user()->academic_ranks_en == 'Professor' ? 'selected' : ''); ?>>Professor</option>
                                    <option value="Associate Professor" <?php echo e(Auth::user()->academic_ranks_en == 'Associate Professor' ? 'selected' : ''); ?>>Associate Professor</option>
                                    <option value="Assistant Professor" <?php echo e(Auth::user()->academic_ranks_en == 'Assistant Professor' ? 'selected' : ''); ?>>Assistant Professor</option>
                                    <option value="Lecturer" <?php echo e(Auth::user()->academic_ranks_en == 'Lecturer' ? 'selected' : ''); ?>>Lecturer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ตำแหน่งทางวิชาการ (TH)</label>
                                <select name="academic_ranks_th" id="subcategory" class="custom-select my-select">
                                    <optgroup id="Professor" label="Professor">
                                        <option value="ศาสตราจารย์" <?php echo e(Auth::user()->academic_ranks_th == 'ศาสตราจารย์' ? 'selected' : ''); ?>>ศาสตราจารย์</option>
                                    </optgroup>
                                    <optgroup id="Associate Professor" label="Associate Professor">
                                        <option value="รองศาสตราจารย์" <?php echo e(Auth::user()->academic_ranks_th == 'รองศาสตราจารย์' ? 'selected' : ''); ?>>รองศาสตราจารย์</option>
                                    </optgroup>
                                    <optgroup id="Assistant Professor" label="Assistant Professor">
                                        <option value="ผู้ช่วยศาสตราจารย์" <?php echo e(Auth::user()->academic_ranks_th == 'ผู้ช่วยศาสตราจารย์' ? 'selected' : ''); ?>>ผู้ช่วยศาสตราจารย์</option>
                                    </optgroup>
                                    <optgroup id="Lecturer" label="Lecturer">
                                        <option value="อาจารย์" <?php echo e(Auth::user()->academic_ranks_th == 'อาจารย์' ? 'selected' : ''); ?>>อาจารย์</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label><input name="pos" type="checkbox" value="check2" />สำหรับอ.ผู้ที่ไม่มีคุณวุฒิปริญญาเอก โปรดระบุ</label>
                                </div>

                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>


            <div class="tab-pane fade " id="password" role="tabpanel" aria-labelledby="password-tab">
                <form class="form-horizontal" action="<?php echo e(route('adminChangePassword')); ?>" method="POST" id="changePasswordAdminForm">
                    <h3 class="mb-4">Password Settings</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Old password</label>
                                <input type="password" class="form-control" id="inputpassword" placeholder="Enter current password" name="oldpassword">
                                <span class="text-danger error-text oldpassword_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>New password</label>
                                <input type="password" class="form-control" id="newpassword" placeholder="Enter new password" name="newpassword">
                                <span class="text-danger error-text newpassword_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm new password</label>
                                <input type="password" class="form-control" id="cnewpassword" placeholder="ReEnter new password" name="cnewpassword">
                                <span class="text-danger error-text cnewpassword_error"></span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary">Update!!</button>
                        <!-- <button class="btn btn-light">Cancel</button> -->
                    </div>

                </form>
            </div>
            <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                <form class="form-horizontal" method="POST" action="<?php echo e(route('updateEdInfo')); ?>" id="EdInfoForm">
                    <h3 class="mb-4"><?php echo e(trans('message.educational_record')); ?></h3>
                    <div class="row">
                        <label><?php echo e(trans('message.bachelor')); ?></label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo e(trans('message.university_name')); ?></label>
                                <?php if(empty(Auth::user()->education[0]->uname)): ?>
                                <input type="text" class="form-control" id="inputlBUName" placeholder="ชื่อมหาวิทยาลัย" value="" name="b_uname">
                                <?php else: ?>
                                <input type="text" class="form-control" id="inputlBUName" placeholder="ชื่อมหาวิทยาลัย" value="<?php echo e(Auth::user()->education[0]->uname); ?>" name="b_uname">
                                <?php endif; ?>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo e(trans('message.degree_name')); ?></label>
                                <?php if(empty(Auth::user()->education[0]->qua_name)): ?>
                                <input type="text" class="form-control" id="inputlBQuName" placeholder="ชื่อวุฒิปริญญา" value="" name="b_qua_name">
                                <?php else: ?>
                                <input type="text" class="form-control" id="inputlBQuName" placeholder="ชื่อวุฒิปริญญา" value="<?php echo e(Auth::user()->education[0]->qua_name); ?>" name="b_qua_name">
                                <?php endif; ?>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo e(trans('message.graduation_year')); ?></label>
                                <?php if(empty(Auth::user()->education[0]->year)): ?>
                                <input type="text" class="form-control" id="inputlYear" placeholder="ปี พ.ศ. ที่จบ" value="" name="b_year">
                                <?php else: ?>
                                <input type="text" class="form-control" id="inputlYear" placeholder="ปี พ.ศ. ที่จบ" value="<?php echo e(Auth::user()->education[0]->year); ?>" name="b_year">
                                <?php endif; ?>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label><?php echo e(trans('message.master')); ?></label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo e(trans('message.university_name')); ?></label>
                                <?php if(empty(Auth::user()->education[1]->uname)): ?>
                                <input type="text" class="form-control" id="inputlMUName" placeholder="ชื่อมหาวิทยาลัย" value="" name="m_uname">
                                <?php else: ?>
                                <input type="text" class="form-control" id="inputlMUName" placeholder="ชื่อมหาวิทยาลัย" value="<?php echo e(Auth::user()->education[1]->uname); ?>" name="m_uname">
                                <?php endif; ?>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo e(trans('message.degree_name')); ?></label>
                                <?php if(empty(Auth::user()->education[1]->qua_name)): ?>
                                <input type="text" class="form-control" id="inputlMQuName" placeholder="ชื่อวุฒิปริญญา" value="" name="m_qua_name">
                                <?php else: ?>
                                <input type="text" class="form-control" id="inputlMQuName" placeholder="ชื่อวุฒิปริญญา" value="<?php echo e(Auth::user()->education[1]->qua_name); ?>" name="m_qua_name">
                                <?php endif; ?>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo e(trans('message.graduation_year')); ?></label>
                                <?php if(empty(Auth::user()->education[1]->year)): ?>
                                <input type="text" class="form-control" id="inputlYear" placeholder="ปี พ.ศ. ที่จบ" value="" name="m_year">
                                <?php else: ?>
                                <input type="text" class="form-control" id="inputlYear" placeholder="ปี พ.ศ. ที่จบ" value="<?php echo e(Auth::user()->education[1]->year); ?>" name="m_year">
                                <?php endif; ?>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label><?php echo e(trans('message.doctoral')); ?></label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo e(trans('message.university_name')); ?></label>
                                <?php if(empty(Auth::user()->education[2]->uname)): ?>
                                <input type="text" class="form-control" id="inputlDUName" placeholder="ชื่อมหาวิทยาลัย" value="" name="d_uname">
                                <?php else: ?>
                                <input type="text" class="form-control" id="inputlDUName" placeholder="ชื่อมหาวิทยาลัย" value="<?php echo e(Auth::user()->education[2]->uname); ?>" name="d_uname">
                                <?php endif; ?>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo e(trans('message.degree_name')); ?></label>
                                <?php if(empty(Auth::user()->education[2]->qua_name)): ?>
                                <input type="text" class="form-control" id="inputlDQuName" placeholder="ชื่อวุฒิปริญญา" value="" name="d_qua_name">
                                <?php else: ?>
                                <input type="text" class="form-control" id="inputlDQuName" placeholder="ชื่อวุฒิปริญญา" value="<?php echo e(Auth::user()->education[2]->qua_name); ?>" name="d_qua_name">
                                <?php endif; ?>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo e(trans('message.graduation_year')); ?></label>
                                <?php if(empty(Auth::user()->education[2]->year)): ?>
                                <input type="text" class="form-control" id="inputlYear" placeholder="ปี พ.ศ. ที่จบ" value="" name="d_year">
                                <?php else: ?>
                                <input type="text" class="form-control" id="inputlYear" placeholder="ปี พ.ศ. ที่จบ" value="<?php echo e(Auth::user()->education[2]->year); ?>" name="d_year">
                                <?php endif; ?>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary">Update</button>
                        <!-- <button class="btn btn-light">Cancel</button> -->
                    </div>

                </form>

            </div>
            <div class="tab-pane fade show<?php echo e(old('tab') == 'expertise' ? ' active' : null); ?>" id="expertise" role="tabpanel" aria-labelledby="expertise-tab">
                <h3 class="mb-4"><?php echo e(trans('message.expertise')); ?></h3>
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <!-- <a href="javascript:void(0)" class="btn btn-success mb-2" id="new-expertise" data-toggle="modal">Add Expertise</a> -->
                            <button type="button" class="btn btn-primary btn-menu1 btn-icon-text btn-sm mb-3" data-toggle="modal" data-target="#crud-modal">
                                <i class="mdi mdi-plus btn-icon-prepend"></i><?php echo e(trans('message.add')); ?>

                            </button>
                        </div>
                    </div>
                </div>
                <br />
                <?php if($message = Session::get('success')): ?>
                <div class="alert alert-success">
                    <p id="msg"><?php echo e($message); ?></p>
                </div>
                <?php endif; ?>


                <table class="table table-striped table-hover">
                    <tr>
                        <th colspan="2"><?php echo e(trans('message.expertise')); ?></th>

                    </tr>
                    <?php $__currentLoopData = Auth::user()->expertise; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr id="expert_id_<?php echo e($expert->id); ?>">
                        <td><?php echo e($expert->expert_name); ?></td>
                        <td width="180px">
                            <form action="<?php echo e(route('experts.destroy',$expert->id)); ?>" method="POST">
                                <!-- <a class="btn btn-info" id="show-expertise" data-toggle="modal" data-id="<?php echo e($expert->id); ?>">Show</a> -->
                                <li class="list-inline-item">
                                    <button class="btn btn-outline-success btn-sm" href="javascript:void(0)" id="edit-expertise" type="button" data-toggle="modal" data-placement="top" data-id="<?php echo e($expert->id); ?>" title="Edit"><i class="mdi mdi-pencil"></i></button>
                                </li>
                                <!-- <a href="javascript:void(0)" class="btn btn-success" id="edit-expertise" data-toggle="modal" data-id="<?php echo e($expert->id); ?>">Edit </a> -->
                                <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
                                <li class="list-inline-item">
                                    <button id="delete-expertise" data-id="<?php echo e($expert->id); ?>" class="btn btn-outline-danger btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="mdi mdi-delete"></i></button>
                                </li>
                                <!-- <a id="delete-expertise" data-id="<?php echo e($expert->id); ?>" class="btn btn-danger delete-user">Delete</a> -->
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </table>
            </div>

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="expertiseCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form name="expForm" action="<?php echo e(route('experts.store')); ?>" method="POST">
                    <input type="hidden" name="exp_id" id="exp_id">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <input type="text" name="expert_name" id="expert_name" class="form-control" placeholder="Expert_name" onchange="validate()">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Submit</button>
                            <!-- <a  href="<?php echo e(URL::previous()); ?>"class="btn btn-danger">Cancel</a>-->
                            <button class="btn btn-danger" id="btnCancel" data-dismiss="modal">Cancel</button>
                            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> -->
<!-- <script src="alert/dist/sweetalert-dev.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->


<script>
    $(document).ready(function() {
        var $optgroups = $('#subcategory > optgroup');

        $("#category").on("change", function() {
            var selectedVal = this.value;

            $('#subcategory').html($optgroups.filter('[id="' + selectedVal + '"]'));
        });
    });
</script>

<script>
    $(function() {
        /* UPDATE ADMIN
               PERSONAL INFO */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        showSwal = function(type) {
            swal({
                    title: "Are you sure update info",
                    text: "Are you sure to proceed?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#82ce34",
                    confirmButtonText: "Update My Info!",
                    cancelButtonText: "I am not sure!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        swal("Update Info", "Your account is updated!", "success");
                    } else {
                        swal("Cancle", "Account is not updated", "error");
                    }
                });
        }


        $('#AdminInfoForm').on('submit', function(e) {

            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,

                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix +
                                '_error').text(val[0]);
                        });
                    } else {
                        $('.admin_name').each(function() {
                            $(this).html($('#AdminInfoForm').find($(
                                'input[name="name"]')).val());
                        });
                        console.log(data.msg);
                        swal("Update Info", "Your account is updated!", "success");
                    }
                }
            });
        });
        // $('#AdminInfoForm').on('submit', function(e) {

        //     e.preventDefault();
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         method: $(this).attr('method'),
        //         data: new FormData(this),
        //         processData: false,
        //         dataType: 'json',
        //         contentType: false,

        //         beforeSend: function() {
        //             $(document).find('span.error-text').text('');
        //         },
        //         success: function(data) {
        //             if (data.status == 0) {
        //                 $.each(data.error, function(prefix, val) {
        //                     $('span.' + prefix +
        //                         '_error').text(val[0]);
        //                 });
        //             } else {
        //                 $('.admin_name').each(function() {
        //                     $(this).html($('#AdminInfoForm').find($(
        //                         'input[name="name"]')).val());
        //                 });

        //                 swal("Update Info", "Your account is updated!", "success");
        //             }
        //         }
        //     });
        // });
        $('#EdInfoForm').on('submit', function(e) {

            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,

                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix +
                                '_error').text(val[0]);
                        });
                    } else {
                        $('.admin_name').each(function() {
                            $(this).html($('#EdInfoForm').find($(
                                'input[name="name"]')).val());
                        });
                        console.log(data.msg)
                        swal("Update Info", "Your account is updated!", "success");
                    }
                }
            });
        });

        $(document).on('click', '#change_picture_btn', function() {
            $('#admin_image').click();
        });
        $('#admin_image').ijaboCropTool({
            preview: '.admin_picture',
            setRatio: 2 / 3,
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            buttonsText: ['CROP', 'QUIT'],
            buttonsColor: ['#30bf7d', '#ee5155', -15],
            processUrl: '<?php echo e(route("adminPictureUpdate")); ?>',
            withCSRF: ['_token', '<?php echo e(csrf_token()); ?>'],
            onSuccess: function(message, element, status) {
                //swal("Congrats!", message , "success");
                //alert(message);
                swal("Update Profile Picture", "Your account is updated!", "success");
            },
            onError: function(message, element, status) {
                alert(message);
            }
        });
        $('#changePasswordAdminForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $('span.' + prefix +
                                '_error').text(val[0]);
                        });
                    } else {
                        $('#changePasswordAdminForm')[0].reset();
                        //alert(data.msg);
                        swal("Update Password", "Your account is Password updated!", "success");
                    }
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {

        /* When click New expertise button */
        $('#new-expertise').click(function() {
            $('#btn-save').val("create-expertise");
            $('#expertise').trigger("reset");
            $('#expertiseCrudModal').html("Add New Expertise");
            $('#crud-modal').modal('show');

        });

        /* Edit expertise */
        $('body').on('click', '#edit-expertise', function() {
            var expert_id = $(this).data('id');
            $.get('experts/' + expert_id + '/edit', function(data) {
                $('#expertiseCrudModal').html("Edit Expertise");

                $('#btn-update').val("Update");
                $('#btn-save').prop('disabled', false);
                $('#crud-modal').modal('show');
                $('#exp_id').val(data.id);
                $('#expert_name').val(data.expert_name);

                //$('#v-pills-tabContent.a.active').removeClass("active");

                //$('li.list-group-item.active').removeClass("active");
                //$(this).addClass("active");

                //swal("Update Profile Picture", "Your account is updated!", "success");
            })

        });


        /* Delete expertise */
        $('body').on('click', '#delete-expertise', function() {
            var expert_id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");


            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("Delete Successfully", {
                        icon: "success",
                    }).then(function() {
                        location.reload();
                        $.ajax({
                            type: "DELETE",
                            url: "experts/" + expert_id,
                            data: {
                                "id": expert_id,
                                "_token": token,
                            },

                            success: function() {
                                $("#expert_id_" + expert_id).remove();
                                //swal("Done!", "It was succesfully deleted!", "success");

                                // $('#v-pills-tab.a.active').removeClass("active");
                                // $(this).addClass("active");
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("Error deleting!", "Please try again", "error");
                            }
                        });
                        
                    });

                }
            });
        });
    });
</script>


<script>
    error = false

    function validate() {
        if (document.expForm.expert_name.value != '')
            document.expForm.btnsave.disabled = false
        else
            document.expForm.btnsave.disabled = true
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboards.users.layouts.user-dash-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\File\CS Term 6\SoftEnProject\git-group-repository-group-2-sec-1\InitialProject\SourceCode\resources\views/dashboards/users/profile.blade.php ENDPATH**/ ?>