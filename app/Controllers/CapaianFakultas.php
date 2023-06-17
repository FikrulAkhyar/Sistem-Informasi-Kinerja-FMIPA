<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;
use Hermawan\DataTables\DataTable;

class CapaianFakultas extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        if (!in_array('/capaianFakultas', session('menu_akses'))) {
            return redirect()->to('/');
        }

        $data['tahun'] = $this->db->table('indikator_kinerja')
            ->select('tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get()->getResultArray();

        $data['triwulan'] = $this->db->table('triwulan')->get()->getResultArray();

        for ($i = 0; $i < count($data['triwulan']); $i++) {
            $data['triwulan'][$i]['bulan'] = explode(',', $data['triwulan'][$i]['keterangan']);
        }

        return view('capaian_fakultas/index', $data);
    }

    public function datatable()
    {
        $tahun = $this->request->getGet('tahun');
        $triwulan = $this->request->getGet('triwulan');

        $builder = $this->db->table('indikator_kinerja ik')
            ->join('capaian_fakultas c', 'c.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('target_fakultas t', 't.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('satuan s', 's.satuan_id = ik.satuan_id');

        if ($triwulan == 1) {
            $builder = $builder->select('
                c.capaian_fakultas_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.level_akses,
                s.nama_satuan,
                t.triwulan_satu as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        } else if ($triwulan == 2) {
            $builder = $builder->select('
                c.capaian_fakultas_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.level_akses,
                s.nama_satuan,
                t.triwulan_dua as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        } else if ($triwulan == 3) {
            $builder = $builder->select('
                c.capaian_fakultas_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.level_akses,
                s.nama_satuan,
                t.triwulan_tiga as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        } else if ($triwulan == 4) {
            $builder = $builder->select('
                c.capaian_fakultas_id,
                ik.indikator_kinerja_id,
                ik.kode_indikator_kinerja,
                ik.level_akses,
                s.nama_satuan,
                t.triwulan_empat as target,
                SUM(c.hasil) as capaian,
                c.file
            ');
        }

        $builder = $builder->groupBy('ik.kode_indikator_kinerja')
            ->where([
                'ik.tahun' => $tahun,
                'c.triwulan_id' => $triwulan
            ]);

        return DataTable::of($builder)->toJson(TRUE);
    }

    public function modal_detail($id)
    {
        $capaian = $this->db->table('capaian_fakultas')->where('capaian_fakultas_id', $id)->get()->getRowArray();

        $data['capaian'] = $this->db->table('capaian_fakultas c')
            ->join('indikator_kinerja ik', 'ik.indikator_kinerja_id = c.indikator_kinerja_id')
            ->join('triwulan t', 't.triwulan_id = c.triwulan_id')
            ->select('
                ik.kode_indikator_kinerja,
                ik.tahun,
                c.indikator_kinerja_id,
                c.uraian,
                c.capaian,
                c.pembagi,
                c.hasil,
                t.nama_triwulan
            ')
            ->where([
                'c.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                'c.triwulan_id' => $capaian['triwulan_id']
            ])
            ->get()->getResultArray();

        $data['kode'] = $data['capaian'][0]['kode_indikator_kinerja'];
        $data['tahun'] = $data['capaian'][0]['tahun'];
        $data['nama_triwulan'] = $data['capaian'][0]['nama_triwulan'];
        $data['jumlah'] = 0;
        for ($i = 0; $i < count($data['capaian']); $i++) {
            $data['jumlah'] += $data['capaian'][$i]['hasil'];
        }

        $view = \Config\Services::renderer();
        $response['html'] = $view->setData($data)->render('capaian_fakultas/components/modal_detail');
        return $this->respond($response, 200);
    }

    public function isi_capaian($id)
    {
        $capaian = $this->db->table('capaian_fakultas')->where('capaian_fakultas_id', $id)->get()->getRowArray();
        $data['id'] = $id;
        $data['ik'] = $this->db->table('indikator_kinerja ik')
            ->join('target_fakultas t', 't.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('capaian_fakultas c', 'c.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->join('triwulan tr', 'tr.triwulan_id = c.triwulan_id')
            ->join('sasaran s', 's.sasaran_id = ik.sasaran_id');

        if ($capaian['triwulan_id'] == 1) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.satuan_id,
                ik.kode_indikator_kinerja,
                ik.tahun,
                ik.keterangan,
                ik.file_pendukung,
                s.keterangan as sasaran,
                tr.nama_triwulan,
                t.triwulan_satu as target
            ');
        } else if ($capaian['triwulan_id'] == 2) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.satuan_id,
                ik.kode_indikator_kinerja,
                ik.tahun,
                ik.keterangan,
                ik.file_pendukung,
                s.keterangan as sasaran,
                tr.nama_triwulan,
                t.triwulan_dua as target
            ');
        }
        if ($capaian['triwulan_id'] == 3) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.satuan_id,
                ik.kode_indikator_kinerja,
                ik.tahun,
                ik.keterangan,
                ik.file_pendukung,
                s.keterangan as sasaran,
                tr.nama_triwulan,
                t.triwulan_tiga as target
            ');
        }
        if ($capaian['triwulan_id'] == 4) {
            $data['ik'] = $data['ik']->select('
                ik.indikator_kinerja_id,
                ik.satuan_id,
                ik.kode_indikator_kinerja,
                ik.tahun,
                ik.keterangan,
                ik.file_pendukung,
                s.keterangan as sasaran,
                tr.nama_triwulan,
                t.triwulan_empat as target
            ');
        }

        $data['ik'] = $data['ik']->where([
            'ik.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
            'c.triwulan_id' => $capaian['triwulan_id']
        ])
            ->get()->getRowArray();


        $data['capaian'] = $this->db->table('indikator_kinerja ik')
            ->join('capaian_fakultas c', 'c.indikator_kinerja_id = ik.indikator_kinerja_id')
            ->select('
                c.uraian,
                c.sumber_data,
                c.capaian,
                c.pembagi,
                c.hasil
            ')
            ->where([
                'c.indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                'c.triwulan_id' => $capaian['triwulan_id']
            ])
            ->get()->getResultArray();

        return view('capaian_fakultas/isi_capaian', $data);
    }

    public function store_capaian($id)
    {
        $capaian = $this->db->table('capaian_fakultas c')
            ->join('indikator_kinerja ik', 'ik.indikator_kinerja_id = c.indikator_kinerja_id')
            ->select('
                c.indikator_kinerja_id,
                c.triwulan_id,
                ik.kode_indikator_kinerja,
                ik.tahun,
                ik.satuan_id
            ')
            ->where('c.capaian_fakultas_id', $id)
            ->get()->getRowArray();

        $uraian = array_map(function ($value) {
            return $value['uraian'];
        }, $this->db->table('capaian_fakultas')
            ->select('uraian')
            ->where('indikator_kinerja_id', $capaian['indikator_kinerja_id'])
            ->groupBy('uraian')
            ->get()->getResultArray());

        if ($this->request->getFile('file')->getName() != "") {
            $uploadDir = $_SERVER["DOCUMENT_ROOT"] . '/dokumen/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $nama_dokumen = $capaian['kode_indikator_kinerja'] . '_' . $capaian['tahun'] . '_tw' . $capaian['triwulan_id'] . '.' . $this->request->getFile('file')->getExtension();
            file_put_contents($uploadDir . $nama_dokumen, file_get_contents($this->request->getFile('file')), FILE_USE_INCLUDE_PATH);
        }

        for ($i = 0; $i < count($uraian); $i++) {
            if ($capaian['satuan_id'] == 1) {
                $data = [
                    'uraian' => $uraian[$i],
                    'capaian' => $this->request->getPost('capaian')[$uraian[$i]],
                    'pembagi' => $this->request->getPost('pembagi')[$uraian[$i]],
                    'hasil' => $this->request->getPost('hasil')[$uraian[$i]],
                    'updated_by' => session('nama')
                ];
            } else {
                $data = [
                    'uraian' => $uraian[$i],
                    'capaian' => $this->request->getPost('capaian')[$uraian[$i]],
                    'hasil' => $this->request->getPost('capaian')[$uraian[$i]],
                    'updated_by' => session('nama')
                ];
            }

            if ($this->request->getFile('file')->getName() != "") {
                $data['file'] = $nama_dokumen;
            }

            $this->db->table('capaian_fakultas')->where([
                'indikator_kinerja_id' => $capaian['indikator_kinerja_id'],
                'triwulan_id' => $capaian['triwulan_id'],
                'uraian' => $uraian[$i]
            ])->update($data);
        }

        $response = [
            'message' => 'Berhasil mengisi capaian indikator kinerja'
        ];

        return $this->respond($response);
    }
}
