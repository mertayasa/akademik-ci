<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Daftar Rapat</title>

    <style>
        .title {
            text-align: center;
        }

        .sub-title {
            text-align: center;
        }

        .note {
            text-align: justify;
        }

        table {
            width: 100%;
            font-style: sans-serif;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center !important;
        }
    </style>

</head>

<body style="font-family: Arial, Helvetica, sans-serif;">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table id="kelasTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>Pelajaran</td>
                            <td>Guru</td>
                            <td>Jam</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hari as $hr) : ?>
                            <?php if (count($jadwal) > 0) : ?>
                                <tr>
                                    <td colspan="3" class="text-center"> <?= $hr->hari; ?> </td>
                                </tr>
                                <?php foreach ($jadwal as  $value) : ?>
                                    <?php if ($hr->hari == $value->hari) : ?>
                                        <tr>
                                            <td data-mapel="<?= $value->id_mapel; ?>" class="nama-mapel"><?= $value->nama_mapel ?></td>
                                            <td data-guru="<?= $value->id_guru; ?>" class="nama-guru"><?= $value->nama_guru ?></td>
                                            <td class="jam"><?= \Carbon\Carbon::parse($value->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($value->jam_selesai)->format('H:i') ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center"> Tidak Ada Data </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>