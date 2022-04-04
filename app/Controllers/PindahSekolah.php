<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaKelasModel;
use App\Models\DataTables\PindahSekolahDataTable;
use App\Models\OrtuModel;
use App\Models\PindahSekolahModel;
use App\Models\SiswaModel;
use App\Models\TahunAjarModel;
use Config\Services;

class PindahSekolah extends BaseController
{
    protected $tahun_ajar;
    protected $siswa;
    protected $pindah_sekolah;
    protected $anggota_kelas;
    protected $ortu;
    protected $db;

    public function __construct()
    {
        $this->tahun_ajar = new TahunAjarModel;
        $this->siswa = new SiswaModel;
        $this->ortu = new OrtuModel;
        $this->pindah_sekolah = new PindahSekolahModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->db = db_connect();
    }

    public function index($tipe)
    {

        // if ($this->request->getPost('id_tahun') != null) {
        //     dd($this->request->getPost('id_tahun'));
        // }

        // dd('asdsad');

        $data = [];
        $tahun_ajar = [];
        $tahun_ajar_aktif = $this->tahun_ajar->find($this->tahun_ajar->getActiveId());
        $tahun_ajar_raw = $this->tahun_ajar->where('id <', $tahun_ajar_aktif['id'])->orderBy('tahun_mulai', 'ASC')->findAll();
        foreach ($tahun_ajar_raw as $raw) {
            $tahun_ajar[$raw['id']] = $raw['tahun_mulai'] . '/' . $raw['tahun_selesai'];
        }

        if ($this->request->getGet('id_tahun') != null) {
            $id_tahun = $this->request->getGet('id_tahun');
            $selected_tahun = $this->tahun_ajar->find($id_tahun);
        }

        $data = [
            'tipe' => $tipe,
            'tahun_ajar' => $tahun_ajar,
            'tahun_ajar_selected' => (isset($id_tahun) and $id_tahun != null) ? $id_tahun : null
        ];

        // dd($data);
        return view('pindah_sekolah/index', $data);
    }

    public function datatables($tipe)
    {
        // ($this->request->getPost('id_tahun') != null) ? $id_tahun = $this->request->getPost('id_tahun') : $id_tahun = null;
        $request = Services::request();
        $datatable = new PindahSekolahDataTable($request, $tipe);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $tahun_ajar = $this->tahun_ajar->getData($list->id_tahun_ajar);
                $siswa = $this->siswa->getData($list->id_siswa);
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $siswa['nis'] ?? '-';
                $row[] = $siswa['nama'] ?? '-';
                if ($tipe == 'masuk') {
                    $row[] = $list->asal;
                }
                if ($tipe == 'keluar') {
                    $row[] = $list->tujuan;
                }
                $row[] = isset($tahun_ajar) ? $tahun_ajar['tahun_mulai'] . '/' . $tahun_ajar['tahun_selesai'] : '-';
                $row[] = $list->alasan;
                if (session()->get('level') == 'admin') {
                    $row[] = "
                    <a href='" . route_to('pindah_sekolah_show', $tipe, $list->id) . "' class='btn btn-sm btn-info'>Lihat</a>
                    <a href='" . route_to('pindah_sekolah_edit', $list->id) . "' class='btn btn-sm btn-warning'>Edit</a>";
                    // <button class='btn btn-sm btn-danger' onclick='deleteModel(`" . route_to('kelas_destroy', $list->id) . "`, `kelasDataTable`, `Apakah anda yang menghapus data jenjang kelas ?`)'>Hapus</button>";
                } else {
                    $row[] = "
                    <a href='" . route_to('pindah_sekolah_show', $tipe, $list->id) . "' class='btn btn-sm btn-info'>Lihat</a>";
                }
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data,
            ];

            return json_encode($output);
        }
    }

    public function create($tipe)
    {
        $tahun_ajar = $this->tahun_ajar->getData();
        $siswa = $this->siswa->where('status', 'aktif')->getData();

        $data = [
            'tahun_ajar' => $tahun_ajar,
            'siswa' => $siswa,
            'tipe' => $tipe,
        ];

        return view('pindah_sekolah/create', $data);
    }

    public function show($tipe, $id)
    {
        $pindah_sekolah = $this->pindah_sekolah->getData($id);
        $tahun_ajar = $this->tahun_ajar->getData($pindah_sekolah['id_tahun_ajar']);
        $user = $this->siswa->getData($pindah_sekolah['id_siswa']);
        $user['foto'] = $this->siswa->getFoto($user['id']);
        $pindah_sekolah['tahun_ajar'] = count($tahun_ajar) > 0 ? $tahun_ajar['tahun_mulai'] . '/' . $tahun_ajar['tahun_selesai'] : '-';

        $data = [
            'pindah_sekolah' => $pindah_sekolah,
            'tipe' => $tipe,
            'user' => $user,
            'ortu' => $this->ortu->getData($user['id_ortu'])
        ];

        // dd($data);

        return view('pindah_sekolah/show', $data);
    }

    public function insert($tipe)
    {
        $this->db->transBegin();
        try {
            $data = $this->request->getPost();
            $data['tipe'] = $tipe;
            $data_ortu = [
                'nama' => $this->request->getPost('nama_ortu'),
                'no_telp' => $this->request->getPost('nomer_ortu'),
                'nik' => $this->request->getPost('nik_ortu'),
                'alamat' => $this->request->getPost('alamat_ortu'),
                'email' => $this->request->getPost('email_ortu'),
                'password' => password_hash($this->request->getPost('password_ortu'), PASSWORD_BCRYPT)
            ];
            if ($tipe == 'masuk') {
                $insert_ortu = $this->ortu->insertdata($data_ortu);
                $insert_id = $this->ortu->getInsertID();
                $data['id_ortu'] = $insert_id;
            }
            if ($tipe == 'masuk') {
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                $siswa = $this->siswa->insertData($data);
                $data['id_siswa'] = $siswa;
                $data['tujuan'] = getNamaSekolah();
            } else {
                $siswa = $this->siswa->getData($data['id_siswa']);

                $this->siswa->updateData($siswa['id'], [
                    'status' => 'nonaktif',
                ]);

                $anggota_kelas = $this->anggota_kelas->where('id_siswa', $data['id_siswa'])->getData();
                foreach ($anggota_kelas as $ak) {
                    $this->anggota_kelas->updateData($ak['id'], [
                        'status' => 'nonaktif',
                    ]);
                }

                $data['asal'] = getNamaSekolah();
            }

            $this->pindah_sekolah->insertData($data);
            $this->db->transCommit();
            session()->setFlashdata('success', 'Berhasil menambahkan data pindah sekolah');
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan data pindah sekolah');
        }

        return redirect()->to(route_to('pindah_sekolah_index', $tipe));
    }

    public function edit($id_pindah)
    {
        $pindah_sekolah = $this->pindah_sekolah->getData($id_pindah);
        $siswa = $this->siswa->getData($pindah_sekolah['id_siswa']);
        $tahun_ajar = $this->tahun_ajar->getData();
        $data = [
            'tipe' => $pindah_sekolah['tipe'],
            'siswa' => $siswa,
            'tahun_ajar' => $tahun_ajar,
            'pindah_sekolah' => $pindah_sekolah,
        ];

        return view('pindah_sekolah/edit', $data);
    }

    public function update($tipe, $id_pindah)
    {
        $pindah_sekolah = $this->pindah_sekolah->getData($id_pindah);
        if (count($pindah_sekolah) == 0) {
            session()->setFlashdata('error', 'Data pindah sekolah tidak ditemukan');
            return redirect()->back()->withInput();
        }

        $this->db->transBegin();
        try {
            $data = $this->request->getPost();

            if ($tipe == 'keluar') {
                $data['asal'] = getNamaSekolah();
            }

            if ($tipe == 'masuk') {
                if ($data['nama'] == '' || $data['nis'] == '') {
                    session()->setFlashdata('error', 'Data nama dan NIS tidak boleh kosong');
                    return redirect()->back()->withInput();
                }

                $this->siswa->updateData($pindah_sekolah['id_siswa'], [
                    'nama' => $data['nama'],
                    'nis' => $data['nis'],
                ]);
            }

            $this->pindah_sekolah->updateData($id_pindah, $data);
            $this->db->transCommit();
            session()->setFlashdata('success', 'Berhasil mengubah data pindah sekolah');
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal mengubah data pindah sekolah');
            return redirect()->back()->withInput();
        }

        return redirect()->to(route_to('pindah_sekolah_index', $tipe));
    }
}
