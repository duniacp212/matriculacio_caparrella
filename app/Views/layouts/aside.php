<?php $config_ui = model('App\Models\SettingsModel')->getSettings(); ?>
<aside class="col-2 bg-secondary-subtle p-3 border-end">
  <ul class="list-unstyled">

    <li class="py-2">
      <a
        class="fw-semibold text-dark text-decoration-none d-block"
        href="<?= base_url('/') ?>"
      >
        Alumnes / Matrícules
      </a>
    </li>

    <?php if ($config_ui['menu_alumnes_matriculats'] ?? true): ?>
    <li class="mt-2">
      <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
         href="<?= base_url('alumnes/resum_matriculats') ?>">
        Alumnes matriculats
      </a>
    </li>
    <?php endif; ?>

    <?php if ($config_ui['menu_gestio_cursos'] ?? true): ?>
    <li class="py-2 mt-3">
      <div class="d-flex justify-content-between align-items-center">
        <a
          class="fw-semibold text-dark text-decoration-none"
          href="#"
        >
          Gestió de cursos
        </a>

        <a
          class="text-dark text-decoration-none"
          data-bs-toggle="collapse"
          href="#menuGestioCursos"
          role="button"
        >
          ▾
        </a>
      </div>

      <ul class="list-unstyled ps-3 collapse" id="menuGestioCursos">
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/eso') ?>">ESO</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/batxillerat') ?>">Batxillerat</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/fp-gm') ?>">FP Grau Mitjà</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/fp-gs') ?>">FP Grau Superior</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/fp-basica') ?>">FP Bàsica</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/pfi') ?>">PFI</a></li>
      </ul>
    </li>
    <?php endif; ?>

    <?php if ($config_ui['menu_matricula_viva'] ?? true): ?>
    <li class="mt-2">
      <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
         href="<?= base_url('matricula-viva') ?>">
        Matrícula viva
      </a>
    </li>
    <?php endif; ?>

    <?php if ($config_ui['menu_usuaris'] ?? true): ?>
    <li>
      <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
         href="<?= base_url('usuaris') ?>">
        Gestió d’usuaris administratius
      </a>
    </li>
    <?php endif; ?>

    <li>
      <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
         href="<?= base_url('configuracio') ?>">
        Configuració
      </a>
    </li>

  </ul>

  <div class="mt-4">
    <a href="<?= base_url('matricules/nova') ?>"
       class="btn btn-success w-100">
      Nova matrícula
    </a>
  </div>
</aside>