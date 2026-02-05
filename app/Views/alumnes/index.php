<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid vh-100 d-flex flex-column">

  <form method="get" action="<?= base_url('alumnes') ?>">
    <div class="px-3 pt-2 pb-1 border-bottom-lila bg-white">
      <div class="row align-items-end">

        <div class="col-12 col-xl-9">
          <div class="row g-3">

            <div class="col-12 col-md-6 col-xl-3">
              <label class="form-label mb-1">Any</label>
              <select name="any" class="form-select">
                <option value="">Tots</option>
                <?php for ($i = 2017; $i <= 2026; $i++): ?>
                  <option value="<?= $i ?>" <?= ($filtres['any'] ?? '') == $i ? 'selected' : '' ?>>
                    <?= $i ?>
                  </option>
                <?php endfor; ?>
              </select>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
              <label class="form-label mb-1">Estudi</label>
              <select name="estudi" class="form-select">
                <option value="">Tots</option>
                <option value="ESO" <?= ($filtres['estudi'] ?? '') === 'ESO' ? 'selected' : '' ?>>ESO</option>
                <option value="BAT" <?= ($filtres['estudi'] ?? '') === 'BAT' ? 'selected' : '' ?>>Batxillerat</option>
                <option value="FP" <?= ($filtres['estudi'] ?? '') === 'FP' ? 'selected' : '' ?>>FP</option>
                <option value="PFI" <?= ($filtres['estudi'] ?? '') === 'PFI' ? 'selected' : '' ?>>PFI</option>
                <option value="FPB" <?= ($filtres['estudi'] ?? '') === 'FPB' ? 'selected' : '' ?>>FP Bàsica</option>
              </select>
            </div>

            <div class="col-12 col-md-3 col-xl-2">
              <label class="form-label mb-1">Curs</label>
              <select name="curs" class="form-select">
                <option value="">Tots</option>
                <option value="1" <?= ($filtres['curs'] ?? '') === '1' ? 'selected' : '' ?>>1r</option>
                <option value="2" <?= ($filtres['curs'] ?? '') === '2' ? 'selected' : '' ?>>2n</option>
                <option value="3" <?= ($filtres['curs'] ?? '') === '3' ? 'selected' : '' ?>>3r</option>
                <option value="4" <?= ($filtres['curs'] ?? '') === '4' ? 'selected' : '' ?>>4t</option>
              </select>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
              <label class="form-label mb-1">Família</label>
              <select name="familia" class="form-select">
                <option value="">Totes</option>
                <option value="Informàtica" <?= ($filtres['familia'] ?? '') === 'Informàtica' ? 'selected' : '' ?>>
                  Informàtica i Comunicacions
                </option>
                <option value="Transport" <?= ($filtres['familia'] ?? '') === 'Transport' ? 'selected' : '' ?>>
                  Transport i Manteniment de Vehicles
                </option>
                <option value="Arts" <?= ($filtres['familia'] ?? '') === 'Arts' ? 'selected' : '' ?>>
                  Arts Gràfiques i Continguts Multimèdia
                </option>
              </select>
            </div>

            <div class="col-12 col-md-6 col-xl-4">
              <label class="form-label mb-1">Cicle</label>
              <select name="cicle" class="form-select">
                <option value="">Tots</option>
                <option value="SMX" <?= ($filtres['cicle'] ?? '') === 'SMX' ? 'selected' : '' ?>>SMX</option>
                <option value="DAM" <?= ($filtres['cicle'] ?? '') === 'DAM' ? 'selected' : '' ?>>DAM</option>
                <option value="DAW" <?= ($filtres['cicle'] ?? '') === 'DAW' ? 'selected' : '' ?>>DAW</option>
                <option value="Automocio" <?= ($filtres['cicle'] ?? '') === 'Automocio' ? 'selected' : '' ?>>Automoció</option>
              </select>
            </div>

            <div class="col-12 col-md-3 col-xl-2">
              <label class="form-label mb-1">Estat</label>
              <select name="estat" class="form-select">
                <option value="">Tots</option>
                <option value="Validat" <?= ($filtres['estat'] ?? '') === 'Validat' ? 'selected' : '' ?>>Validat</option>
                <option value="Pendent" <?= ($filtres['estat'] ?? '') === 'Pendent' ? 'selected' : '' ?>>Pendent</option>
              </select>
            </div>

            <div class="col-12 col-md-3 col-xl-2">
              <label class="form-label mb-1">Pagament</label>
              <select name="pagament" class="form-select">
                <option value="">Tots</option>
                <option value="Pagat" <?= ($filtres['pagament'] ?? '') === 'Pagat' ? 'selected' : '' ?>>Pagat</option>
                <option value="No pagat" <?= ($filtres['pagament'] ?? '') === 'No pagat' ? 'selected' : '' ?>>No pagat</option>
              </select>
            </div>

          </div>
        </div>

        <div class="col-12 col-xl-3 d-flex gap-2 justify-content-xl-end mt-3 mt-xl-0">
          <button type="submit" class="btn btn-outline-primary">Filtrar</button>
          <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary">Netejar</a>
          <button type="button" id="btnVeureExpedient" class="btn btn-outline-primary">Veure expedient</button>
          <button type="button" id="btnContactar" class="btn btn-outline-secondary">Contactar</button>
        </div>

      </div>
    </div>
  </form>

  <div class="row flex-grow-1 g-0 mt-3">


    <?= view('layouts/aside') ?>

    <main class="col-10 pt-0 px-3 overflow-auto">

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
          <?php foreach ($alumnes as $alumne): ?>
            <tr>
              <td><input type="radio" name="alumne_id" value="<?= esc($alumne['id_alumne']) ?>"></td>
              <td><?= esc($alumne['nom']) ?></td>
              <td><?= esc($alumne['cognoms']) ?></td>
              <td><?= esc($alumne['dni']) ?></td>
              <td><?= esc($alumne['estudi']) ?> / <?= esc($alumne['curs']) ?></td>
              <td><?= esc($alumne['estat']) ?></td>
              <td class="<?= $alumne['pagament'] === 'Pagat' ? 'text-success' : 'text-danger' ?>">
              <?= esc($alumne['pagament']) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </main>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

  function seleccionat() {
    return document.querySelector('input[name="alumne_id"]:checked');
  }

  document.getElementById('btnVeureExpedient').onclick = function () {
    const s = seleccionat();
    if (!s) return alert('Selecciona un alumne primer');
    window.location.href = "<?= base_url('alumnes/expedient') ?>/" + s.value;
  };

  document.getElementById('btnContactar').onclick = function () {
    const s = seleccionat();
    if (!s) return alert('Selecciona un alumne primer');
    window.location.href = "<?= base_url('alumnes/contacte') ?>/" + s.value;
  };

});
</script>

<?= view('layouts/footer') ?>
