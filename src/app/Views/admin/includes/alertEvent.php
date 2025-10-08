<!-- Mensajes de éxito o error -->
<?php
// Mostrar alerta de éxito si existe
if (isset($_SESSION['exito'])) {
echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="autoCloseAlert">
            <i class="ri-check-line me-1 align-middle font-16"></i> ' .htmlspecialchars($_SESSION['exito']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
unset($_SESSION['exito']);
}

// Mostrar alerta de error si existe
if (isset($_SESSION['error'])) {
echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="autoCloseAlert">
    <i class="ri-close-line me-1 align-middle font-16"></i> ' .htmlspecialchars($_SESSION['error']) . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
unset($_SESSION['error']);
}
?>


<!-- Controldador de alerta -->
<script>
// Ocultar automáticamente después de 2 segundos
document.addEventListener('DOMContentLoaded', function() {
    const alert = document.getElementById('autoCloseAlert');
    if (alert) {
        setTimeout(() => {
            const bootstrapAlert = new bootstrap.Alert(alert);
            bootstrapAlert.close();
        }, 3000);
    }
});
</script>