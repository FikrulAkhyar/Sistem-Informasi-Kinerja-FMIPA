<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Indikator Kinerja Fakultas MIPA USK</div>
<div id="app" x-data="app" x-init="[filterTahun='<?= $tahunAktif ?>', filterTriwulan='<?= $triwulanAktif ?>', fetchData()]">
  <div class="mx-auto mt-5 mb-10">
    <div class="grid grid-cols-12 gap-3">
      <div class="lg:col-span-6 col-span-12">
        <div class="form-control w-full">
          <label class="label" for="filter_tahun">
            <span class="label-text">Tahun Anggaran</span>
          </label>
          <select id="filter_tahun" x-model="filterTahun" @click="fetchData" class="select select-bordered" style="width: 100%;">
            <?php foreach ($tahun as $t) : ?>
              <option value="<?= $t['tahun'] ?>" <?= $t['tahun'] == date('Y') ? 'selected' : '' ?>><?= $t['tahun'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
      <div class="lg:col-span-6 col-span-12">
        <div class="form-control w-full">
          <label class="label" for="filter_triwulan">
            <span class="label-text">Triwulan</span>
          </label>
          <select id="filter_triwulan" x-model="filterTriwulan" @click="fetchData" class="select select-bordered" style="width: 100%;">
            <option selected disabled>Pilih Triwulan</option>
            <?php foreach ($triwulan as $t) : ?>
              <option value="<?= $t['triwulan_id'] ?>" <?= in_array(date('F'), $t['bulan']) ? 'selected' : '' ?>><?= $t['nama_triwulan'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto my-3">
      <table class="table w-full" style="width: 100%;">
        <thead>
          <tr class="text-center">
            <th width="50%">Sasaran</th>
            <th>Kode IK</th>
            <th>Indikator Kinerja</th>
            <th>Satuan</th>
            <th>Target</th>
            <th>Uraian</th>
            <th>Capaian</th>
            <th>Pembagi</th>
            <th>Persentase</th>
          </tr>
        </thead>
        <tbody>
          <template x-for="(d, index) in data" :key="index">
            <tr>
              <td rowspan="`${d.indikator.length + d.jumlah_row + 1}`" x-text="`${d.sasaran}`"></td>

              <template x-for="(i, index) in d.indikator" :key="index">
            <tr>
              <td class="text-center" rowspan="`${i.capaian.length + 2}`" x-text="`${i.kode_indikator_kinerja}`"></td>
              <td rowspan="`${i.capaian.length + 2}`" x-text="`${i.indikator_kinerja}`"></td>
              <td class="text-center" rowspan="`${i.capaian.length + 2}`" x-text="`${i.nama_satuan}`"></td>
              <td class="text-center" rowspan="`${i.capaian.length + 2}`" x-text="`${i.target}`"></td>

              <template x-for="(c, index) in i.capaian" :key="index">
            <tr>
              <td x-text="`${c.uraian}`"></td>
              <td class="text-center" x-text="`${c.capaian}`"></td>
              <td class="text-center" x-text="`${c.pembagi}`"></td>
              <td class="text-center" x-text="`${c.hasil}`"></td>
            </tr>
          </template>
          <tr>
            <td colspan="3" align="right" class="font-bold">Jumlah</td>
            <td class="text-center font-bold" x-text="`${i.jumlah}`"></td>
          </tr>
          </tr>
          </template>
          </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- <canvas id="myChart" height="100"></canvas> -->
  </div>
</div>

<script>
  const app = function() {
    return {
      data: [],
      filterTahun: '',
      filterTriwulan: '',
      fetchData: function() {
        const $this = this

        $.ajax({
          url: `${BASE_URL}/beranda/capaian`,
          data: {
            tahun: $this.filterTahun,
            triwulan: $this.filterTriwulan
          },
          success: function(response) {
            console.log(response.data)
            $this.data = Array.from(response.data)
            // $this.semuaBank = response.data.semuaBank
          }
        })
      },
    }
  }

  // var labels, tw1, tw2, tw3, tw4;
  // var config = {
  //   type: 'bar',
  //   data: {
  //     labels: labels,
  //     datasets: [{
  //         label: 'TW1',
  //         data: tw1,
  //         borderColor: '#ff6666',
  //         backgroundColor: '#ff6666',
  //       },
  //       {
  //         label: 'TW2',
  //         data: tw2,
  //         borderColor: '#009933',
  //         backgroundColor: '#009933',
  //       },
  //       {
  //         label: 'TW3',
  //         data: tw3,
  //         borderColor: '#2094f3',
  //         backgroundColor: '#2094f3',
  //       },
  //       {
  //         label: 'TW4',
  //         data: tw4,
  //         borderColor: '#EF9105',
  //         backgroundColor: '#EF9105',
  //       }
  //     ]
  //   },
  //   options: {
  //     indexAxis: 'x',
  //     elements: {
  //       bar: {
  //         borderWidth: 2,
  //       }
  //     },
  //     responsive: true,
  //     plugins: {
  //       legend: {
  //         position: 'top',
  //       },
  //       title: {
  //         display: true,
  //         text: 'Nilai Capaian Anggaran Tahun'
  //       }
  //     }
  //   },
  // }

  // const chart = new Chart($('#myChart'), config)

  // $.ajax({
  //   url: `${BASE_URL}/api/chart/anggaran`,
  //   method: "GET",
  //   success: function(response) {
  //     response.map(function(item) {
  //       config.data.labels.push(item.label)
  //       config.data.datasets[0].data.push(item.tw1)
  //       config.data.datasets[1].data.push(item.tw2)
  //       config.data.datasets[2].data.push(item.tw3)
  //       config.data.datasets[3].data.push(item.tw4)
  //       config.options.plugins.title.text = `Nilai Capaian Anggaran Tahun ${item.tahun}`
  //     })

  //     chart.update()
  //   }
  // });

  // $('#selectSemester').on('change', function() {
  //   var semester = $(this).val()
  //   if (semester != '') {
  //     var url = `${BASE_URL}/statistik/chart_prodi/${semester}`
  //   } else {
  //     var url = `${BASE_URL}/statistik/chart_prodi/`
  //   }

  //   $.ajax({
  //     url: url,
  //     method: "GET",
  //     success: function(response) {
  //       labels = response.label;
  //       belumBayar = response.belumBayar;
  //       sudahBayar = response.sudahBayar;

  //       config.data.labels = labels;
  //       config.data.datasets[0].data = belumBayar;
  //       config.data.datasets[1].data = sudahBayar;
  //       chart.update()
  //     }
  //   });
  // })
</script>
<?= $this->endSection() ?>