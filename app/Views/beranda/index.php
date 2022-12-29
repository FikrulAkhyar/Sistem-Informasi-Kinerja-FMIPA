<?= $this->extend('layouts/dashboard.php') ?>
<?= $this->section('page-assets') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="lg:text-2xl text-xl font-bold">Grafik Nilai Capaian Anggaran Masing-Masing Program Studi</div>
<div class="mx-auto mt-5 mb-10">
  <div class="form-control w-full">
    <label class="label" for="filter_tahun">
      <span class="label-text">Tahun Anggaran</span>
    </label>
    <select id="filter_tahun" class="select select-bordered" data-placeholder="pilih tahun anggaran" style="width: 100%;">
      <option value="2022">2022</option>
      <option value="2021">2021</option>
      <option value="2020">2020</option>
      <option value="2019">2019</option>
    </select>
  </div>
  <canvas id="myChart" height="100"></canvas>
</div>

<script>
  $('#filter_tahun').select2()
  var labels, tw1, tw2, tw3, tw4;
  var config = {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
          label: 'TW1',
          data: tw1,
          borderColor: '#ff6666',
          backgroundColor: '#ff6666',
        },
        {
          label: 'TW2',
          data: tw2,
          borderColor: '#009933',
          backgroundColor: '#009933',
        },
        {
          label: 'TW3',
          data: tw3,
          borderColor: '#2094f3',
          backgroundColor: '#2094f3',
        },
        {
          label: 'TW4',
          data: tw4,
          borderColor: '#EF9105',
          backgroundColor: '#EF9105',
        }
      ]
    },
    options: {
      indexAxis: 'x',
      elements: {
        bar: {
          borderWidth: 2,
        }
      },
      responsive: true,
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Nilai Capaian Anggaran Tahun'
        }
      }
    },
  }

  const chart = new Chart($('#myChart'), config)

  $.ajax({
    url: `${BASE_URL}/api/chart/anggaran`,
    method: "GET",
    success: function(response) {
      response.map(function(item) {
        config.data.labels.push(item.label)
        config.data.datasets[0].data.push(item.tw1)
        config.data.datasets[1].data.push(item.tw2)
        config.data.datasets[2].data.push(item.tw3)
        config.data.datasets[3].data.push(item.tw4)
        config.options.plugins.title.text = `Nilai Capaian Anggaran Tahun ${item.tahun}`
      })

      chart.update()
    }
  });

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