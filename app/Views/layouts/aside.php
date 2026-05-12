<?php
$config_ui = model('App\Models\SettingsModel')->getSettings();
$rol = session()->get('rol');
?>
<aside class="col-2 bg-secondary-subtle p-3 border-end">
  <ul class="list-unstyled">

    <li class="py-2">
      <a class="fw-semibold text-dark text-decoration-none d-block" href="<?= base_url('/') ?>">
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
    <?php if ($config_ui['menu_calendari'] ?? true): ?>
      <li class="mt-2">
        <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
          href="<?= base_url('calendari') ?>">
          Calendari
        </a>
      </li>
    <?php endif; ?>

    <?php if (($config_ui['menu_serveis_complementaris'] ?? true) && in_array($rol, ['super admin', 'administracio'])): ?>
      <li class="mt-2">
        <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
          href="<?= base_url('serveis') ?>">
          Serveis complementaris
        </a>
      </li>
    <?php endif; ?>

    <?php if (($config_ui['menu_bonificacions'] ?? true) && in_array($rol, ['super admin', 'administracio'])): ?>
      <li class="mt-2">
        <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
          href="<?= base_url('bonificacions') ?>">
          Gestió de bonificacions
        </a>
      </li>
    <?php endif; ?>


    <?php if (($config_ui['menu_gestio_cursos'] ?? true) && in_array($rol, ['super admin', 'administracio'])): ?>
      <li class="py-2 mt-3">
        <div class="d-flex justify-content-between align-items-center">
          <a class="fw-semibold text-dark text-decoration-none" href="#">
            Gestió de cursos
          </a>
          <a class="text-dark text-decoration-none collapsed" data-bs-toggle="collapse" href="#menuGestioCursos" role="button" id="toggleGestioCursos">
            <span id="fletxaCursos" class="fs-5" style="transition: all 0.2s; line-height: 1;">▾</span>
          </a>
        </div>
        <ul class="list-unstyled ps-3 collapse" id="menuGestioCursos">
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              const menu = document.getElementById('menuGestioCursos');
              const fletxa = document.getElementById('fletxaCursos');
              if (menu && fletxa) {
                menu.addEventListener('show.bs.collapse', function () {
                  fletxa.textContent = '▸';
                });
                menu.addEventListener('hide.bs.collapse', function () {
                  fletxa.textContent = '▾';
                });
              }
            });
          </script>
          <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/eso') ?>">ESO</a></li>
          <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/batxillerat') ?>">Batxillerat</a></li>
          <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/fp-gm') ?>">FP Grau Mitjà</a></li>
          <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/fp-gs') ?>">FP Grau Superior</a></li>
          <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/fp-basica') ?>">FP Bàsica</a></li>
          <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/pfi') ?>">PFI</a></li>
        </ul>
      </li>
    <?php endif; ?>

    <?php if (($config_ui['menu_matricula_viva'] ?? true) && in_array($rol, ['super admin', 'administracio'])): ?>
      <li class="mt-2">
        <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
          href="<?= base_url('matricula-viva') ?>">
          Matrícula viva
        </a>
      </li>
    <?php endif; ?>

    <?php if (($config_ui['menu_usuaris'] ?? true) && in_array($rol, ['super admin', 'administracio'])): ?>
      <li>
        <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
          href="<?= base_url('usuaris') ?>">
          Gestió d'usuaris administratius
        </a>
      </li>
    <?php endif; ?>

    <?php if ($rol === 'super admin'): ?>
      <li>
        <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
          href="<?= base_url('configuracio') ?>">
          Configuració
        </a>
      </li>
    <?php endif; ?>

  </ul>

  <div class="mt-4">
    <a href="<?= base_url('matricules/nova') ?>" class="btn btn-success w-100">
      Nova matrícula
    </a>
  </div>
</aside>