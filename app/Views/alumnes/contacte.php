<?= view('layouts/header', ['title' => $title]) ?>

<div class="container-fluid vh-100 d-flex flex-column">

  <div class="d-flex align-items-center px-3 py-2 border-bottom bg-light">
    <div class="flex-grow-1 text-center fw-semibold fs-5">
      Contacte amb l’alumne
    </div>
  </div>

  <main class="container p-4 overflow-auto">
    <form action="<?= base_url('alumnes/enviar_correu/' . $alumne['id_alumne']) ?>" method="post" class="card shadow-sm card-lila p-0">
      <?= csrf_field() ?>

      <div class="card-header fw-semibold">Dades de l’alumne</div>

      <?php if (session()->getFlashdata('exit')): ?>
        <div class="alert alert-success m-3">
          <?= session()->getFlashdata('exit') ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger m-3">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <div class="card-body">
        <div class="row g-3 mb-4">

          <div class="col-md-4">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control"
              value="<?= esc($alumne['nom']) ?>" readonly>
          </div>

          <div class="col-md-4">
            <label class="form-label">Cognoms</label>
            <input type="text" class="form-control"
              value="<?= esc($alumne['cognom1']) ?> <?= esc($alumne['cognom2']) ?>" readonly>
          </div>

          <div class="col-md-4">
            <label class="form-label">DNI</label>
            <input type="text" class="form-control"
              value="<?= esc($alumne['dni']) ?>" readonly>
          </div>

          <div class="col-md-4">
            <label class="form-label">Estudi / Curs / Cicle</label>
            <input type="text" class="form-control"
              value="<?= esc($alumne['tipus']) ?> <?= esc($alumne['nivell']) ?>" readonly>
          </div>

          <div class="col-md-4">
            <label class="form-label">Correu de l’alumne</label>
            <input type="email" class="form-control"
              value="<?= esc($alumne['email']) ?>" readonly>
          </div>

          <div class="col-md-4">
            <label class="form-label">Telèfon de l’alumne</label>
            <input type="text" class="form-control"
              value="<?= esc($alumne['telefon']) ?>" readonly>
          </div>

        </div>
      </div>

      <div class="card-header fw-semibold">Missatge</div>

      <div class="card-body">
        <div class="row g-3">

          <div class="col-12">
            <label class="form-label">Motiu del contacte</label>
            <select name="motiu" class="form-select">
              <option>Informació general</option>
              <option>Matrícula</option>
              <option>Pagament</option>
              <option>Expedient</option>
              <option>Baixa</option>
              <option>Altres</option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label">Missatge</label>
            <textarea name="missatge" class="form-control" rows="5"
              placeholder="Escriu aquí el missatge que vols enviar..."></textarea>
          </div>

        </div>
      </div>

      <div class="card-footer d-flex justify-content-end gap-2">
        <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary">
          Cancel·lar
        </a>
        <button type="submit" class="btn btn-outline-primary">
          Enviar missatge
        </button>
      </div>

    </form>
  </main>
</div>

<?= view('layouts/footer') ?>