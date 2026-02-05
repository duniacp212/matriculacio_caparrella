<?= view('layouts/header', ['title' => $title]) ?>


<div class="container-fluid vh-100 d-flex flex-column">
  <div class="row flex-grow-1 g-0">
    <?= view('layouts/aside') ?>

   <main class="col-10 p-3 overflow-auto">
    <div class="px-3 py-3 border-bottom bg-white mb-3">
  <h5 class="fw-semibold mb-3">Filtres</h5>
  <p class="text-muted mb-0">
    Aquí aniran els filtres (any, estudi, curs, estat, pagament…)
  </p>
</div>


  <table class="table table-bordered table-hover bg-white">
    <thead class="table-light">
      <tr>
        <th></th>
        <th>Nom</th>
        <th>Cognoms</th>
        <th>DNI</th>
        <th>Estudi / Curs / Cicle</th>
        <th>Estat</th>
        <th>Pagament</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td><input type="radio"></td>
        <td>Anna</td>
        <td>Martí Puig</td>
        <td>12345678A</td>
        <td>ESO / 2</td>
        <td>Validat</td>
        <td class="text-success">Pagat</td>
      </tr>

      <tr>
        <td><input type="radio"></td>
        <td>Marc</td>
        <td>Roca Vidal</td>
        <td>23456789B</td>
        <td>FP / GM / SMX</td>
        <td>Pendent</td>
        <td class="text-danger">No pagat</td>
      </tr>

      <tr>
        <td><input type="radio"></td>
        <td>Laia</td>
        <td>Serra Colom</td>
        <td>34567890C</td>
        <td>ESO / 1</td>
        <td>Validat</td>
        <td class="text-success">Pagat</td>
      </tr>
    </tbody>
  </table>

</main>

  </div>
</div>

<?= view('layouts/footer') ?>
