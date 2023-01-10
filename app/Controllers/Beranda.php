<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;

class Beranda extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        $data['tahun'] = $this->db->table('indikator_kinerja')
            ->select('tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get()->getResultArray();

        $data['triwulan'] = $this->db->table('triwulan')->get()->getResultArray();
        for ($i = 0; $i < count($data['triwulan']); $i++) {
            $data['triwulan'][$i]['bulan'] = explode(',', $data['triwulan'][$i]['keterangan']);
        }

        $tahun = $this->request->getGet('tahun');
        $triwulan = $this->request->getGet('triwulan');

        $data['triwulanAktif'] = $triwulan;
        $data['tahunAktif'] = $tahun;

        $data['pk'] = $this->db->table('indikator_kinerja ik')
            ->join('sasaran s', 's.sasaran_id = ik.sasaran_id')
            ->select('s.keterangan as sasaran, ik.sasaran_id')
            ->where('ik.tahun', $tahun)
            ->groupBy('ik.sasaran_id')
            ->get()->getResultArray();

        for ($i = 0; $i < count($data['pk']); $i++) {
            $data['pk'][$i]['jumlah_row'] = 0;
            if ($triwulan == 1) {
                $data['pk'][$i]['indikator'] = $this->db->table('indikator_kinerja ik')
                    ->join('target_fakultas tf', 'tf.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('satuan st', 'st.satuan_id = ik.satuan_id')
                    ->select('
                            ik.indikator_kinerja_id,
                            ik.kode_indikator_kinerja,
                            ik.keterangan as indikator_kinerja,
                            st.nama_satuan,
                            tf.triwulan_satu as target
                        ')
                    ->where([
                        'ik.tahun' => $tahun,
                        'ik.sasaran_id' => $data['pk'][$i]['sasaran_id'],
                    ])
                    ->get()->getResultArray();
            } else if ($triwulan == 2) {
                $data['pk'][$i]['indikator'] = $this->db->table('indikator_kinerja ik')
                    ->join('target_fakultas tf', 'tf.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('satuan st', 'st.satuan_id = ik.satuan_id')
                    ->select('
                            ik.indikator_kinerja_id,
                            ik.kode_indikator_kinerja,
                            ik.keterangan as indikator_kinerja,
                            st.nama_satuan,
                            tf.triwulan_dua as target
                        ')
                    ->where([
                        'ik.tahun' => $tahun,
                        'ik.sasaran_id' => $data['pk'][$i]['sasaran_id'],
                    ])
                    ->get()->getResultArray();
            } else if ($triwulan == 3) {
                $data['pk'][$i]['indikator'] = $this->db->table('indikator_kinerja ik')
                    ->join('target_fakultas tf', 'tf.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('satuan st', 'st.satuan_id = ik.satuan_id')
                    ->select('
                            ik.indikator_kinerja_id,
                            ik.kode_indikator_kinerja,
                            ik.keterangan as indikator_kinerja,
                            st.nama_satuan,
                            tf.triwulan_tiga as target
                        ')
                    ->where([
                        'ik.tahun' => $tahun,
                        'ik.sasaran_id' => $data['pk'][$i]['sasaran_id'],
                    ])
                    ->get()->getResultArray();
            } else if ($triwulan == 4) {
                $data['pk'][$i]['indikator'] = $this->db->table('indikator_kinerja ik')
                    ->join('target_fakultas tf', 'tf.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('satuan st', 'st.satuan_id = ik.satuan_id')
                    ->select('
                            ik.indikator_kinerja_id,
                            ik.kode_indikator_kinerja,
                            ik.keterangan as indikator_kinerja,
                            st.nama_satuan,
                            tf.triwulan_empat as target
                        ')
                    ->where([
                        'ik.tahun' => $tahun,
                        'ik.sasaran_id' => $data['pk'][$i]['sasaran_id'],
                    ])
                    ->get()->getResultArray();
            }

            for ($j = 0; $j < count($data['pk'][$i]['indikator']); $j++) {
                $data['pk'][$i]['indikator'][$j]['jumlah'] = 0;
                $data['pk'][$i]['indikator'][$j]['capaian'] = $this->db->table('indikator_kinerja ik')
                    ->join('capaian_fakultas c', 'c.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->select('
                        c.uraian,
                        c.capaian,
                        c.pembagi,
                        c.hasil,
                    ')
                    ->where([
                        'c.indikator_kinerja_id' => $data['pk'][$i]['indikator'][$j]['indikator_kinerja_id'],
                        'c.triwulan_id' => $triwulan
                    ])
                    ->get()->getResultArray();

                $data['pk'][$i]['jumlah_row'] += count($data['pk'][$i]['indikator'][$j]['capaian']) + 1;

                for ($k = 0; $k < count($data['pk'][$i]['indikator'][$j]['capaian']); $k++) {
                    $data['pk'][$i]['indikator'][$j]['jumlah'] += $data['pk'][$i]['indikator'][$j]['capaian'][$k]['hasil'];
                }
            }
        }

        // dd($data);

        return view('beranda/index', $data);
    }

    public function capaian()
    {
        $tahun = $this->request->getGet('tahun');
        $triwulan = $this->request->getGet('triwulan');

        $data['pk'] = $this->db->table('indikator_kinerja ik')
            ->join('sasaran s', 's.sasaran_id = ik.sasaran_id')
            ->select('s.keterangan as sasaran, ik.sasaran_id')
            ->where('ik.tahun', $tahun)
            ->groupBy('ik.sasaran_id')
            ->get()->getResultArray();

        for ($i = 0; $i < count($data['pk']); $i++) {
            $data['pk'][$i]['jumlah_row'] = 0;
            if ($triwulan == 1) {
                $data['pk'][$i]['indikator'] = $this->db->table('indikator_kinerja ik')
                    ->join('target_fakultas tf', 'tf.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('satuan st', 'st.satuan_id = ik.satuan_id')
                    ->select('
                            ik.indikator_kinerja_id,
                            ik.kode_indikator_kinerja,
                            ik.keterangan as indikator_kinerja,
                            st.nama_satuan,
                            tf.triwulan_satu as target
                        ')
                    ->where([
                        'ik.tahun' => $tahun,
                        'ik.sasaran_id' => $data['pk'][$i]['sasaran_id'],
                    ])
                    ->get()->getResultArray();
            } else if ($triwulan == 2) {
                $data['pk'][$i]['indikator'] = $this->db->table('indikator_kinerja ik')
                    ->join('target_fakultas tf', 'tf.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('satuan st', 'st.satuan_id = ik.satuan_id')
                    ->select('
                            ik.indikator_kinerja_id,
                            ik.kode_indikator_kinerja,
                            ik.keterangan as indikator_kinerja,
                            st.nama_satuan,
                            tf.triwulan_dua as target
                        ')
                    ->where([
                        'ik.tahun' => $tahun,
                        'ik.sasaran_id' => $data['pk'][$i]['sasaran_id'],
                    ])
                    ->get()->getResultArray();
            } else if ($triwulan == 3) {
                $data['pk'][$i]['indikator'] = $this->db->table('indikator_kinerja ik')
                    ->join('target_fakultas tf', 'tf.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('satuan st', 'st.satuan_id = ik.satuan_id')
                    ->select('
                            ik.indikator_kinerja_id,
                            ik.kode_indikator_kinerja,
                            ik.keterangan as indikator_kinerja,
                            st.nama_satuan,
                            tf.triwulan_tiga as target
                        ')
                    ->where([
                        'ik.tahun' => $tahun,
                        'ik.sasaran_id' => $data['pk'][$i]['sasaran_id'],
                    ])
                    ->get()->getResultArray();
            } else if ($triwulan == 4) {
                $data['pk'][$i]['indikator'] = $this->db->table('indikator_kinerja ik')
                    ->join('target_fakultas tf', 'tf.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('satuan st', 'st.satuan_id = ik.satuan_id')
                    ->select('
                            ik.indikator_kinerja_id,
                            ik.kode_indikator_kinerja,
                            ik.keterangan as indikator_kinerja,
                            st.nama_satuan,
                            tf.triwulan_empat as target
                        ')
                    ->where([
                        'ik.tahun' => $tahun,
                        'ik.sasaran_id' => $data['pk'][$i]['sasaran_id'],
                    ])
                    ->get()->getResultArray();
            }

            for ($j = 0; $j < count($data['pk'][$i]['indikator']); $j++) {
                $data['pk'][$i]['indikator'][$j]['jumlah'] = 0;
                $data['pk'][$i]['indikator'][$j]['capaian'] = $this->db->table('indikator_kinerja ik')
                    ->join('capaian_fakultas c', 'c.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->select('
                        c.uraian,
                        c.capaian,
                        c.pembagi,
                        c.hasil,
                    ')
                    ->where([
                        'c.indikator_kinerja_id' => $data['pk'][$i]['indikator'][$j]['indikator_kinerja_id'],
                        'c.triwulan_id' => $triwulan
                    ])
                    ->get()->getResultArray();

                $data['pk'][$i]['jumlah_row'] += count($data['pk'][$i]['indikator'][$j]['capaian']) + 1;

                for ($k = 0; $k < count($data['pk'][$i]['indikator'][$j]['capaian']); $k++) {
                    $data['pk'][$i]['indikator'][$j]['jumlah'] += $data['pk'][$i]['indikator'][$j]['capaian'][$k]['hasil'];
                }
            }
        }

        $response = [
            'data' => $data['pk']
        ];

        return $this->respond($response);
    }
}
