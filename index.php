<?php
$pageTitle = 'Program Prioritas';
$workspaceName = 'MotoCare';
$ownerName = 'Kelompok 15';
$periodLabel = 'Oktober 2026';

class MotoCareProgram
{
    public function __construct(
        private string $code,
        private string $title,
        private string $description,
        private string $category,
        private string $priority,
        private string $status,
        private int $progress,
        private string $deadline,
        private string $team
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getProgress(): int
    {
        return max(0, min(100, $this->progress));
    }

    public function getDeadline(): string
    {
        return $this->deadline;
    }

    public function getTeam(): string
    {
        return $this->team;
    }

    public function getStatusClass(): string
    {
        return match ($this->status) {
            'Berjalan' => 'status-running',
            'Perencanaan' => 'status-planned',
            'Selesai' => 'status-complete',
            default => 'status-default',
        };
    }

    public function getPriorityClass(): string
    {
        return match ($this->priority) {
            'Tinggi' => 'priority-high',
            'Sedang' => 'priority-medium',
            'Rendah' => 'priority-low',
            default => 'priority-default',
        };
    }
}

$programs = [
    new MotoCareProgram(
        'MTR-01',
        'Pencatatan riwayat servis',
        'Mencatat tanggal, jenis perawatan, bengkel, dan biaya servis motor.',
        'Riwayat perawatan',
        'Tinggi',
        'Berjalan',
        75,
        '20 Okt 2026',
        'Tim MotoCare'
    ),
    new MotoCareProgram(
        'MTR-02',
        'Pengingat servis berkala',
        'Mengingatkan pemilik motor berdasarkan jadwal servis dan estimasi kilometer.',
        'Jadwal servis',
        'Tinggi',
        'Berjalan',
        58,
        '24 Okt 2026',
        'Tim MotoCare'
    ),
    new MotoCareProgram(
        'MTR-03',
        'Ringkasan kondisi motor',
        'Menampilkan kondisi motor, odometer, serta informasi perawatan dalam dashboard.',
        'Dashboard',
        'Sedang',
        'Perencanaan',
        20,
        '30 Okt 2026',
        'Tim MotoCare'
    ),
    new MotoCareProgram(
        'MTR-04',
        'Referensi merek motor',
        'Mengambil daftar merek motor dari layanan API sebagai referensi kendaraan.',
        'Integrasi',
        'Rendah',
        'Selesai',
        100,
        '10 Okt 2026',
        'Tim MotoCare'
    ),
];

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$programCount = count($programs);
$runningCount = count(array_filter($programs, fn (MotoCareProgram $program): bool => $program->getStatus() === 'Berjalan'));
$completedCount = count(array_filter($programs, fn (MotoCareProgram $program): bool => $program->getStatus() === 'Selesai'));
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Dashboard program prioritas perawatan motor MotoCare." />
    <title><?= escapeHtml($pageTitle) ?> | <?= escapeHtml($workspaceName) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="app-shell">
      <aside class="sidebar">
        <a class="brand" href="#beranda" aria-label="<?= escapeHtml($workspaceName) ?> beranda">
          <span class="brand-mark">M</span>
          <span class="brand-name">Moto<span>Care</span></span>
        </a>

        <p class="sidebar-label">WORKSPACE</p>
        <nav class="sidebar-nav" aria-label="Navigasi utama">
          <a class="nav-item" href="#beranda"><span class="nav-icon">⌂</span>Dashboard</a>
          <a class="nav-item active" href="#program"><span class="nav-icon">▦</span>Program prioritas</a>
          <a class="nav-item" href="#ringkasan"><span class="nav-icon">▤</span>Ringkasan</a>
        </nav>

        <div class="sidebar-bottom">
          <div class="workspace-card">
            <span class="workspace-avatar">K15</span>
            <span><strong><?= escapeHtml($ownerName) ?></strong><small>Workspace aktif</small></span>
            <span class="workspace-menu" aria-hidden="true">···</span>
          </div>
          <p class="sidebar-footnote">Week 6 <span>·</span> PHP OOP</p>
        </div>
      </aside>

      <main id="beranda" class="main-content">
        <header class="topbar">
          <div class="breadcrumb"><span><?= escapeHtml($workspaceName) ?></span><b>/</b><?= escapeHtml($pageTitle) ?></div>
          <div class="profile">
            <span class="online-dot" aria-hidden="true"></span>
            <span class="profile-avatar">K</span>
            <span class="profile-name"><?= escapeHtml($ownerName) ?></span>
            <span class="profile-chevron" aria-hidden="true">⌄</span>
          </div>
        </header>

        <section id="ringkasan" class="intro">
          <div>
            <p class="eyebrow"><span></span>PERENCANAAN TIM <b>/</b> <?= escapeHtml(strtoupper($periodLabel)) ?></p>
            <h1><?= escapeHtml($pageTitle) ?><span class="title-period">.</span></h1>
            <p class="intro-copy">Prioritaskan program perawatan dan pantau progresnya dalam satu tampilan.</p>
          </div>
          <div class="period-select"><span class="calendar-icon">▦</span><?= escapeHtml($periodLabel) ?><span class="select-chevron">⌄</span></div>
        </section>

        <section class="summary-grid" aria-label="Ringkasan program">
          <article class="summary-card">
            <div class="summary-top"><span>Total program</span><span class="summary-icon blue-icon">▦</span></div>
            <strong><?= $programCount ?></strong>
            <small>Program terdaftar</small>
          </article>
          <article class="summary-card">
            <div class="summary-top"><span>Sedang berjalan</span><span class="summary-icon orange-icon">↗</span></div>
            <strong><?= $runningCount ?></strong>
            <small>Program dalam pengerjaan</small>
          </article>
          <article class="summary-card">
            <div class="summary-top"><span>Selesai</span><span class="summary-icon green-icon">✓</span></div>
            <strong><?= $completedCount ?></strong>
            <small>Program telah diselesaikan</small>
          </article>
        </section>

        <section id="program" class="program-section">
          <div class="section-heading">
            <div>
              <h2>Daftar program</h2>
              <p>Daftar program prioritas untuk membantu motor tetap terawat.</p>
            </div>
            <span class="program-count"><?= $programCount ?> program</span>
          </div>

          <div class="program-grid">
            <?php foreach ($programs as $index => $program): ?>
              <?php $progress = $program->getProgress(); ?>
              <article class="program-card">
                <div class="card-topline">
                  <span class="program-number"><?= escapeHtml(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                  <span class="program-code"><?= escapeHtml($program->getCode()) ?></span>
                  <span class="priority-badge <?= escapeHtml($program->getPriorityClass()) ?>">
                    <span aria-hidden="true">●</span>Prioritas <?= escapeHtml($program->getPriority()) ?>
                  </span>
                </div>

                <div class="program-title-row">
                  <div class="program-symbol" aria-hidden="true"><?= escapeHtml(substr($program->getTitle(), 0, 1)) ?></div>
                  <div>
                    <p class="program-category"><?= escapeHtml($program->getCategory()) ?></p>
                    <h3><?= escapeHtml($program->getTitle()) ?></h3>
                  </div>
                </div>
                <p class="program-description"><?= escapeHtml($program->getDescription()) ?></p>

                <div class="progress-heading">
                  <span>Progres</span>
                  <strong><?= $progress ?>%</strong>
                </div>
                <div class="progress-track" role="progressbar" aria-label="Progres <?= escapeHtml($program->getTitle()) ?>" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= $progress ?>">
                  <span style="width: <?= $progress ?>%"></span>
                </div>

                <div class="card-footer">
                  <span class="status-badge <?= escapeHtml($program->getStatusClass()) ?>">
                    <span aria-hidden="true"></span><?= escapeHtml($program->getStatus()) ?>
                  </span>
                  <div class="card-meta"><span>Target</span><strong><?= escapeHtml($program->getDeadline()) ?></strong></div>
                  <div class="team-avatar" title="<?= escapeHtml($program->getTeam()) ?>"><?= escapeHtml(substr($program->getTeam(), 0, 1)) ?></div>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        </section>
        <footer class="page-footer">© <?= date('Y') ?> <?= escapeHtml($workspaceName) ?> <span>·</span> Dikelola oleh <?= escapeHtml($ownerName) ?></footer>
      </main>
    </div>
    <script>
      const sidebarLinks = document.querySelectorAll('.sidebar-nav .nav-item');

      sidebarLinks.forEach((link) => {
        link.addEventListener('click', () => {
          sidebarLinks.forEach((item) => item.classList.remove('active'));
          link.classList.add('active');
        });
      });
    </script>
  </body>
</html>
