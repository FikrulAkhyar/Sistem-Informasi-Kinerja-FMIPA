<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use \Config\Database;
use Hermawan\DataTables\DataTable;
use \Mpdf\Mpdf;

class IndikatorKinerja extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        if (!in_array('/indikatorKinerja', session('menu_akses'))) {
            return redirect()->to('/');
        }

        $data['tahun'] = $this->db->table('indikator_kinerja')
            ->select('tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get()->getResultArray();

        return view('indikator_kinerja/index', $data);
    }

    public function datatable()
    {
        $tahun = $this->request->getGet('tahun');

        $builder = $this->db->table('indikator_kinerja i')
            ->join('target_fakultas t', 'i.indikator_kinerja_id = t.indikator_kinerja_id')
            ->select('
                i.indikator_kinerja_id,
                i.kode_indikator_kinerja,
                t.triwulan_satu,
                t.triwulan_dua,
                t.triwulan_tiga,
                t.triwulan_empat,
            ');

        if ($tahun) {
            $builder->where('tahun', $tahun);
        }

        return DataTable::of($builder)->toJson(TRUE);
    }

    public function create()
    {
        $data['sasaran'] = $this->db->table('sasaran')->get()->getResultArray();
        $data['satuan'] = $this->db->table('satuan')->get()->getResultArray();
        $data['cascading'] = $this->db->table('cascading')->where('is_jurusan', 0)->get()->getResultArray();
        $data['level'] = $this->db->table('level')->get()->getResultArray();

        return view('indikator_kinerja/create', $data);
    }

    public function store()
    {
        $rules = [
            'sasaran' => [
                'rules' => 'required',
            ],
            'kode' => [
                'rules' => 'required',
            ],
            'tahun' => [
                'rules' => 'required',
            ],
            'keterangan' => [
                'rules' => 'required',
            ],
            'satuan' => [
                'rules' => 'required',
            ],
            'uraian' => [
                'rules' => 'required',
            ],
            'cascading' => [
                'rules' => 'required',
            ],
            'file_pendukung' => [
                'rules' => 'uploaded[file_pendukung]|mime_in[file,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/pdf]|max_size[file_pendukung,2048]',
            ],
            'level_akses' => [
                'rules' => 'required',
            ],
        ];

        if (!($this->validate($rules))) {
            $response = [
                'message' => array_values($this->validation->getErrors())[0],
            ];

            return $this->respond($response, 422);
        }

        // Insert data indikator kinerja
        $data['indikator_kinerja'] = [
            'sasaran_id' => $this->request->getPost('sasaran'),
            'kode_indikator_kinerja' => $this->request->getPost('kode'),
            'tahun' =>  $this->request->getPost('tahun'),
            'keterangan' => $this->request->getPost('keterangan'),
            'satuan_id' => $this->request->getPost('satuan'),
            'cascading' => implode(',', $this->request->getPost('cascading')),
            'file_pendukung' => $this->request->getPost('file_pendukung'),
            'level_akses' => implode(',', $this->request->getPost('level_akses')),
        ];

        if ($this->request->getFile('file_pendukung')->getName() != "") {
            $uploadDir = $_SERVER["DOCUMENT_ROOT"] . '/dokumen/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $nama_dokumen = $data['indikator_kinerja']['kode_indikator_kinerja'] . '_format.' . $this->request->getFile('file_pendukung')->getExtension();
            file_put_contents($uploadDir . $nama_dokumen, file_get_contents($this->request->getFile('file_pendukung')), FILE_USE_INCLUDE_PATH);

            $data['indikator_kinerja']['file_pendukung'] = $nama_dokumen;
        }

        if ($this->db->table('indikator_kinerja')->insert($data['indikator_kinerja']) === FALSE) {
            $response = [
                'message' => 'Gagal menambahkan indikator kinerja'
            ];
            return $this->respond($response, 422);
        }

        // Get id indikator kinerja yang baru di insert
        $insertID = $this->db->insertID();

        // Insert data target
        $data['target_fakultas'] = [
            'indikator_kinerja_id' => $insertID,
            'triwulan_satu' => $this->request->getPost('target_tw1'),
            'triwulan_dua' => $this->request->getPost('target_tw2'),
            'triwulan_tiga' => $this->request->getPost('target_tw3'),
            'triwulan_empat' => $this->request->getPost('target_tw4')
        ];

        $this->db->table('target_fakultas')->insert($data['target_fakultas']);

        // Insert data capaian fakultas
        $uraian = $this->request->getPost('uraian');
        $sumber_data = $this->request->getPost('sumber_data');
        $triwulan = $this->db->table('triwulan')->get()->getResultArray();
        $k = 0;
        for ($i = 0; $i < count($uraian); $i++) {
            for ($j = 0; $j < count($triwulan); $j++) {
                $uraian_index = str_replace(' ', '_', $uraian[$i]);
                $data['capaian_fakultas'][$k] = [
                    'indikator_kinerja_id' => $insertID,
                    'uraian' => $uraian[$i],
                    'sumber_data' => $sumber_data[$uraian_index],
                    'capaian' => 0,
                    'triwulan_id' => $triwulan[$j]['triwulan_id'],
                ];

                $k++;
            }
        }
        $this->db->table('capaian_fakultas')->insertBatch($data['capaian_fakultas']);

        $response = [
            'message' => 'Berhasil menambahkan data indikator kinerja',
        ];

        return $this->respondCreated($response);
    }

    public function edit($id)
    {
        $data['id'] = $id;
        $data['ik'] = $this->db->table('indikator_kinerja')
            ->where('indikator_kinerja_id', $id)
            ->get()->getRowArray();

        $data['ik']['target'] = $this->db->table('target_fakultas')
            ->where('indikator_kinerja_id', $id)
            ->get()->getRowArray();

        $data['uraian'] = $this->db->table('capaian_fakultas')
            ->select('uraian, sumber_data')
            ->where('indikator_kinerja_id', $id)
            ->groupBy('uraian')
            ->get()->getResultArray();

        $data['ik']['cascading'] = explode(',', $data['ik']['cascading']);
        $data['ik']['level_akses'] = explode(',', $data['ik']['level_akses']);

        $data['sasaran'] = $this->db->table('sasaran')->get()->getResultArray();
        $data['satuan'] = $this->db->table('satuan')->get()->getResultArray();
        $data['cascading'] = $this->db->table('cascading')->where('is_jurusan', 0)->get()->getResultArray();
        $data['level'] = $this->db->table('level')->get()->getResultArray();

        return view('indikator_kinerja/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'sasaran' => [
                'rules' => 'required',
            ],
            'keterangan' => [
                'rules' => 'required',
            ],
            'satuan' => [
                'rules' => 'required',
            ],
            'uraian' => [
                'rules' => 'required',
            ],
            'cascading' => [
                'rules' => 'required',
            ],
            'level_akses' => [
                'rules' => 'required',
            ],
        ];

        if (!($this->validate($rules))) {
            $response = [
                'message' => array_values($this->validation->getErrors())[0],
            ];

            return $this->respond($response, 422);
        }

        $data = [
            'sasaran_id' => $this->request->getPost('sasaran'),
            'keterangan' => $this->request->getPost('keterangan'),
            'satuan_id' => $this->request->getPost('satuan'),
            'cascading' => implode(',', $this->request->getPost('cascading')),
            'level_akses' => implode(',', $this->request->getPost('level_akses')),
        ];

        if ($this->request->getFile('file_pendukung')->getName() != "") {
            $uploadDir = $_SERVER["DOCUMENT_ROOT"] . '/dokumen/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ik = $this->db->table('indikator_kinerja')->where('indikator_kinerja_id', $id)->get()->getRowArray();
            $nama_dokumen = $ik['kode_indikator_kinerja'] . '_format.' . $this->request->getFile('file_pendukung')->getExtension();
            file_put_contents($uploadDir . $nama_dokumen, file_get_contents($this->request->getFile('file_pendukung')), FILE_USE_INCLUDE_PATH);

            $data['file_pendukung'] = $nama_dokumen;
        }

        if ($this->db->table('indikator_kinerja')->where('indikator_kinerja_id', $id)->update($data) === FALSE) {
            $response = [
                'message' => 'Gagal mengubah indikator kinerja'
            ];
            return $this->respond($response, 422);
        }

        // Insert data target
        $data['target_fakultas'] = [
            'triwulan_satu' => $this->request->getPost('target_tw1'),
            'triwulan_dua' => $this->request->getPost('target_tw2'),
            'triwulan_tiga' => $this->request->getPost('target_tw3'),
            'triwulan_empat' => $this->request->getPost('target_tw4')
        ];

        $this->db->table('target_fakultas')->where('indikator_kinerja_id', $id)->update($data['target_fakultas']);

        // Insert data uraian
        $sumber_data = $this->request->getPost('sumber_data');
        $new_uraian = $this->request->getPost('uraian');
        $old_uraian = array_map(function ($value) {
            return $value['uraian'];
        }, $this->db->table('capaian_fakultas')
            ->select('uraian')
            ->where('indikator_kinerja_id', $id)
            ->groupBy('uraian')
            ->get()->getResultArray());

        $result_uraian = array_merge(array_diff($new_uraian, $old_uraian), array_diff($old_uraian, $new_uraian));

        if (count($result_uraian) > 0) {
            $triwulan = $this->db->table('triwulan')->get()->getResultArray();
            for ($i = 0; $i < count($result_uraian); $i++) {
                if (in_array($result_uraian[$i], $old_uraian)) {
                    $this->db->table('capaian_fakultas')
                        ->where([
                            'uraian' => $result_uraian[$i],
                            'indikator_kinerja_id' => $id,
                        ])->delete();
                } else {
                    for ($j = 0; $j < count($triwulan); $j++) {
                        $uraian_index = str_replace(' ', '_', $result_uraian[$i]);
                        $data['capaian_fakultas'][$j] = [
                            'indikator_kinerja_id' => $id,
                            'uraian' => $result_uraian[$i],
                            'sumber_data' => $sumber_data[$uraian_index],
                            'capaian' => 0,
                            'triwulan_id' => $triwulan[$j]['triwulan_id'],
                        ];
                    }

                    $this->db->table('capaian_fakultas')->insertBatch($data['capaian_fakultas']);
                }
            }
        } else {
            for ($i = 0; $i < count($new_uraian); $i++) {
                $uraian_index = str_replace(' ', '_', $new_uraian[$i]);
                $data['capaian_fakultas'][$i] = [
                    'indikator_kinerja_id' => $id,
                    'sumber_data' => $sumber_data[$uraian_index],
                    'uraian' => $new_uraian[$i]
                ];
            }
            $this->db->table('capaian_fakultas')->where('indikator_kinerja_id', $id)->updateBatch($data['capaian_fakultas'], 'uraian');
        }


        $response = [
            'message' => 'Berhasil mengubah data indikator kinerja'
        ];

        return $this->respond($response);
    }

    public function modal_delete($id)
    {
        $view = \Config\Services::renderer();
        $response['html'] = $view->setVar('id', $id)->render('indikator_kinerja/components/modal_delete');
        return $this->respond($response, 200);
    }

    public function delete($id)
    {
        $this->db->table('capaian_fakultas')->where('indikator_kinerja_id', $id)->delete();
        $this->db->table('target_fakultas')->where('indikator_kinerja_id', $id)->delete();

        $ik_jurusan = $this->db->table('indikator_kinerja_jurusan')->where('indikator_kinerja_id', $id)->get()->getResultArray();
        if ($ik_jurusan) {
            $this->db->table('capaian_jurusan')->where('indikator_kinerja_id', $id)->delete();
            $this->db->table('target_jurusan')->where('indikator_kinerja_id', $id)->delete();
            $this->db->table('indikator_kinerja_jurusan')->where('indikator_kinerja_id', $id)->delete();
        }

        $this->db->table('indikator_kinerja')->where('indikator_kinerja_id', $id)->delete();

        $response = [
            'message' => 'Berhasil menghapus data indikator kinerja'
        ];

        return $this->respond($response);
    }

    public function modal_tahun_baru()
    {
        $data['tahun'] = $this->db->table('indikator_kinerja')
            ->select('
                tahun
            ')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get()->getResultArray();

        $view = \Config\Services::renderer();
        $response['html'] = $view->setData($data)->render('indikator_kinerja/components/modal_tahun_baru');
        return $this->respond($response, 200);
    }

    public function import_data_tahun()
    {
        $rules = [
            'new_tahun' => [
                'rules' => 'required',
            ],
            'old_tahun' => [
                'rules' => 'required',
            ]
        ];

        if (!($this->validate($rules))) {
            $response = [
                'message' => array_values($this->validation->getErrors())[0],
            ];

            return $this->respond($response, 422);
        }

        $new_tahun = $this->request->getPost('new_tahun');
        $old_tahun = $this->request->getPost('old_tahun');

        if ($new_tahun == $old_tahun) {
            $response = [
                'message' => 'Tahun tidak boleh sama'
            ];
            return $this->respond($response, 422);
        }

        $check_tahun = $this->db->table('indikator_kinerja')->select('tahun')->where('tahun', $new_tahun)->get()->getRowArray();
        if ($check_tahun) {
            $response = [
                'message' => 'Tahun telah tersedia'
            ];
            return $this->respond($response, 422);
        }

        $data['indikator_kinerja'] = $this->db->table('indikator_kinerja')->where('tahun', $old_tahun)->get()->getResultArray();
        $capaian_fakultas = [];
        $target_fakultas = [];
        $indikator_kinerja_jurusan = [];
        $capaian_jurusan = [];
        $target_jurusan = [];

        for ($i = 0; $i < count($data['indikator_kinerja']); $i++) {
            $data['indikator_kinerja'][$i]['tahun'] = $new_tahun;

            $data['capaian_fakultas'] = $this->db->table('capaian_fakultas')->where('indikator_kinerja_id', $data['indikator_kinerja'][$i]['indikator_kinerja_id'])->get()->getResultArray();
            $data['target_fakultas'] = $this->db->table('target_fakultas')->where('indikator_kinerja_id', $data['indikator_kinerja'][$i]['indikator_kinerja_id'])->get()->getResultArray();
            $data['indikator_kinerja_jurusan'] = $this->db->table('indikator_kinerja_jurusan')->where('indikator_kinerja_id', $data['indikator_kinerja'][$i]['indikator_kinerja_id'])->get()->getResultArray();

            if ($data['indikator_kinerja_jurusan']) {
                $data['target_jurusan'] = $this->db->table('target_jurusan')->where('indikator_kinerja_id', $data['indikator_kinerja'][$i]['indikator_kinerja_id'])->get()->getResultArray();
                $data['capaian_jurusan'] = $this->db->table('capaian_jurusan')->where('indikator_kinerja_id', $data['indikator_kinerja'][$i]['indikator_kinerja_id'])->get()->getResultArray();
            }

            unset($data['indikator_kinerja'][$i]['indikator_kinerja_id']);
            $this->db->table('indikator_kinerja')->insert($data['indikator_kinerja'][$i]);
            $insertID = $this->db->insertID();

            for ($j = 0; $j < count($data['capaian_fakultas']); $j++) {
                unset($data['capaian_fakultas'][$j]['indikator_kinerja_id']);
                unset($data['capaian_fakultas'][$j]['capaian_fakultas_id']);
                unset($data['capaian_fakultas'][$j]['created_at']);
                unset($data['capaian_fakultas'][$j]['updated_at']);
                unset($data['capaian_fakultas'][$j]['capaian']);
                unset($data['capaian_fakultas'][$j]['pembagi']);
                unset($data['capaian_fakultas'][$j]['hasil']);
                unset($data['capaian_fakultas'][$j]['file']);
                unset($data['capaian_fakultas'][$j]['updated_by']);
                $data['capaian_fakultas'][$j]['indikator_kinerja_id'] = $insertID;
                array_push($capaian_fakultas, $data['capaian_fakultas'][$j]);
            }

            for ($j = 0; $j < count($data['target_fakultas']); $j++) {
                unset($data['target_fakultas'][$j]['indikator_kinerja_id']);
                unset($data['target_fakultas'][$j]['target_fakultas_id']);
                $data['target_fakultas'][$j]['indikator_kinerja_id'] = $insertID;
                array_push($target_fakultas, $data['target_fakultas'][$j]);
            }

            if ($data['indikator_kinerja_jurusan']) {
                for ($j = 0; $j < count($data['indikator_kinerja_jurusan']); $j++) {
                    unset($data['indikator_kinerja_jurusan'][$j]['indikator_kinerja_id']);
                    unset($data['indikator_kinerja_jurusan'][$j]['ik_jurusan_id']);
                    $data['indikator_kinerja_jurusan'][$j]['indikator_kinerja_id'] = $insertID;
                    array_push($indikator_kinerja_jurusan, $data['indikator_kinerja_jurusan'][$j]);
                }
                for ($j = 0; $j < count($data['target_jurusan']); $j++) {
                    unset($data['target_jurusan'][$j]['indikator_kinerja_id']);
                    unset($data['target_jurusan'][$j]['target_jurusan_id']);
                    $data['target_jurusan'][$j]['indikator_kinerja_id'] = $insertID;
                    array_push($target_jurusan, $data['target_jurusan'][$j]);
                }
                for ($j = 0; $j < count($data['capaian_jurusan']); $j++) {
                    unset($data['capaian_jurusan'][$j]['indikator_kinerja_id']);
                    unset($data['capaian_jurusan'][$j]['capaian_jurusan_id']);
                    unset($data['capaian_jurusan'][$j]['capaian']);
                    unset($data['capaian_jurusan'][$j]['pembagi']);
                    unset($data['capaian_jurusan'][$j]['hasil']);
                    unset($data['capaian_jurusan'][$j]['file']);
                    unset($data['capaian_jurusan'][$j]['created_at']);
                    unset($data['capaian_jurusan'][$j]['updated_at']);
                    unset($data['capaian_jurusan'][$j]['updated_by']);
                    $data['capaian_jurusan'][$j]['indikator_kinerja_id'] = $insertID;
                    array_push($capaian_jurusan, $data['capaian_jurusan'][$j]);
                }
            }
        }

        $this->db->table('capaian_fakultas')->insertBatch($capaian_fakultas);
        $this->db->table('target_fakultas')->insertBatch($target_fakultas);

        if ($data['indikator_kinerja_jurusan']) {
            $this->db->table('indikator_kinerja_jurusan')->insertBatch($indikator_kinerja_jurusan);
            $this->db->table('target_jurusan')->insertBatch($target_jurusan);
            $this->db->table('capaian_jurusan')->insertBatch($capaian_jurusan);
        }

        $response = [
            'message' => 'Berhasil menambahkan data indikator kinerja',
        ];

        return $this->respondCreated($response);
    }

    public function jurusan($id)
    {
        $data['id'] = $id;

        $data['ik'] = $this->db->table('indikator_kinerja_jurusan ikj')
            ->join('indikator_kinerja ik', 'ik.indikator_kinerja_id = ikj.indikator_kinerja_id')
            ->where('ik.indikator_kinerja_id', $id)
            ->get()->getRowArray();

        $data['satuan'] = $this->db->table('satuan')->get()->getResultArray();
        $data['cascading'] = $this->db->table('cascading')->where('is_jurusan', 1)->get()->getResultArray();
        $data['jurusan'] = $this->db->table('jurusan')->get()->getResultArray();

        if ($data['ik']) {
            $data['ik']['jurusan_id'] = array_map(function ($value) {
                return $value['jurusan_id'];
            }, $this->db->table('indikator_kinerja_jurusan')
                ->where('indikator_kinerja_id', $id)
                ->get()->getResultArray());

            // dd($data);

            return view('indikator_kinerja/edit_jurusan', $data);
        } else {
            $data['ik'] = $this->db->table('indikator_kinerja')
                ->where('indikator_kinerja_id', $id)
                ->get()->getRowArray();

            return view('indikator_kinerja/jurusan', $data);
        }
    }

    public function get_cascading()
    {
        $ik = $this->request->getGet('ik');
        $jurusan = $this->request->getGet('jurusan');

        $data = array_map(function ($value) {
            return $value['cascading_id'];
        }, $this->db->table('target_jurusan')
            ->where([
                'indikator_kinerja_id' => $ik,
                'jurusan_id' => $jurusan
            ])
            ->groupBy('cascading_id')
            ->get()->getResultArray());

        $response = [
            'data' => $data
        ];
        return $this->respond($response);
    }

    public function get_target()
    {
        $ik = $this->request->getGet('ik');
        $jurusan = $this->request->getGet('jurusan');
        $cascading = $this->request->getGet('cascading');

        $data = $this->db->table('target_jurusan')
            ->where([
                'indikator_kinerja_id' => $ik,
                'jurusan_id' => $jurusan,
                'cascading_id' => $cascading,
            ])
            ->get()->getRowArray();

        $response = [
            'data' => $data
        ];
        return $this->respond($response);
    }

    public function store_jurusan($id)
    {
        $rules = [
            'satuan' => [
                'rules' => 'required',
            ],
            'keterangan' => [
                'rules' => 'required',
            ]
        ];

        if (!($this->validate($rules))) {
            $response = [
                'message' => array_values($this->validation->getErrors())[0],
            ];

            return $this->respond($response, 422);
        }

        $post_data = $this->request->getPost();

        $uraian = $this->db->table('capaian_fakultas')
            ->select('uraian, sumber_data')
            ->where('indikator_kinerja_id', $id)
            ->groupBy('uraian')
            ->get()->getResultArray();

        $triwulan = $this->db->table('triwulan')->get()->getResultArray();

        $target_itr = 0;
        $capaian_itr = 0;
        for ($i = 0; $i < count($post_data['jurusan']); $i++) {
            $jurusan_id = $post_data['jurusan'][$i];
            $data['indikator_kinerja_jurusan'][$i] = [
                'indikator_kinerja_id' => $id,
                'jurusan_id' => $jurusan_id,
                'satuan_id' => $this->request->getPost('satuan'),
                'keterangan' => $this->request->getPost('keterangan'),
            ];
            for ($j = 0; $j < count($post_data['cascading'][$jurusan_id]); $j++) {
                $cascading_id = $post_data['cascading'][$jurusan_id][$j];
                $data['target_jurusan'][$target_itr] = [
                    'indikator_kinerja_id' => $id,
                    'cascading_id' => $cascading_id,
                    'jurusan_id' => $jurusan_id,
                    'triwulan_satu' => $post_data['tw1'][$jurusan_id][$cascading_id],
                    'triwulan_dua' => $post_data['tw2'][$jurusan_id][$cascading_id],
                    'triwulan_tiga' => $post_data['tw3'][$jurusan_id][$cascading_id],
                    'triwulan_empat' => $post_data['tw4'][$jurusan_id][$cascading_id],
                ];

                $target_itr++;

                for ($k = 0; $k < count($uraian); $k++) {
                    for ($l = 0; $l < count($triwulan); $l++) {
                        $data['capaian_jurusan'][$capaian_itr] = [
                            'indikator_kinerja_id' => $id,
                            'cascading_id' => $cascading_id,
                            'jurusan_id' => $jurusan_id,
                            'uraian' => $uraian[$k]['uraian'],
                            'sumber_data' => $uraian[$k]['sumber_data'],
                            'capaian' => 0,
                            'triwulan_id' => $triwulan[$l]['triwulan_id']
                        ];

                        $capaian_itr++;
                    }
                }
            }
        }

        $this->db->table('indikator_kinerja_jurusan')->insertBatch($data['indikator_kinerja_jurusan']);
        $this->db->table('target_jurusan')->insertBatch($data['target_jurusan']);
        $this->db->table('capaian_jurusan')->insertBatch($data['capaian_jurusan']);

        $response = [
            'message' => 'Berhasil menambahkan data indikator kinerja jurusan',
        ];

        return $this->respond($response);
    }

    public function update_jurusan($id)
    {
        $rules = [
            'satuan' => [
                'rules' => 'required',
            ],
            'keterangan' => [
                'rules' => 'required',
            ]
        ];

        if (!($this->validate($rules))) {
            $response = [
                'message' => array_values($this->validation->getErrors())[0],
            ];

            return $this->respond($response, 422);
        }

        $post_data = $this->request->getPost();

        $uraian =  $this->db->table('capaian_fakultas')
            ->select('uraian, sumber_data')
            ->where('indikator_kinerja_id', $id)
            ->groupBy('uraian')
            ->get()->getResultArray();

        $triwulan = $this->db->table('triwulan')->get()->getResultArray();

        $old_jurusan = array_map(function ($value) {
            return $value['jurusan_id'];
        }, $this->db->table('indikator_kinerja_jurusan')
            ->select('jurusan_id')
            ->where('indikator_kinerja_id', $id)
            ->get()->getResultArray());

        $result_jurusan = array_merge(array_diff($post_data['jurusan'], $old_jurusan), array_diff($old_jurusan, $post_data['jurusan']));

        if (count($result_jurusan) > 0) {
            $target_itr = 0;
            $capaian_itr = 0;
            for ($i = 0; $i < count($result_jurusan); $i++) {
                $jurusan_id = $result_jurusan[$i];

                if (in_array($jurusan_id, $old_jurusan)) {
                    $this->db->table('indikator_kinerja_jurusan')
                        ->where([
                            'indikator_kinerja_id' => $id,
                            'jurusan_id' => $jurusan_id
                        ])->delete();

                    $this->db->table('target_jurusan')
                        ->where([
                            'indikator_kinerja_id' => $id,
                            'jurusan_id' => $jurusan_id
                        ])->delete();

                    $this->db->table('capaian_jurusan')
                        ->where([
                            'indikator_kinerja_id' => $id,
                            'jurusan_id' => $jurusan_id
                        ])->delete();
                } else {
                    $data['indikator_kinerja_jurusan'][$i] = [
                        'indikator_kinerja_id' => $id,
                        'jurusan_id' => $jurusan_id,
                        'satuan_id' => $post_data['satuan'],
                        'keterangan' => $post_data['keterangan'],
                    ];

                    for ($j = 0; $j < count($post_data['cascading'][$jurusan_id]); $j++) {
                        $cascading_id = $post_data['cascading'][$jurusan_id][$j];

                        $data['target_jurusan'][$target_itr] = [
                            'indikator_kinerja_id' => $id,
                            'cascading_id' => $cascading_id,
                            'jurusan_id' => $jurusan_id,
                            'triwulan_satu' => $post_data['tw1'][$jurusan_id][$cascading_id],
                            'triwulan_dua' => $post_data['tw2'][$jurusan_id][$cascading_id],
                            'triwulan_tiga' => $post_data['tw3'][$jurusan_id][$cascading_id],
                            'triwulan_empat' => $post_data['tw4'][$jurusan_id][$cascading_id],
                        ];

                        $target_itr++;

                        for ($k = 0; $k < count($uraian); $k++) {
                            for ($l = 0; $l < count($triwulan); $l++) {
                                $data['capaian_jurusan'][$capaian_itr] = [
                                    'indikator_kinerja_id' => $id,
                                    'cascading_id' => $cascading_id,
                                    'jurusan_id' => $jurusan_id,
                                    'uraian' => $uraian[$k]['uraian'],
                                    'sumber_data' => $uraian[$k]['sumber_data'],
                                    'capaian' => 0,
                                    'triwulan_id' => $triwulan[$l]['triwulan_id']
                                ];

                                $capaian_itr++;
                            }
                        }
                    }
                }
            }
            
            $this->db->table('indikator_kinerja_jurusan')->insertBatch($data['indikator_kinerja_jurusan']);
            $this->db->table('target_jurusan')->insertBatch($data['target_jurusan']);
            $this->db->table('capaian_jurusan')->insertBatch($data['capaian_jurusan']);
        } else {
            $data['indikator_kinerja_jurusan'] = [
                'keterangan' => $post_data['keterangan'],
                'satuan_id' => $post_data['satuan']
            ];

            for ($i = 0; $i < count($post_data['jurusan']); $i++) {
                $jurusan_id = $post_data['jurusan'][$i];
                $old_cascading = array_map(function ($value) {
                    return $value['cascading_id'];
                }, $this->db->table('target_jurusan')
                    ->select('cascading_id')
                    ->where([
                        'indikator_kinerja_id' => $id,
                        'jurusan_id' => $post_data['jurusan'][$i]
                    ])
                    ->get()->getResultArray());

                $result_cascading = array_merge(array_diff($post_data['cascading'][$jurusan_id], $old_cascading), array_diff($old_cascading, $post_data['cascading'][$jurusan_id]));

                if (count($result_cascading) > 0) {
                    for ($j = 0; $j < count($result_cascading); $j++) {
                        $cascading_id = $result_cascading[$j];

                        if (in_array($cascading_id, $old_cascading)) {
                            $this->db->table('target_jurusan')
                                ->where([
                                    'indikator_kinerja_id' => $id,
                                    'jurusan_id' => $jurusan_id,
                                    'cascading_id' => $cascading_id
                                ])->delete();

                            $this->db->table('capaian_jurusan')
                                ->where([
                                    'indikator_kinerja_id' => $id,
                                    'jurusan_id' => $jurusan_id,
                                    'cascading_id' => $cascading_id
                                ])->delete();
                        } else {
                            $data['target_jurusan'] = [
                                'indikator_kinerja_id' => $id,
                                'cascading_id' => $cascading_id,
                                'jurusan_id' => $jurusan_id,
                                'triwulan_satu' => $post_data['tw1'][$jurusan_id][$cascading_id],
                                'triwulan_dua' => $post_data['tw2'][$jurusan_id][$cascading_id],
                                'triwulan_tiga' => $post_data['tw3'][$jurusan_id][$cascading_id],
                                'triwulan_empat' => $post_data['tw4'][$jurusan_id][$cascading_id],
                            ];

                            $itr = 0;
                            for ($k = 0; $k < count($uraian); $k++) {
                                for ($l = 0; $l < count($triwulan); $l++) {
                                    $data['capaian_jurusan'][$itr] = [
                                        'indikator_kinerja_id' => $id,
                                        'cascading_id' => $cascading_id,
                                        'jurusan_id' => $jurusan_id,
                                        'uraian' => $uraian[$k]['uraian'],
                                        'sumber_data' => $uraian[$k]['sumber_data'],
                                        'capaian' => 0,
                                        'triwulan_id' => $triwulan[$l]['triwulan_id']
                                    ];

                                    $itr++;
                                }
                            }

                            $this->db->table('target_jurusan')->insert($data['target_jurusan']);
                            $this->db->table('capaian_jurusan')->insertBatch($data['capaian_jurusan']);
                        }
                    }
                } else {
                    for ($j = 0; $j < count($post_data['cascading'][$jurusan_id]); $j++) {
                        $cascading_id = $post_data['cascading'][$jurusan_id][$j];

                        $data['target_jurusan'] = [
                            'triwulan_satu' => $post_data['tw1'][$jurusan_id][$cascading_id],
                            'triwulan_dua' => $post_data['tw2'][$jurusan_id][$cascading_id],
                            'triwulan_tiga' => $post_data['tw3'][$jurusan_id][$cascading_id],
                            'triwulan_empat' => $post_data['tw4'][$jurusan_id][$cascading_id],
                        ];

                        for ($k = 0; $k < count($uraian); $k++) {
                            $data['capaian_jurusan'] = [
                                'sumber_data' => $uraian[$k]['sumber_data'],
                            ];

                            $this->db->table('capaian_jurusan')
                                ->where([
                                    'indikator_kinerja_id' => $id,
                                    'uraian' => $uraian[$k]['uraian'],
                                ])
                                ->update($data['capaian_jurusan']);
                        }

                        $this->db->table('target_jurusan')->where([
                            'indikator_kinerja_id' => $id,
                            'cascading_id' => $cascading_id,
                            'jurusan_id' => $jurusan_id
                        ])->update($data['target_jurusan']);
                    }
                }
            }

            $this->db->table('indikator_kinerja_jurusan')->where([
                'indikator_kinerja_id' => $id,
            ])->update($data['indikator_kinerja_jurusan']);
        }

        $response = [
            'message' => 'Berhasil mengubah data indikator kinerja jurusan',
        ];

        return $this->respond($response);
    }

    public function modal_pk()
    {
        $data['jurusan'] = $this->db->table('jurusan')->get()->getResultArray();
        $data['tahun'] = $this->db->table('indikator_kinerja')
            ->select('tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get()->getResultArray();

        $view = \Config\Services::renderer();
        $response['html'] = $view->setData($data)->render('indikator_kinerja/components/modal_pk');
        return $this->respond($response, 200);
    }

    public function unduh_pk()
    {
        $unit_kerja = $this->request->getGet('unit');
        $tahun = $this->request->getGet('tahun');
        $data['tahun'] = $tahun;

        $mpdf = new Mpdf(['mode' => 'utf-8', 'debug' => true, 'format' => 'A4']);
        $mpdf->showImageErrors = true;
        $view = \Config\Services::renderer();

        if ($unit_kerja == 1) {
            $data['pk'] = $this->db->table('indikator_kinerja ik')
                ->join('sasaran s', 's.sasaran_id = ik.sasaran_id')
                ->select('s.keterangan as sasaran, ik.sasaran_id')
                ->where('ik.tahun', $tahun)
                ->groupBy('ik.sasaran_id')
                ->get()->getResultArray();

            for ($i = 0; $i < count($data['pk']); $i++) {
                $data['pk'][$i]['indikator'] = $this->db->table('indikator_kinerja ik')
                    ->join('target_fakultas tf', 'tf.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('satuan st', 'st.satuan_id = ik.satuan_id')
                    ->select('
                        ik.kode_indikator_kinerja,
                        ik.keterangan as indikator_kinerja,
                        st.nama_satuan,
                        tf.triwulan_satu,
                        tf.triwulan_dua,
                        tf.triwulan_tiga,
                        tf.triwulan_empat
                    ')
                    ->where([
                        'ik.tahun' => $tahun,
                        'ik.sasaran_id' => $data['pk'][$i]['sasaran_id']
                    ])
                    ->get()->getResultArray();
            }

            $data['rektor'] = $this->db->table('pimpinan')->where('jabatan_id', 1)->get()->getRowArray();
            $data['dekan'] = $this->db->table('pimpinan')->where('jabatan_id', 2)->get()->getRowArray();

            $content = $view->setData($data)->render('indikator_kinerja/components/template_pk_fakultas');
            $namaFile = 'PK_FMIPA_' . $tahun;
        } else {
            $jurusan = $this->request->getGet('jurusan');
            $data['jurusan'] = $this->db->table('jurusan')->where('jurusan_id', $jurusan)->get()->getRowArray();

            $data['pk'] = $this->db->table('indikator_kinerja ik')
                ->join('indikator_kinerja_jurusan ikj', 'ikj.indikator_kinerja_id = ik.indikator_kinerja_id')
                ->join('sasaran s', 's.sasaran_id = ik.sasaran_id')
                ->select('s.keterangan as sasaran, ik.sasaran_id')
                ->where([
                    'ik.tahun' => $tahun,
                    'ikj.jurusan_id' => $jurusan
                ])
                ->groupBy('ik.sasaran_id')
                ->get()->getResultArray();

            for ($i = 0; $i < count($data['pk']); $i++) {
                $data['pk'][$i]['indikator'] = $this->db->table('indikator_kinerja ik')
                    ->join('indikator_kinerja_jurusan ikj', 'ikj.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('satuan st', 'st.satuan_id = ik.satuan_id')
                    ->join('target_jurusan t', 't.indikator_kinerja_id = ik.indikator_kinerja_id')
                    ->join('cascading c', 'c.cascading_id = t.cascading_id')
                    ->select('
                        ik.indikator_kinerja_id,
                        ik.kode_indikator_kinerja,
                        ik.keterangan as indikator_kinerja,
                        st.nama_satuan,
                        c.nama_cascading,
                        t.triwulan_satu,
                        t.triwulan_dua,
                        t.triwulan_tiga,
                        t.triwulan_empat
                    ')
                    ->where([
                        'ik.tahun' => $tahun,
                        'ik.sasaran_id' => $data['pk'][$i]['sasaran_id'],
                        'ikj.jurusan_id' => $jurusan,
                        't.jurusan_id' => $jurusan
                    ])
                    ->get()->getResultArray();
            }

            $data['dekan'] = $this->db->table('pimpinan')->where('jabatan_id', 2)->get()->getRowArray();
            $data['kajur'] = $this->db->table('pimpinan')->where(['jabatan_id' => 3, 'jurusan_id => $jurusan'])->get()->getRowArray();
            $content = $view->setData($data)->render('indikator_kinerja/components/template_pk_jurusan');
            $namaFile = 'PK_FMIPA_' . $tahun . '_' . $data['jurusan']['nama_jurusan'];
        }


        $mpdf->WriteHTML($content);
        ob_end_clean();

        $this->response->setHeader('Content-type', 'application/pdf');
        return $mpdf->Output($namaFile . ".pdf", 'I');
    }
}
