<div class="d-flex align-items-center px-3 border-bottom bg-light" style="height: 90px;">
  <div class="d-flex align-items-center gap-3">
    <a href="<?= base_url('alumnes') ?>">
      <img src="<?= base_url('logo.png') ?>" alt="Logo" style="height: 120px">
    </a>
  </div>

  <div class="flex-grow-1 text-center">
    <form method="get" action="<?= current_url() ?>" class="d-inline-flex gap-2">
      <input
        type="text"
        name="cerca"
        class="form-control"
        style="width: 360px"
        placeholder="Cerca per nom, cognoms o DNI..."
        value="<?= esc($_GET['cerca'] ?? '') ?>" />
      <button type="submit" class="btn btn-outline-primary">
        Cercar
      </button>
    </form>
  </div>

  <div>
    <a href="<?= base_url('perfil') ?>" class="me-2 fw-semibold text-dark text-decoration-none">
      <?= esc(session()->get('usuari')) ?>
    </a>
    <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-outline-secondary">
      Sortir
    </a>
  </div>

</div>