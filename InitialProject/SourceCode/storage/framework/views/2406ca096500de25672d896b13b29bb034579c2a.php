

<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">

<?php $__env->startSection('content'); ?>

<div class="container">
    <?php if($message = Session::get('success')): ?>
    <div class="alert alert-success">
        <p><?php echo e($message); ?></p>
    </div>
    <?php endif; ?>
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title"><?php echo e(trans('message.fund')); ?></h4>
            <a class="btn btn-primary btn-menu btn-icon-text btn-sm mb-3" href="<?php echo e(route('funds.create')); ?>"><i class="mdi mdi-plus btn-icon-prepend"></i><?php echo e(trans('message.add')); ?></a>
            <div class="table-responsive">
                <table id="example1" class="table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo e(trans('message.number_data')); ?></th>
                            <th><?php echo e(trans('message.capital_name')); ?></th>
                            <th><?php echo e(trans('message.funding_type')); ?></th>
                            <th><?php echo e(trans('message.capital_level')); ?></th>
                            <!-- <th>Create by</th> -->
                            <th><?php echo e(trans('message.action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td><?php echo e($i+1); ?></td>
                            <td><?php echo e(Str::limit($fund->fund_name,80)); ?></td>
                            <td><?php echo e($fund->fund_type); ?></td>
                            <td><?php echo e($fund->fund_level); ?></td>
                            <!-- <td><?php echo e($fund->user->fname_en); ?> <?php echo e($fund->user->lname_en); ?></td> -->

                            <td>
                                <?php echo csrf_field(); ?>
                                <form action="<?php echo e(route('funds.destroy',$fund->id)); ?>" method="POST">
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="view" href="<?php echo e(route('funds.show',$fund->id)); ?>"><i class="mdi mdi-eye"></i></a>
                                    </li>
                                    <?php if(Auth::user()->can('update',$fund)): ?>
                                    <li class="list-inline-item">
                                        <a class="btn btn-outline-success btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit" href="<?php echo e(route('funds.edit',Crypt::encrypt($fund->id))); ?>"><i class="mdi mdi-pencil"></i></a>
                                    </li>
                                    <?php endif; ?>

                                    <?php if(Auth::user()->can('delete',$fund)): ?>
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

                                    <li class="list-inline-item">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button class="btn btn-outline-danger btn-sm show_confirm" type="submit" data-toggle="tooltip" title="Delete"><i class="mdi mdi-delete"></i></button>
                                    </li>


                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js" defer></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js" defer></script>
<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            fixedHeader: true
        });
    });
</script>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `Are you sure?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Delete Successfully", {
                        icon: "success",
                    }).then(function() {
                        location.reload();
                        form.submit();
                    });
                }
            });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboards.users.layouts.user-dash-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\File\CS Term 6\SoftEnProject\git-group-repository-group-2-sec-1\InitialProject\SourceCode\resources\views/funds/index.blade.php ENDPATH**/ ?>