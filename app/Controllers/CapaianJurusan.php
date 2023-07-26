<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;
use Hermawan\DataTables\DataTable;

class CapaianJurusan extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        if (!in_array('/capaianJurusan', session('menu_akses'))) {
            return redirect()->to('/');
        }

        $data['tahun'] = $this->db->table('indikator_kinerja')
            ->select('tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get()->getResultArray();

        if (session('level') == 3) {
            $data['jurusan'] = $this->db->table('jurusan')->where('jurusan_id', session('jurusan'))->get()->getResultArray();
        } else {
            $data['jurusan'] = $this->db->table('jurusan')->get()->getResultArray();
        }

        $data['triwulan'] = $this->db->table('triwulan')->get()->getResultArray();

        for ($i = 0; $i < count($data['triwulan']); $i++) {
            $data['triwulan'][$i]['bulan'] = explode(',', $data['triwulan'][$i]['keterangan']);
        }

        return view('capaian_jurusan/index', $data);
    }

    public function datatable()
    {
        $tahun = $this->request->getGet('tahun');
        $jurusan = $this->request->getGet('jurusan');
        $triwulan = $this->request->getGet('triwulan');

        $subQuery = $this->db->table('capaian_jurusan c')
            ->join('indikator_kinerja ik', 'ik.indikator_kinerja_id = c.indikator_kinerja_id')
            ->select('
                c.indikator_kinerja_id, 
                c.capaian_jurusan_id,
                SUM(c.hasil) as total_capaian,
                c.file
            ')
            ->where([
                'ik.tahun' => $tahun,
                'c.triwulan_id' => $triwulan,
                'c.jurusan_id' => $jurusan,
            ])
            ->groupBy('c.indikator_kinerja_id')
            ->getCompiledSelect();

        $builder = $this->db->table('indikator_kinerja ik')
            ->join('indikator_kinerja_jurusan ikj', 'ikj.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('target_jurusan t', 't.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('satuan s', 's.satuan_id = ikj.satuan_id')
            ->join("($subQuery) sub", 'sub.indikator_kinerja_id = ik.indikator_kinerja_id', 'left');

        if ($triwulan == 1) {
            $builder = $builder->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.level_akses,
                s.nama_satuan,
                t.triwulan_satu as target,
                COALESCE(sub.total_capaian, 0) as capaian,
                sub.capaian_jurusan_id,
                sub.file
            ');
        } else if ($triwulan == 2) {
            $builder = $builder->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.level_akses,
                s.nama_satuan,
                t.triwulan_dua as target,
                COALESCE(sub.total_capaian, 0) as capaian,
                sub.capaian_jurusan_id,
                sub.file
            ');
        } else if ($triwulan == 3) {
            $builder = $builder->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.level_akses,
                s.nama_satuan,
                t.triwulan_tiga as target,
                COALESCE(sub.total_capaian, 0) as capaian,
                sub.capaian_jurusan_id,
                sub.file
            ');
        } else if ($triwulan == 4) {
            $builder = $builder->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.level_akses,
                s.nama_satuan,
                t.triwulan_empat as target,
                COALESCE(sub.total_capaian, 0) as capaian,
                sub.capaian_jurusan_id,
                sub.file
            ');
        }

        $builder = $builder
            ->where([
                'ik.tahun' => $tahun,
                'ikj.jurusan_id' => $jurusan,
                't.jurusan_id' => $jurusan,
            ])
            ->groupBy('ik.indikator_kinerja_id');

        return DataTable::of($builder)->toJson(TRUE);
    }

    public function modal_detail($id)
    {
        $capaian = $this->db->table('capaian_jurusan')->where('capaian_jurusan_id', $id)->get()->getRowArray();

        $data['capaian'] = $this->db->table('capaian_jurusan cj')
            ->join('cascading c', 'c.cascading_id = cj.cascading_id')
            ->select('
                cj.cascading_id,
                c.nama_cascading,
            ')
            ->where([
                'cj.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                'cj.triwulan_id' => $capaian['triwulan_id'],
                'cj.jurusan_id' => $capaian['jurusan_id'],
            ])
            ->groupBy('cj.cascading_id')
            ->get()->getResultArray();

        for ($i = 0; $i < count($data['capaian']); $i++) {
            $data['capaian'][$i]['capaian'] = $this->db->table('capaian_jurusan cj')
                ->join('indikator_kinerja ik', 'ik.indikator_kinerja_id = cj.indikator_kinerja_id')
                ->join('cascading c', 'c.cascading_id = cj.cascading_id')
                ->join('triwulan t', 't.triwulan_id = cj.triwulan_id')
                ->join('jurusan j', 'j.jurusan_id = cj.jurusan_id')
                ->select('
                    ik.kode_indikator_kinerja,
                    ik.tahun,
                    cj.indikator_kinerja_id,
                    cj.uraian,
                    cj.capaian,
                    cj.pembagi,
                    cj.hasil,
                    t.nama_triwulan,
                    j.nama_jurusan
                ')
                ->where([
                    'cj.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                    'cj.triwulan_id' => $capaian['triwulan_id'],
                    'cj.jurusan_id' => $capaian['jurusan_id'],
                    'cj.cascading_id' => $data['capaian'][$i]['cascading_id'],
                ])
                ->get()->getResultArray();
        }

        $data['kode'] = $data['capaian'][0]['capaian'][0]['kode_indikator_kinerja'];
        $data['tahun'] = $data['capaian'][0]['capaian'][0]['tahun'];
        $data['nama_triwulan'] = $data['capaian'][0]['capaian'][0]['nama_triwulan'];
        $data['nama_jurusan'] = $data['capaian'][0]['capaian'][0]['nama_jurusan'];
        $data['jumlah'] = 0;
        for ($i = 0; $i < count($data['capaian']); $i++) {
            for ($j = 0; $j < count($data['capaian'][$i]['capaian']); $j++) {
                $data['jumlah'] += $data['capaian'][$i]['capaian'][$j]['hasil'];
            }
        }

        $view = \Config\Services::renderer();
        $response['html'] = $view->setData($data)->render('capaian_jurusan/components/modal_detail');
        return $this->respond($response, 200);
    }

    public function isi_capaian($id)
    {
        $capaian = $this->db->table('capaian_jurusan')->where('capaian_jurusan_id', $id)->get()->getRowArray();
        $data['id'] = $id;

        $data['ik'] = $this->db->table('indikator_kinerja ik')
            ->join('indikator_kinerja_jurusan ikj', 'ikj.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('jurusan j', 'j.jurusan_id = ikj.jurusan_id')
            ->join('target_jurusan t', 't.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('capaian_jurusan c', 'c.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('triwulan tr', 'tr.triwulan_id = c.triwulan_id')
            ->join('sasaran s', 's.sasaran_id = ik.sasaran_id');

        if ($capaian['triwulan_id'] == 1) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.tahun,
                ik.file_pendukung,
                ikj.keterangan,
                s.keterangan as sasaran,
                j.nama_jurusan,
                tr.nama_triwulan,
                t.triwulan_satu as target
            ');
        } else if ($capaian['triwulan_id'] == 2) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.tahun,
                ik.file_pendukung,
                ikj.keterangan,
                s.keterangan as sasaran,
                j.nama_jurusan,
                tr.nama_triwulan,
                t.triwulan_dua as target
            ');
        }
        if ($capaian['triwulan_id'] == 3) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.tahun,
                ik.file_pendukung,
                ikj.keterangan,
                s.keterangan as sasaran,
                j.nama_jurusan,
                tr.nama_triwulan,
                t.triwulan_tiga as target
            ');
        }
        if ($capaian['triwulan_id'] == 4) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.tahun,
                ik.file_pendukung,
                ikj.keterangan,
                s.keterangan as sasaran,
                j.nama_jurusan,
                tr.nama_triwulan,
                t.triwulan_empat as target
            ');
        }

        $data['ik'] = $data['ik']->where([
            'ik.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
            'c.triwulan_id' => $capaian['triwulan_id'],
            'c.jurusan_id' => $capaian['jurusan_id'],
            'ikj.jurusan_id' => $capaian['jurusan_id'],
            't.jurusan_id' => $capaian['jurusan_id'],
        ])
            ->get()->getRowArray();


        $data['capaian'] = $this->db->table('capaian_jurusan cj')
            ->join('cascading c', 'c.cascading_id = cj.cascading_id')
            ->select('
                cj.cascading_id,
                c.nama_cascading,
            ')
            ->where([
                'cj.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                'cj.triwulan_id' => $capaian['triwulan_id'],
                'cj.jurusan_id' => $capaian['jurusan_id'],
            ])
            ->groupBy('cj.cascading_id')
            ->get()->getResultArray();

        for ($i = 0; $i < count($data['capaian']); $i++) {
            $data['capaian'][$i]['capaian'] = $this->db->table('capaian_jurusan cj')
                ->join('indikator_kinerja ik', 'ik.indikator_kinerja_id = cj.indikator_kinerja_id')
                ->join('cascading c', 'c.cascading_id = cj.cascading_id')
                ->join('triwulan t', 't.triwulan_id = cj.triwulan_id')
                ->join('jurusan j', 'j.jurusan_id = cj.jurusan_id')
                ->select('
                    cj.uraian,
                    cj.sumber_data,
                    cj.capaian,
                    cj.pembagi,
                    cj.hasil,
                ')
                ->where([
                    'cj.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                    'cj.triwulan_id' => $capaian['triwulan_id'],
                    'cj.jurusan_id' => $capaian['jurusan_id'],
                    'cj.cascading_id' => $data['capaian'][$i]['cascading_id'],
                ])
                ->get()->getResultArray();
        }

        return view('capaian_jurusan/isi_capaian', $data);
    }

    public function store_capaian($id)
    {
        $capaian = $this->db->table('capaian_jurusan c')
            ->join('indikator_kinerja ik', 'ik.indikator_kinerja_id = c.indikator_kinerja_id')
            ->select('
                c.indikator_kinerja_id,
                c.triwulan_id,
                c.jurusan_id,
                ik.kode_indikator_kinerja,
                ik.tahun,
            ')
            ->where('c.capaian_jurusan_id', $id)
            ->get()->getRowArray();

        $cascading = array_map(function ($value) {
            return $value['cascading_id'];
        }, $this->db->table('capaian_jurusan')
            ->select('cascading_id,')
            ->where([
                'indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                'triwulan_id' => $capaian['triwulan_id'],
                'jurusan_id' => $capaian['jurusan_id'],
            ])
            ->groupBy('cascading_id')
            ->get()->getResultArray());

        $uraian = array_map(function ($value) {
            return $value['uraian'];
        }, $this->db->table('capaian_jurusan')
            ->select('uraian')
            ->where('indikator_kinerja_id', $capaian['indikator_kinerja_id'])
            ->groupBy('uraian')
            ->get()->getResultArray());

        if ($this->request->getFile('file')->getName() != "") {
            $uploadDir = $_SERVER["DOCUMENT_ROOT"] . '/dokumen/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $nama_dokumen = $capaian['kode_indikator_kinerja'] . '_' . $capaian['tahun'] . '_tw' . $capaian['triwulan_id'] . '_' . $capaian['jurusan_id'] . '.' . $this->request->getFile('file')->getExtension();
            file_put_contents($uploadDir . $nama_dokumen, file_get_contents($this->request->getFile('file')), FILE_USE_INCLUDE_PATH);
        }

        for ($i = 0; $i < count($cascading); $i++) {
            for ($j = 0; $j < count($uraian); $j++) {
                $data = [
                    'capaian' => $this->request->getPost('capaian')[$cascading[$i]][$uraian[$j]],
                    'pembagi' => $this->request->getPost('pembagi')[$cascading[$i]][$uraian[$j]],
                    'hasil' => $this->request->getPost('hasil')[$cascading[$i]][$uraian[$j]],
                    'updated_by' => session('nama')
                ];

                if ($this->request->getFile('file')->getName() != "") {
                    $data['file'] = $nama_dokumen;
                }

                $this->db->table('capaian_jurusan')->where([
                    'indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                    'triwulan_id' => $capaian['triwulan_id'],
                    'cascading_id' => $cascading[$i],
                    'uraian' => $uraian[$j],
                    'jurusan_id' => $capaian['jurusan_id']
                ])->update($data);
            }
        }

        for ($i = 0; $i < count($uraian); $i++) {
            $capaian_fakultas = $this->db->table('capaian_jurusan')
                ->select('
                    uraian,
                    SUM(capaian) as capaian,
                    pembagi,
                    SUM(hasil) as hasil,
                ')
                ->where([
                    'indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                    'triwulan_id' => $capaian['triwulan_id'],
                    'uraian' => $uraian[$i]
                ])
                ->get()->getRowArray();

            $this->db->table('capaian_fakultas')->where([
                'indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                'triwulan_id' => $capaian['triwulan_id'],
                'uraian' => $uraian[$i],
            ])->update($capaian_fakultas);
        }

        $response = [
            'message' => 'Berhasil mengisi capaian indikator kinerja'
        ];

        return $this->respond($response);
    }
}
