<?php
final class Motorcycle
{
    public function __construct(
        private readonly string $brand,
        private readonly string $model,
        private readonly int $year,
        private readonly int $mileage,
        private readonly string $condition,
        private readonly array $programs,
    ) {
    }

    public function getProfile(): array
    {
        return [
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'mileage' => $this->mileage,
            'condition' => $this->condition,
        ];
    }

    public function getPrograms(): array
    {
        return $this->programs;
    }

    public function getProgramCounts(): array
    {
        $counts = ['segera' => 0, 'terjadwal' => 0, 'rutin' => 0];

        foreach ($this->programs as $program) {
            if (!array_key_exists($program['status'], $counts)) {
                throw new UnexpectedValueException('Status program tidak dikenali: ' . $program['status']);
            }

            $counts[$program['status']]++;
        }

        return $counts;
    }
}

$motorcycle = new Motorcycle(
    'Honda',
    'Scoopy',
    2022,
    12840,
    'Baik',
    [
        [
            'category' => 'Mesin',
            'title' => 'Ganti oli mesin',
            'description' => 'Jaga pelumasan mesin agar performa tetap halus dan suhu terkontrol.',
            'interval' => 'Setiap 2.000 km atau 2 bulan',
            'status' => 'segera',
            'status_label' => 'Segera',
            'icon' => '◉',
            'icon_class' => 'bg-[#fff4d2] text-[#d69c00]',
        ],
        [
            'category' => 'Keselamatan',
            'title' => 'Periksa sistem pengereman',
            'description' => 'Pastikan kampas, tuas, dan minyak rem bekerja dengan baik.',
            'interval' => 'Setiap 4.000 km',
            'status' => 'terjadwal',
            'status_label' => 'Terjadwal',
            'icon' => '＋',
            'icon_class' => 'bg-[#fff0ee] text-[#ed6c63]',
        ],
        [
            'category' => 'Roda',
            'title' => 'Cek tekanan dan kondisi ban',
            'description' => 'Periksa tekanan angin serta alur ban untuk menjaga traksi.',
            'interval' => 'Setiap 1.000 km',
            'status' => 'rutin',
            'status_label' => 'Rutin',
            'icon' => '◌',
            'icon_class' => 'bg-blue-soft text-blue',
        ],
        [
            'category' => 'Transmisi',
            'title' => 'Bersihkan dan lumasi rantai',
            'description' => 'Bersihkan rantai dari kotoran dan atur kekencangannya.',
            'interval' => 'Setiap 500 km',
            'status' => 'rutin',
            'status_label' => 'Rutin',
            'icon' => '↗',
            'icon_class' => 'bg-[#eaf8f4] text-green',
        ],
        [
            'category' => 'Kelistrikan',
            'title' => 'Periksa aki dan lampu',
            'description' => 'Cek tegangan aki, lampu utama, sein, dan lampu rem.',
            'interval' => 'Setiap 3 bulan',
            'status' => 'terjadwal',
            'status_label' => 'Terjadwal',
            'icon' => 'ϟ',
            'icon_class' => 'bg-[#fff8e9] text-[#d69c00]',
        ],
        [
            'category' => 'Kenyamanan',
            'title' => 'Servis filter udara',
            'description' => 'Bersihkan filter udara agar aliran udara mesin tetap optimal.',
            'interval' => 'Setiap 8.000 km',
            'status' => 'rutin',
            'status_label' => 'Rutin',
            'icon' => '⌁',
            'icon_class' => 'bg-[#f2efff] text-[#7658c7]',
        ],
    ],
);

$statusStyles = [
    'segera' => 'bg-[#fff0ee] text-[#c95249]',
    'terjadwal' => 'bg-[#fff8e9] text-[#a87900]',
    'rutin' => 'bg-[#e4f7f1] text-[#16866c]',
];

$profile = $motorcycle->getProfile();
$programs = $motorcycle->getPrograms();
$statusCounts = $motorcycle->getProgramCounts();
$escapeHtml = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Daftar program prioritas perawatan motor MotoCare dengan jadwal dan status yang mudah dipantau.">
  <title>Program Prioritas | MotoCare</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body class="overflow-x-hidden bg-[#fbfcfe] font-sans text-ink">
  <header class="sticky top-0 z-10 border-b border-[#edf1f6] bg-[rgba(251,252,254,0.94)] backdrop-blur-xl max-[560px]:static">
    <div class="mx-auto flex min-h-[76px] w-[min(1120px,calc(100%-48px))] items-center gap-[42px] max-[850px]:gap-[18px] max-[560px]:w-[calc(100%-32px)] max-[560px]:flex-wrap max-[560px]:pt-[15px]">
      <a class="inline-flex shrink-0 items-center gap-[10px] font-display text-xl font-bold text-ink" href="index.php#beranda" aria-label="MotoCare beranda">
        <span class="grid size-[31px] place-items-center rounded-[10px_10px_10px_3px] bg-blue font-display text-[1.1rem] text-white shadow-[0_5px_12px_#3778f638]">M</span>
        <span>Moto<span class="text-blue">Care</span></span>
      </a>
      <nav class="ml-auto flex gap-7 text-[.9rem] font-semibold text-muted max-[850px]:gap-[15px] max-[560px]:order-3 max-[560px]:w-full max-[560px]:justify-between max-[560px]:gap-2 max-[560px]:overflow-x-auto" aria-label="Navigasi utama">
        <a class="border-b-[3px] border-transparent py-7 transition-colors hover:border-blue hover:text-blue max-[560px]:whitespace-nowrap max-[560px]:py-[13px] max-[560px]:text-[.76rem]" href="index.php#beranda">Beranda</a>
        <a class="border-b-[3px] border-transparent py-7 transition-colors hover:border-blue hover:text-blue max-[560px]:whitespace-nowrap max-[560px]:py-[13px] max-[560px]:text-[.76rem]" href="index.php#riwayat">Riwayat</a>
        <a class="border-b-[3px] border-blue py-7 text-blue max-[560px]:whitespace-nowrap max-[560px]:py-[13px] max-[560px]:text-[.76rem]" href="#program" aria-current="page">Program</a>
        <a class="border-b-[3px] border-transparent py-7 transition-colors hover:border-blue hover:text-blue max-[560px]:whitespace-nowrap max-[560px]:py-[13px] max-[560px]:text-[.76rem]" href="index.php#pengingat">Pengingat</a>
      </nav>
      <a class="flex shrink-0 items-center gap-[9px] text-[.84rem] font-semibold text-ink max-[850px]:[&>span:last-child]:hidden" href="index.php#profil"><span class="grid size-[31px] place-items-center rounded-full bg-[#ed8663] text-[.68rem] text-white">MA</span><span>Profil saya</span></a>
    </div>
  </header>

  <main>
    <section class="bg-[linear-gradient(115deg,#fbfcfe_50%,#f2f7ff_50%)] py-[78px] max-[560px]:bg-[#fbfcfe] max-[560px]:py-[55px]" id="program">
      <div class="mx-auto w-[min(1120px,calc(100%-48px))] max-[560px]:w-[calc(100%-32px)]">
        <p class="mb-[17px] text-[.72rem] font-bold uppercase tracking-[.12em] text-blue"><span class="mr-2 inline-block h-[3px] w-[19px] rounded bg-yellow align-middle"></span>Perawatan lebih terarah</p>
        <div class="grid grid-cols-[1fr_auto] items-end gap-8 max-[700px]:grid-cols-1 max-[700px]:gap-5">
          <div>
            <h1 class="mb-[18px] max-w-[680px] font-display text-[clamp(2.7rem,5vw,4.5rem)] font-bold leading-[.98] tracking-[-.06em]">Program <span class="text-blue">prioritas.</span></h1>
            <p class="max-w-[580px] text-[1rem] leading-[1.7] text-muted">Rangkaian perawatan penting untuk menjaga motor tetap aman, nyaman, dan siap menemani perjalanan.</p>
          </div>
          <div class="rounded-[14px] border border-[#e1eafb] bg-white px-6 py-5 shadow-[0_12px_28px_#8499b514] max-[700px]:w-full">
            <span class="block text-[.72rem] font-semibold text-muted">Kendaraan aktif</span>
            <strong class="mt-1 block font-display text-[1.25rem] leading-tight"><?= $escapeHtml($profile['brand'] . ' ' . $profile['model']) ?></strong>
            <span class="mt-2 block text-[.68rem] text-muted">Tahun <?= $profile['year'] ?> · <?= number_format($profile['mileage'], 0, ',', '.') ?> km</span>
            <span class="mt-3 inline-block rounded-full bg-[#e4f7f1] px-3 py-1 text-[.68rem] font-bold text-[#16866c]"><?= $escapeHtml($profile['condition']) ?> · <?= count($programs) ?> program perawatan</span>
          </div>
        </div>

        <div class="mt-9 flex flex-wrap gap-3" aria-label="Ringkasan status program">
          <span class="rounded-full bg-[#fff0ee] px-4 py-2 text-[.75rem] font-bold text-[#c95249]"><span id="urgent-count"><?= $statusCounts['segera'] ?? 0 ?></span> perlu perhatian</span>
          <span class="rounded-full bg-[#fff8e9] px-4 py-2 text-[.75rem] font-bold text-[#a87900]"><span id="scheduled-count"><?= $statusCounts['terjadwal'] ?? 0 ?></span> terjadwal</span>
          <span class="rounded-full bg-[#e4f7f1] px-4 py-2 text-[.75rem] font-bold text-[#16866c]"><span id="routine-count"><?= $statusCounts['rutin'] ?? 0 ?></span> perawatan rutin</span>
        </div>
      </div>
    </section>

    <section class="bg-white py-[76px] max-[560px]:py-[55px]" aria-labelledby="program-list-title">
      <div class="mx-auto w-[min(1120px,calc(100%-48px))] max-[560px]:w-[calc(100%-32px)]">
        <div class="mb-[30px] flex items-end justify-between gap-5 max-[560px]:flex-col max-[560px]:items-start">
          <div>
            <p class="mb-2 text-[.72rem] font-bold uppercase tracking-[.1em] text-blue">Daftar perawatan</p>
            <h2 class="font-display text-[clamp(1.8rem,3vw,2.6rem)] font-bold leading-tight tracking-[-.05em]" id="program-list-title">Rawat motor, satu langkah demi satu.</h2>
          </div>
          <button class="care-task-refresh" id="refresh-tasks" type="button"><span aria-hidden="true">↻</span> Refresh data</button>
        </div>

        <form class="care-task-form" id="task-form">
          <div class="care-task-fields">
            <label>
              <span>Nama perawatan</span>
              <input id="task-title" name="title" type="text" maxlength="120" placeholder="Contoh: Periksa tekanan ban" required>
            </label>
            <label>
              <span>Catatan <small>(opsional)</small></span>
              <input id="task-description" name="description" type="text" maxlength="500" placeholder="Tambahkan detail perawatan">
            </label>
            <button class="care-task-submit" id="submit-task" type="submit">+ Tambah perawatan</button>
          </div>
        </form>
        <p class="care-task-error" id="task-error" role="alert" hidden></p>
        <p class="care-task-status" id="task-status" role="status" aria-live="polite">Memuat daftar perawatan...</p>
        <div class="grid grid-cols-3 gap-4 max-[850px]:grid-cols-2 max-[600px]:grid-cols-1" id="task-list" aria-live="polite"></div>
        <noscript>
          <p class="care-task-error">Aktifkan JavaScript untuk memuat dan mengelola daftar perawatan.</p>
        </noscript>
      </div>
    </section>

    <section class="bg-blue-soft py-[58px]">
      <div class="mx-auto flex w-[min(1120px,calc(100%-48px))] items-center justify-between gap-8 max-[650px]:w-[calc(100%-32px)] max-[650px]:flex-col max-[650px]:items-start">
        <div>
          <p class="mb-2 text-[.72rem] font-bold uppercase tracking-[.1em] text-blue">Konsisten itu penting</p>
          <h2 class="font-display text-[clamp(1.65rem,3vw,2.2rem)] font-bold tracking-[-.05em]">Servis rutin, perjalanan makin tenang.</h2>
        </div>
        <a class="inline-flex shrink-0 items-center justify-center gap-[10px] rounded-[10px] border border-[#b8cdf7] bg-white px-5 py-[13px] text-[.84rem] font-bold text-blue transition hover:bg-blue-soft" href="index.php#riwayat">Lihat riwayat servis <span aria-hidden="true">↗</span></a>
      </div>
    </section>
  </main>

  <footer class="bg-ink py-[34px] text-white">
    <div class="mx-auto flex w-[min(1120px,calc(100%-48px))] items-center justify-between max-[850px]:items-start max-[850px]:flex-col max-[850px]:gap-6 max-[560px]:w-[calc(100%-32px)]">
      <div>
        <a class="inline-flex items-center gap-[10px] font-display text-xl font-bold text-white" href="index.php#beranda"><span class="grid size-[31px] place-items-center rounded-[10px_10px_10px_3px] bg-yellow font-display text-[1.1rem] text-ink">M</span><span>Moto<span class="text-blue">Care</span></span></a>
        <p class="mt-[9px] text-[.75rem] text-[#9eacc3]">Teman perjalanan untuk motor yang selalu siap.</p>
      </div>
      <div class="flex gap-6 text-[.68rem] text-[#9eacc3] max-[560px]:flex-wrap max-[560px]:gap-x-5 max-[560px]:gap-y-[10px]"><span>Kelompok 15</span><span>PHP Server-Side Rendering</span><span>© 2024 MotoCare</span></div>
    </div>
  </footer>
  <script>
    (() => {
      const apiUrl = 'api/program-perawatan.php';
      const taskList = document.getElementById('task-list');
      const taskForm = document.getElementById('task-form');
      const taskTitle = document.getElementById('task-title');
      const taskDescription = document.getElementById('task-description');
      const submitButton = document.getElementById('submit-task');
      const refreshButton = document.getElementById('refresh-tasks');
      const statusMessage = document.getElementById('task-status');
      const errorMessage = document.getElementById('task-error');
      const tasksById = new Map();
      const statusLabels = {
        segera: 'Segera',
        terjadwal: 'Terjadwal',
        rutin: 'Rutin',
      };

      function showError(message) {
        errorMessage.textContent = message;
        errorMessage.hidden = false;
        window.alert(message);
      }

      function clearError() {
        errorMessage.textContent = '';
        errorMessage.hidden = true;
      }

      async function requestApi(method = 'GET', data = null) {
        const options = { method, headers: { Accept: 'application/json' } };
        if (data !== null) {
          options.headers['Content-Type'] = 'application/json';
          options.body = JSON.stringify(data);
        }

        const response = await fetch(apiUrl, options);
        let payload;
        try {
          payload = await response.json();
        } catch {
          throw new Error('Server mengirim respons yang tidak dapat dibaca.');
        }

        if (!response.ok) {
          throw new Error(payload.message || 'Permintaan gagal. Silakan coba lagi.');
        }

        return payload.data;
      }

      function createElement(tag, className, text = '') {
        const element = document.createElement(tag);
        element.className = className;
        element.textContent = text;
        return element;
      }

      function renderTasks(tasks) {
        tasksById.clear();
        taskList.replaceChildren();

        if (tasks.length === 0) {
          taskList.append(createElement('p', 'care-task-empty', 'Belum ada perawatan. Tambahkan perawatan baru di atas.'));
        }

        const counts = { segera: 0, terjadwal: 0, rutin: 0 };
        tasks.forEach((task, index) => {
          tasksById.set(task.id, task);
          if (!task.completed && Object.hasOwn(counts, task.status)) {
            counts[task.status] += 1;
          }

          const card = createElement('article', `care-task-card${task.completed ? ' is-complete' : ''}`);
          const cardTop = createElement('div', 'care-task-card-top');
          const number = createElement('span', 'care-task-number', String(index + 1).padStart(2, '0'));
          const badge = createElement('span', `care-task-badge ${task.completed ? 'badge-complete' : `badge-${task.status}`}`, task.completed ? 'Selesai' : (statusLabels[task.status] || 'Rutin'));
          const title = createElement('h3', 'care-task-title', task.title);
          const description = createElement('p', 'care-task-description', task.description || 'Tidak ada catatan tambahan.');
          const interval = createElement('p', 'care-task-interval', `◷ ${task.interval}`);
          const toggle = createElement('button', 'care-task-toggle', task.completed ? 'Tandai belum selesai' : 'Tandai selesai');

          cardTop.append(number, badge);
          toggle.type = 'button';
          toggle.dataset.action = 'toggle';
          toggle.dataset.id = task.id;
          toggle.setAttribute('aria-pressed', String(task.completed));
          toggle.setAttribute('aria-label', `${toggle.textContent}: ${task.title}`);
          card.append(cardTop, title, description, interval, toggle);
          taskList.append(card);
        });

        document.getElementById('urgent-count').textContent = String(counts.segera);
        document.getElementById('scheduled-count').textContent = String(counts.terjadwal);
        document.getElementById('routine-count').textContent = String(counts.rutin);
      }

      async function loadTasks() {
        clearError();
        statusMessage.classList.add('is-loading');
        statusMessage.textContent = 'Memuat daftar perawatan...';
        refreshButton.disabled = true;

        try {
          const tasks = await requestApi();
          renderTasks(tasks);
          statusMessage.textContent = `${tasks.length} perawatan dimuat.`;
        } catch (error) {
          const message = error instanceof Error ? error.message : 'Terjadi kesalahan saat memuat data.';
          statusMessage.textContent = 'Daftar perawatan gagal dimuat.';
          showError(message);
        } finally {
          statusMessage.classList.remove('is-loading');
          refreshButton.disabled = false;
        }
      }

      taskForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearError();
        submitButton.disabled = true;

        try {
          const task = await requestApi('POST', {
            title: taskTitle.value,
            description: taskDescription.value,
          });
          renderTasks([...tasksById.values(), task]);
          taskForm.reset();
          statusMessage.textContent = 'Perawatan berhasil ditambahkan.';
        } catch (error) {
          const message = error instanceof Error ? error.message : 'Terjadi kesalahan saat menambahkan perawatan.';
          showError(message);
        } finally {
          submitButton.disabled = false;
        }
      });

      taskList.addEventListener('click', async (event) => {
        if (!(event.target instanceof Element)) {
          return;
        }
        const button = event.target.closest('button[data-action="toggle"]');
        if (!button) {
          return;
        }

        const task = tasksById.get(button.dataset.id);
        if (!task) {
          return;
        }

        button.disabled = true;
        clearError();
        try {
          const updatedTask = await requestApi('PATCH', {
            id: task.id,
            completed: !task.completed,
          });
          renderTasks([...tasksById.values()].map((item) => item.id === updatedTask.id ? updatedTask : item));
          statusMessage.textContent = 'Status perawatan berhasil diperbarui.';
        } catch (error) {
          button.disabled = false;
          const message = error instanceof Error ? error.message : 'Terjadi kesalahan saat memperbarui status.';
          showError(message);
        }
      });

      refreshButton.addEventListener('click', loadTasks);
      loadTasks();
    })();
  </script>
</body>
</html>
