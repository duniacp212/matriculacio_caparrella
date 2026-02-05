<aside class="col-2 bg-secondary-subtle p-3 border-end">
  <ul class="list-unstyled">

    <li>
      <a
        class="text-dark d-flex justify-content-between align-items-center text-decoration-none py-1 fw-semibold"
        href="<?= base_url('/') ?>"
      >
        Alumnes / Expedients
      </a>
    </li>

    <li class="py-2">
      <a
        class="fw-semibold text-dark d-flex justify-content-between align-items-center text-decoration-none"
        data-bs-toggle="collapse"
        href="#menuMatricules"
      >
        Matrícules <span>▾</span>
      </a>

      <ul class="list-unstyled ps-3 collapse" id="menuMatricules">
        <li>
          <a class="text-dark text-decoration-none py-1 d-block"
             href="<?= base_url('matricules/torn1') ?>">
            Torn 1
          </a>
        </li>
        <li>
          <a class="text-dark text-decoration-none py-1 d-block"
             href="<?= base_url('matricules/torn2') ?>">
            Torn 2
          </a>
        </li>
        <li>
          <a class="text-dark text-decoration-none py-1 d-block"
             href="<?= base_url('matricules/torn3') ?>">
            Torn 3
          </a>
        </li>
      </ul>
    </li>

    <li class="py-2 mt-3">
      <a
        class="fw-semibold text-dark d-flex justify-content-between align-items-center text-decoration-none"
        data-bs-toggle="collapse"
        href="#menuPagaments"
      >
        Pagaments / Bonificacions <span>▾</span>
      </a>

      <ul class="list-unstyled ps-3 collapse" id="menuPagaments">
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('pagaments/pagats') ?>">Pagats</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('pagaments/no-pagats') ?>">No pagats</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('pagaments/bonificats') ?>">Bonificats</a></li>
      </ul>
    </li>

    <li class="mt-2">
      <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
         href="<?= base_url('pagaments/resum') ?>">
        Alumnes matriculats
      </a>
    </li>

    <li class="py-2 mt-3">
      <a
        class="fw-semibold text-dark d-flex justify-content-between align-items-center text-decoration-none"
        data-bs-toggle="collapse"
        href="#menuGestioCursos"
      >
        Gestió de cursos <span>▾</span>
      </a>

      <ul class="list-unstyled ps-3 collapse" id="menuGestioCursos">
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/eso') ?>">ESO</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/batxillerat') ?>">Batxillerat</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/fp-gm') ?>">FP Grau Mitjà</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/fp-gs') ?>">FP Grau Superior</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/fp-basica') ?>">FP Bàsica</a></li>
        <li><a class="text-dark text-decoration-none py-1 d-block" href="<?= base_url('gestio/pfi') ?>">PFI</a></li>
      </ul>
    </li>

    <li class="mt-2">
      <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
         href="<?= base_url('matricula-viva') ?>">
        Matrícula viva
      </a>
    </li>

    <li>
      <a class="fw-semibold text-dark text-decoration-none py-1 d-block"
         href="<?= base_url('usuaris') ?>">
        Gestió d’usuaris administratius
      </a>
    </li>

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
