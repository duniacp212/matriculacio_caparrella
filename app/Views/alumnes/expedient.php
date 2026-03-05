<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<main class="container-fluid p-4 overflow-auto">
  <div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">

      <h5 class="mb-4 fw-semibold text-center">
        <?= esc($alumne['nom']) ?>
        <?= esc($alumne['cognom1']) ?>
        <?= esc($alumne['cognom2']) ?>
        · DNI <?= esc($alumne['dni']) ?>
      </h5>

      <div class="accordion mb-4 card-lila" id="accordionExpedient">

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#dadesPersonals">
              Dades personals
            </button>
          </h2>
          <div id="dadesPersonals" class="accordion-collapse collapse show">
            <div class="accordion-body">
              <div class="row g-3">
                <div class="col-md-4">
                  <label class="form-label">Nom</label>
                  <input class="form-control" value="<?= esc($alumne['nom']) ?>" disabled>
                </div>
                <div class="col-md-5">
                  <label class="form-label">Cognoms</label>
                  <input class="form-control" value="<?= esc($alumne['cognom1']) ?> <?= esc($alumne['cognom2']) ?>" disabled>
                </div>
                <div class="col-md-3">
                  <label class="form-label">DNI</label>
                  <input class="form-control" value="<?= esc($alumne['dni']) ?>" disabled>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Data de naixement</label>
                  <input class="form-control"
                         value="<?= esc(date('d/m/Y', strtotime($alumne['data_naixement']))) ?>"
                         disabled>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Telèfon</label>
                  <input class="form-control" value="<?= esc($alumne['telefon']) ?>" disabled>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Correu electrònic</label>
                  <input class="form-control" value="<?= esc($alumne['email']) ?>" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#dadesAcademiques">
              Dades acadèmiques
            </button>
          </h2>
          <div id="dadesAcademiques" class="accordion-collapse collapse">
            <div class="accordion-body">
              <ul class="mb-0">
                <li><strong>Any matrícula:</strong> <?= esc($alumne['any_matricula']) ?></li>
                <li><strong>Estudi:</strong> <?= esc($alumne['tipus']) ?></li>
                <li><strong>Curs:</strong> <?= esc($alumne['nivell']) ?></li>
                <li><strong>Estat:</strong> <?= esc($alumne['estat']) ?></li>
                <li><strong>Torn:</strong> <?= esc($alumne['torn']) ?></li>
              </ul>
            </div>
          </div>
        </div>

      </div>

      <div class="d-flex justify-content-end gap-2">
        <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary">
          Tornar
        </a>
      </div>

    </div>
  </div>
</main>

<?= view('layouts/footer') ?>