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
      <a class="inline-flex shrink-0 items-center gap-[10px] font-display text-xl font-bold text-ink" href="index.html#beranda" aria-label="MotoCare beranda">
        <span class="grid size-[31px] place-items-center rounded-[10px_10px_10px_3px] bg-blue font-display text-[1.1rem] text-white shadow-[0_5px_12px_#3778f638]">M</span>
        <span>Moto<span class="text-blue">Care</span></span>
      </a>
      <nav class="ml-auto flex gap-7 text-[.9rem] font-semibold text-muted max-[850px]:gap-[15px] max-[560px]:order-3 max-[560px]:w-full max-[560px]:justify-between max-[560px]:gap-2 max-[560px]:overflow-x-auto" aria-label="Navigasi utama">
        <a class="border-b-[3px] border-transparent py-7 transition-colors hover:border-blue hover:text-blue max-[560px]:whitespace-nowrap max-[560px]:py-[13px] max-[560px]:text-[.76rem]" href="index.html#beranda">Beranda</a>
        <a class="border-b-[3px] border-transparent py-7 transition-colors hover:border-blue hover:text-blue max-[560px]:whitespace-nowrap max-[560px]:py-[13px] max-[560px]:text-[.76rem]" href="index.html#riwayat">Riwayat</a>
        <a class="border-b-[3px] border-blue py-7 text-blue max-[560px]:whitespace-nowrap max-[560px]:py-[13px] max-[560px]:text-[.76rem]" href="#program" aria-current="page">Program</a>
        <a class="border-b-[3px] border-transparent py-7 transition-colors hover:border-blue hover:text-blue max-[560px]:whitespace-nowrap max-[560px]:py-[13px] max-[560px]:text-[.76rem]" href="index.html#pengingat">Pengingat</a>
      </nav>
      <a class="flex shrink-0 items-center gap-[9px] text-[.84rem] font-semibold text-ink max-[850px]:[&>span:last-child]:hidden" href="index.html#profil"><span class="grid size-[31px] place-items-center rounded-full bg-[#ed8663] text-[.68rem] text-white">MA</span><span>Profil saya</span></a>
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
          <span class="rounded-full bg-[#fff0ee] px-4 py-2 text-[.75rem] font-bold text-[#c95249]"><?= $statusCounts['segera'] ?? 0 ?> perlu perhatian</span>
          <span class="rounded-full bg-[#fff8e9] px-4 py-2 text-[.75rem] font-bold text-[#a87900]"><?= $statusCounts['terjadwal'] ?? 0 ?> terjadwal</span>
          <span class="rounded-full bg-[#e4f7f1] px-4 py-2 text-[.75rem] font-bold text-[#16866c]"><?= $statusCounts['rutin'] ?? 0 ?> perawatan rutin</span>
        </div>
      </div>
    </section>

    <section class="bg-white py-[76px] max-[560px]:py-[55px]" aria-labelledby="program-list-title">
      <div class="mx-auto w-[min(1120px,calc(100%-48px))] max-[560px]:w-[calc(100%-32px)]">
        <div class="mb-[30px] flex items-end justify-between gap-5 max-[560px]:flex-col max-[560px]:items-start">
          <div>
            <p class="mb-2 text-[.72rem] font-bold uppercase tracking-[.1em] text-blue">Daftar perawatan</p>
            <h2 class="font-display text-[clamp(1.8rem,3vw,2.6rem)] font-bold leading-tight tracking-[-.05em]" id="program-list-title">Jaga performa, satu langkah demi satu.</h2>
          </div>
          <a class="inline-flex shrink-0 items-center justify-center gap-[10px] rounded-[10px] bg-blue px-5 py-[13px] text-[.84rem] font-bold text-white shadow-[0_10px_20px_#3778f630] transition hover:-translate-y-0.5" href="index.html#pengingat">Lihat pengingat <span aria-hidden="true">→</span></a>
        </div>

        <div class="grid grid-cols-3 gap-4 max-[850px]:grid-cols-2 max-[600px]:grid-cols-1">
          <?php foreach ($programs as $index => $program): ?>
            <?php
            $status = $program['status'];
            if (!isset($statusStyles[$status])) {
                throw new UnexpectedValueException('Status program tidak dikenali: ' . $status);
            }
            ?>
            <article class="flex min-h-[250px] flex-col rounded-[14px] border border-[#e7edf5] bg-white p-6 shadow-[0_8px_24px_#8499b50d] transition hover:-translate-y-1 hover:shadow-[0_14px_30px_#8499b51a]">
              <div class="mb-5 flex items-center justify-between gap-3">
                <span class="grid size-11 place-items-center rounded-[12px] text-[1.15rem] <?= $escapeHtml($program['icon_class']) ?>" aria-hidden="true"><?= $escapeHtml($program['icon']) ?></span>
                <span class="rounded-full px-3 py-[6px] text-[.65rem] font-bold <?= $statusStyles[$status] ?>"><?= $escapeHtml($program['status_label']) ?></span>
              </div>
              <p class="mb-2 text-[.66rem] font-bold uppercase tracking-[.1em] text-muted"><?= $escapeHtml($program['category']) ?></p>
              <h3 class="font-display text-[1.1rem] font-bold leading-snug tracking-[-.03em]"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?>. <?= $escapeHtml($program['title']) ?></h3>
              <p class="mt-2 text-[.79rem] leading-[1.6] text-muted"><?= $escapeHtml($program['description']) ?></p>
              <div class="mt-auto flex items-center gap-2 border-t border-[#edf1f6] pt-4 text-[.72rem] font-semibold text-ink">
                <span class="text-blue" aria-hidden="true">◷</span>
                <span><?= $escapeHtml($program['interval']) ?></span>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="bg-blue-soft py-[58px]">
      <div class="mx-auto flex w-[min(1120px,calc(100%-48px))] items-center justify-between gap-8 max-[650px]:w-[calc(100%-32px)] max-[650px]:flex-col max-[650px]:items-start">
        <div>
          <p class="mb-2 text-[.72rem] font-bold uppercase tracking-[.1em] text-blue">Konsisten itu penting</p>
          <h2 class="font-display text-[clamp(1.65rem,3vw,2.2rem)] font-bold tracking-[-.05em]">Servis rutin, perjalanan makin tenang.</h2>
        </div>
        <a class="inline-flex shrink-0 items-center justify-center gap-[10px] rounded-[10px] border border-[#b8cdf7] bg-white px-5 py-[13px] text-[.84rem] font-bold text-blue transition hover:bg-blue-soft" href="index.html#riwayat">Lihat riwayat servis <span aria-hidden="true">↗</span></a>
      </div>
    </section>
  </main>

  <footer class="bg-ink py-[34px] text-white">
    <div class="mx-auto flex w-[min(1120px,calc(100%-48px))] items-center justify-between max-[850px]:items-start max-[850px]:flex-col max-[850px]:gap-6 max-[560px]:w-[calc(100%-32px)]">
      <div>
        <a class="inline-flex items-center gap-[10px] font-display text-xl font-bold text-white" href="index.html#beranda"><span class="grid size-[31px] place-items-center rounded-[10px_10px_10px_3px] bg-yellow font-display text-[1.1rem] text-ink">M</span><span>Moto<span class="text-blue">Care</span></span></a>
        <p class="mt-[9px] text-[.75rem] text-[#9eacc3]">Teman perjalanan untuk motor yang selalu siap.</p>
      </div>
      <div class="flex gap-6 text-[.68rem] text-[#9eacc3] max-[560px]:flex-wrap max-[560px]:gap-x-5 max-[560px]:gap-y-[10px]"><span>Kelompok 15</span><span>PHP Server-Side Rendering</span><span>© 2024 MotoCare</span></div>
    </div>
  </footer>
</body>
</html>
