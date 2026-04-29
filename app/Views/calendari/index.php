<?= view('layouts/header', ['title' => $title]) ?>
<?= view('layouts/topbar') ?>

<div class="container-fluid d-flex flex-column min-vh-100">

    <div class="px-3 pt-2 pb-1 bg-white">
        <div class="row align-items-center">
            <div class="col-12">
                 <h4 class="mb-0"><?= esc($title) ?></h4>
            </div>
        </div>
    </div>

    <div class="row flex-grow-1 g-0 mt-3">

        <main class="col-12 pt-0 px-3 overflow-auto">

            <div class="d-flex justify-content-start mb-3">
                <a href="<?= base_url('alumnes') ?>" class="btn btn-outline-secondary btn-sm px-4">Tornar</a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div id="calendari"></div>
                </div>
            </div>

        </main>
    </div>
</div>

<div class="modal fade" id="modalTasca" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova tasca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Títol</label>
                    <input type="text" id="titol" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripció</label>
                    <textarea id="descripcio" class="form-control" rows="3"></textarea>
                </div>
                <input type="hidden" id="data">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
                <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVeureTasca" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitol"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="modalDescripcio" class="text-muted"></p>
                <p id="modalHora" class="text-muted small"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tancar</button>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calEl = document.getElementById('calendari');
        let tascaId = null;
        const modalTasca = new bootstrap.Modal(document.getElementById('modalTasca'));
        const modalVeureTasca = new bootstrap.Modal(document.getElementById('modalVeureTasca'));

        const cal = new FullCalendar.Calendar(calEl, {
            initialView: 'dayGridMonth',
            locale: 'ca',
            firstDay: 1,
            buttonText: { today: 'Avui', month: 'Mes', list: 'Llista' },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            events: '<?= base_url('calendari/events') ?>',
            dateClick: function(info) {
                document.getElementById('data').value = info.dateStr;
                document.getElementById('titol').value = '';
                document.getElementById('descripcio').value = '';
                modalTasca.show();
            },
            eventClick: function(info) {
                tascaId = info.event.id;
                document.getElementById('modalTitol').textContent = info.event.title;
                document.getElementById('modalDescripcio').textContent = info.event.extendedProps.description || '';
                document.getElementById('modalHora').textContent = 'Creat el: ' + info.event.extendedProps.createdAt;
                modalVeureTasca.show();
            }
        });

        cal.render();

        document.getElementById('btnGuardar').addEventListener('click', function() {
            const titol = document.getElementById('titol').value;
            const descripcio = document.getElementById('descripcio').value;
            const data = document.getElementById('data').value;

            if (!titol) { alert('El títol és obligatori'); return; }

            fetch('<?= base_url('calendari/guardar') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    titol: titol,
                    descripcio: descripcio,
                    data: data,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.ok) {
                    modalTasca.hide();
                    cal.refetchEvents();
                }
            });
        });

        document.getElementById('btnEliminar').addEventListener('click', function() {
            if (!confirm('Estàs segur que vols eliminar aquesta tasca?')) return;
            fetch('<?= base_url('calendari/eliminar/') ?>' + tascaId)
                .then(r => r.json())
                .then(data => {
                    if (data.ok) {
                        modalVeureTasca.hide();
                        cal.refetchEvents();
                    }
                });
        });
    });
</script>

<?= view('layouts/footer') ?>