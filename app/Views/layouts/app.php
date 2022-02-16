<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SI Kependidikan</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/jqvmap/jqvmap.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/daterangepicker/daterangepicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/sweetalert2/sweetalert2.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/toastr/toastr.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/select2/css/select2.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.css') ?>">
    <meta name="csrf-token" content="<?= csrf_hash() ?>" />

    <style>
        td {
            vertical-align: middle !important;
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url('adminlte/dist/img/AdminLTELogo.png') ?>" alt="AdminLTELogo" height="60" width="60">
        </div>

        <?= $this->include('layouts/navbar') ?>
        <?= $this->include('layouts/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
            <?php $uri = explode('/', uri_string()); ?>
            <?php if ($uri[0] != 'dashboard') : ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex flex-column align-items-center">
                            <a href="javascript:window.history.go(-1)" class="btn btn-info col-1 fixed-bottom mb-3" style="margin:auto; border-radius:10px">
                                <i class="fas fa-angle-double-left"></i>
                                <span>Kembali</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>


        <!-- /.content-wrapper -->
        <!-- <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer> -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->


    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url('adminlte/plugins/jquery/jquery.js') ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url('adminlte/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- ChartJS -->
    <script src="<?= base_url('adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
    <!-- Sparkline -->
    <script src="<?= base_url('adminlte/plugins/sparklines/sparkline.js') ?>"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= base_url('adminlte/plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url('adminlte/plugins/moment/moment.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/daterangepicker/daterangepicker.js') ?>"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
    <!-- Summernote -->
    <script src="<?= base_url('adminlte/plugins/summernote/summernote-bs4.min.js') ?>"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('adminlte/dist/js/adminlte.js') ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="<?= base_url('adminlte/dist/js/demo.js') ?>"></script> -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

    <script src="<?= base_url('adminlte/plugins/sweetalert2/sweetalert2.all.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/toastr/toastr.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/sweetalert2/sweetalert2.all.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/select2/js/select2.js') ?>"></script>


    <script>
        const baseUrl = "<?= base_url() ?>"

        function showToast(code, text) {
            if (code == 1) {
                toastr.success(text)
            }

            if (code == 0) {
                toastr.error(text)
            }
        }

        function showAlertSwal(code, text) {
            if (code == 1) {
                Swal.fire(
                    'Berhasil',
                    text,
                    'success'
                )
            }

            if (code == 0) {
                Swal.fire(
                    'Terjadi Kesalahan',
                    text,
                    'error'
                )
            }
        }

        const numberOnlyInput = document.getElementsByClassName('number-only')
        for (let index = 0; index < numberOnlyInput.length; index++) {
            const numberOnly = numberOnlyInput[index];
            numberOnly.addEventListener('input', function(element) {
                element.target.value = element.target.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')
            })
        }

        function deleteModel(deleteUrl, tableId, target = '') {
            Swal.fire({
                title: "Warning",
                text: `Yakin menghapus data ${target} Proses ini tidak dapat diulang`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#169b6b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        "url": deleteUrl,
                        "dataType": "JSON",
                        "headers": {
                            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                        },
                        "method": "get",
                        success: function(data) {
                            // console.log('delete ')
                            if (data.swal != undefined) {
                                showAlertSwal(data.code, data.swal)
                            } else {
                                showToast(data.code, data.message)
                            }
                            $('#' + tableId).DataTable().ajax.reload();
                        }
                    })
                }
            })
        }
    </script>

    <script>
        $(document).ready(function() {
            $('select:not(.custom-select)').select2({
                theme: 'bootstrap4',
            });
        });
    </script>

    <?= $this->renderSection('scripts') ?>

</body>

</html>