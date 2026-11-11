<?php
declare(strict_types=1);

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function formatProgramDate(string $value): string
{
    $timestamp = strtotime($value);

    return $timestamp === false ? $value : date('d M Y, H:i', $timestamp);
}
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Kelola program prioritas perawatan motor MotoCare." />
    <title><?= escapeHtml($pageTitle) ?> | <?= escapeHtml($workspaceName) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="program-prioritas.css" />
  </head>
  <body>
    <div class="app-shell">
      <aside class="sidebar">
        <a class="brand" href="index.php#beranda" aria-label="MotoCare beranda">
          <span class="brand-mark">M</span>
          <span class="brand-name">Moto<span>Care</span></span>
        </a>

        <p class="sidebar-label">WORKSPACE</p>
        <nav class="sidebar-nav" aria-label="Navigasi utama">
          <a class="nav-item" href="index.php#beranda"><span class="nav-icon">⌂</span>Dashboard</a>
          <a class="nav-item active" href="#program" aria-current="page"><span class="nav-icon">▦</span>Program prioritas</a>
          <a class="nav-item" href="program-prioritas.php"><span class="nav-icon">↻</span>Perawatan motor</a>
        </nav>

        <div class="sidebar-bottom">
          <div class="workspace-card">
            <span class="workspace-avatar">K15</span>
            <span><strong><?= escapeHtml($ownerName) ?></strong><small>Workspace aktif</small></span>
            <span class="workspace-menu" aria-hidden="true">···</span>
          </div>
          <p class="sidebar-footnote">MotoCare <span>·</span> PHP + MySQL</p>
        </div>
      </aside>

      <main id="beranda" class="main-content">
        <header class="topbar">
          <div class="breadcrumb"><a href="index.php">MotoCare</a><b>/</b><?= escapeHtml($pageTitle) ?></div>
          <div class="profile">
            <span class="online-dot" aria-hidden="true"></span>
            <span class="profile-avatar">K</span>
            <span class="profile-name"><?= escapeHtml($ownerName) ?></span>
          </div>
        </header>

        <section id="ringkasan" class="intro">
          <div>
            <p class="eyebrow"><span></span>PROGRAM PERAWATAN <b>/</b> MotoCare</p>
            <h1><?= escapeHtml($pageTitle) ?><span class="title-period">.</span></h1>
            <p class="intro-copy">Catat, tampilkan, ubah, dan hapus program perawatan motor.</p>
          </div>
          <div class="period-select"><span class="calendar-icon">▦</span><?= $programCount ?> program tersimpan</div>
        </section>

        <?php if ($errorMessage !== null): ?>
          <div class="program-alert error-alert" role="alert"><?= escapeHtml($errorMessage) ?></div>
        <?php endif; ?>
        <?php if ($successMessage !== null): ?>
          <div class="program-alert success-alert" role="status"><?= escapeHtml($successMessage) ?></div>
        <?php endif; ?>

        <section class="summary-grid" aria-label="Ringkasan database program">
          <article class="summary-card">
            <div class="summary-top"><span>Total program</span><span class="summary-icon blue-icon">▦</span></div>
            <strong><?= $programCount ?></strong>
            <small>Data tersimpan di database</small>
          </article>
          <article class="summary-card">
            <div class="summary-top"><span>Terakhir diperbarui</span><span class="summary-icon green-icon">↻</span></div>
            <strong class="summary-date"><?= $latestUpdatedAt === null ? '—' : escapeHtml(formatProgramDate($latestUpdatedAt)) ?></strong>
            <small><?= $latestUpdatedAt === null ? 'Belum ada aktivitas' : 'Waktu pembaruan terbaru' ?></small>
          </article>
          <article class="summary-card">
            <div class="summary-top"><span>Sumber data</span><span class="summary-icon orange-icon">DB</span></div>
            <strong class="summary-date">MySQL</strong>
            <small>Bukan data hard-code</small>
          </article>
        </section>

        <section class="program-section" aria-labelledby="create-program-title">
          <div class="section-heading">
            <div>
              <h2 id="create-program-title">Tambah program</h2>
              <p>Program baru akan disimpan ke database MotoCare.</p>
            </div>
          </div>
          <form class="program-form" method="post">
            <input type="hidden" name="csrf_token" value="<?= escapeHtml($csrfToken) ?>" />
            <input type="hidden" name="action" value="create" />
            <label>
              <span>Nama program</span>
              <input name="nama" type="text" maxlength="120" placeholder="Contoh: Pengingat servis berkala" required />
            </label>
            <label>
              <span>Deskripsi</span>
              <textarea name="deskripsi" rows="3" maxlength="2000" placeholder="Jelaskan tujuan atau manfaat program" required></textarea>
            </label>
            <button class="program-button primary-button" type="submit">+ Tambah program</button>
          </form>
        </section>

        <section id="program" class="program-section" aria-labelledby="program-list-title">
          <div class="section-heading">
            <div>
              <h2 id="program-list-title">Daftar program MotoCare</h2>
              <p>Data pada daftar ini dibaca langsung dari tabel <code>programs</code>.</p>
            </div>
            <span class="program-count"><?= $programCount ?> program</span>
          </div>

          <?php if ($programs === []): ?>
            <div class="program-empty">Belum ada program. Tambahkan program pertama menggunakan formulir di atas.</div>
          <?php else: ?>
            <div class="program-grid">
              <?php foreach ($programs as $index => $program): ?>
                <article class="program-card">
                  <div class="card-topline">
                    <span class="program-number"><?= escapeHtml(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                    <span class="program-code">ID <?= $program->getId() ?></span>
                    <span class="program-count">Program MotoCare</span>
                  </div>
                  <div class="program-title-row">
                    <div class="program-symbol" aria-hidden="true"><?= escapeHtml(mb_strtoupper(mb_substr($program->getName(), 0, 1))) ?></div>
                    <div>
                      <p class="program-category">Program perawatan</p>
                      <h3><?= escapeHtml($program->getName()) ?></h3>
                    </div>
                  </div>
                  <p class="program-description"><?= escapeHtml($program->getDescription()) ?></p>
                  <div class="program-dates">
                    <span>Dibuat <?= escapeHtml(formatProgramDate($program->getCreatedAt())) ?></span>
                    <span>Diperbarui <?= escapeHtml(formatProgramDate($program->getUpdatedAt())) ?></span>
                  </div>
                  <details class="program-edit">
                    <summary>Edit program</summary>
                    <form class="program-form edit-form" method="post">
                      <input type="hidden" name="csrf_token" value="<?= escapeHtml($csrfToken) ?>" />
                      <input type="hidden" name="action" value="update" />
                      <input type="hidden" name="id" value="<?= $program->getId() ?>" />
                      <label>
                        <span>Nama program</span>
                        <input name="nama" type="text" maxlength="120" value="<?= escapeHtml($program->getName()) ?>" required />
                      </label>
                      <label>
                        <span>Deskripsi</span>
                        <textarea name="deskripsi" rows="3" maxlength="2000" required><?= escapeHtml($program->getDescription()) ?></textarea>
                      </label>
                      <button class="program-button primary-button" type="submit">Simpan perubahan</button>
                    </form>
                  </details>
                  <form class="delete-form" method="post" onsubmit="return confirm('Yakin ingin menghapus program ini?')">
                    <input type="hidden" name="csrf_token" value="<?= escapeHtml($csrfToken) ?>" />
                    <input type="hidden" name="action" value="delete" />
                    <input type="hidden" name="id" value="<?= $program->getId() ?>" />
                    <button class="program-button delete-button" type="submit">Hapus program</button>
                  </form>
                </article>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>
        <footer class="page-footer">© <?= date('Y') ?> <?= escapeHtml($workspaceName) ?> <span>·</span> Data program dikelola di database.</footer>
      </main>
    </div>
  </body>
</html>
