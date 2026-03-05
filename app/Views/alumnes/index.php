<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

<form method="get" action="<?= current_url() ?>">
<div class="px-3 pt-2 pb-1 border-bottom-lila bg-white">
<div class="row align-items-end">

<div class="col-12 col-xl-9">
<div class="row g-3">

<div class="col-12 col-md-6 col-xl-3">
<label class="form-label mb-1">Any</label>

<?php
$anyActual = date('Y');
$anyInici = 2000;
$anySeleccionat = $filtres['any'] ?? '';
?>

<select name="any" class="form-select">
<option value="">Tots</option>

<?php for ($i = $anyInici; $i <= $anyActual; $i++): ?>
<option value="<?= $i ?>" <?= $anySeleccionat == $i ? 'selected' : '' ?>>
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
<option value="Informàtica" <?= ($filtres['familia'] ?? '') === 'Informàtica' ? 'selected' : '' ?>>Informàtica i Comunicacions</option>
<option value="Transport" <?= ($filtres['familia'] ?? '') === 'Transport' ? 'selected' : '' ?>>Transport i Manteniment de Vehicles</option>
<option value="Arts" <?= ($filtres['familia'] ?? '') === 'Arts' ? 'selected' : '' ?>>Arts Gràfiques i Continguts Multimèdia</option>
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
<option value="pagat" <?= ($filtres['pagament'] ?? '') === 'pagat' ? 'selected' : '' ?>>Pagat</option>
<option value="pendent" <?= ($filtres['pagament'] ?? '') === 'pendent' ? 'selected' : '' ?>>No pagat</option>
</select>
</div>

</div>
</div>

<div class="col-12 col-xl-3 d-flex gap-2 justify-content-xl-end mt-3 mt-xl-0">
<button type="submit" class="btn btn-outline-primary">Filtrar</button>
<a href="<?= current_url() ?>" class="btn btn-outline-secondary">Netejar</a>
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
<th>Estudi / Curs</th>
<th>Estat</th>
<th>Pagament</th>
</tr>
</thead>

<tbody>
<?php foreach ($alumnes as $alumne): ?>

<tr>

<td>
<input type="radio" name="alumne_id" value="<?= esc($alumne['id_alumne']) ?>">
</td>

<td><?= esc($alumne['nom']) ?></td>

<td>
<?= esc($alumne['cognom1']) ?>
<?= esc($alumne['cognom2']) ?>
</td>

<td><?= esc($alumne['dni']) ?></td>

<td>
<?= esc($alumne['estudi'] ?? '') ?>
/
<?= esc($alumne['curs'] ?? '') ?>
</td>

<td><?= esc($alumne['estat']) ?></td>

<td class="<?= !empty($alumne['data_pagament']) ? 'text-success' : 'text-danger' ?>">
<?= !empty($alumne['data_pagament']) ? 'Pagat' : 'No pagat' ?>
</td>

</tr>

<?php endforeach; ?>
</tbody>

</table>

</main>
</div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {

function seleccionat() {
return document.querySelector('input[name="alumne_id"]:checked');
}

document.getElementById('btnVeureExpedient').onclick = function() {
const s = seleccionat();
if (!s) return alert('Selecciona un alumne primer');
window.location.href = "<?= base_url('alumnes/expedient') ?>/" + s.value;
};

document.getElementById('btnContactar').onclick = function() {
const s = seleccionat();
if (!s) return alert('Selecciona un alumne primer');
window.location.href = "<?= base_url('alumnes/contacte') ?>/" + s.value;
};

});

</script>

<?= view('layouts/footer') ?>