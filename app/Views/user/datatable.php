<!-- Content -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="<?= route_to('user_create') ?>" class="btn btn-primary btn-sm float-right">Tambah User</a>
                </div>
                <div class="card-body">

                    <table id="user-table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>Email</td>
                                <td>Level</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

<?= $this->section('scripts') ?>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script> -->

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#user-table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('user/datatables') ?>",
                    "type": "POST"
                },
                "columnDefs": [{
                    "targets": [],
                    "orderable": false,
                }, ],
            });
        });
    </script>
<?= $this->endSection() ?>
