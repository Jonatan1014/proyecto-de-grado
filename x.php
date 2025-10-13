<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="utf-8" />
    <title>Starter Page | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/admin/assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="assets/admin/assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="assets/admin/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="assets/admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/admin/assets/css/unicons/css/unicons.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/remixicon/remixicon.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/mdi/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css ">

</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">


        <!-- ========== Topbar Start ========== -->
        <?php include 'includes/navbar.php'; ?>
        <!-- ========== Topbar End ========== -->
        <?php include 'includes/sidebar.php'; ?>


        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="admin">Home</a></li>
                                        <li class="breadcrumb-item"><a href="pages-get-service">Lista de
                                                Servicios</a></li>
                                        <li class="breadcrumb-item active">Editar Servicio</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Editar Servicio</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Actualizar Información</h4>
                                    <p class="text-muted font-14">
                                        Actualice a continuación los datos del <code>servicio</code> seleccionado
                                    </p>

                                    <!-- Mensajes de éxito o error -->
                                    <?php include 'includes/alertEvent.php'; ?>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="input-types-preview">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="update-service" method="POST">
                                                        <div class="row">
                                                            <!-- Primera columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nombre del
                                                                        Servicio</label>
                                                                    <input type="text" id="name" name="name"
                                                                        class="form-control" required
                                                                        value="<?php  echo htmlspecialchars($service->name); ?>"
                                                                        oninput="updatePreview()">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="description"
                                                                        class="form-label">Descripción</label>
                                                                    <textarea id="description" name="description"
                                                                        class="form-control" rows="3"
                                                                        oninput="updatePreview()"><?php echo htmlspecialchars($service->description); ?></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="category_id"
                                                                        class="form-label">Categoría</label>
                                                                    <!-- Cambiamos el 'name' y 'id' a category_id para coincidir con el controlador -->
                                                                    <select id="category_id" name="category_id"
                                                                        class="form-control" onchange="updatePreview()"
                                                                        required>
                                                                        <option value="">Seleccionar categoría</option>
                                                                        <?php foreach ($categories as $category): ?>
                                                                        <option
                                                                            value="<?php echo htmlspecialchars($category['id']); ?>"
                                                                            <?php echo (isset($service) && $service->category_id == $category['id']) ? 'selected' : ''; ?>>
                                                                            <?php echo htmlspecialchars($category['name']); ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="icon" class="form-label">Selecciona un
                                                                        Icono</label>
                                                                    <div class="row g-2" id="icon-selector">
                                                                        <!-- Iconos predefinidos -->
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-heartbeat')">
                                                                                <i class="fas fa-heartbeat fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-heart')">
                                                                                <i class="fas fa-heart fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-vials')">
                                                                                <i class="fas fa-vials fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-ambulance')">
                                                                                <i class="fas fa-ambulance fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-baby')">
                                                                                <i class="fas fa-baby fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-syringe')">
                                                                                <i class="fas fa-syringe fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-tooth')">
                                                                                <i class="fas fa-tooth fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-stethoscope')">
                                                                                <i class="fas fa-stethoscope fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-user-md')">
                                                                                <i class="fas fa-user-md fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-pills')">
                                                                                <i class="fas fa-pills fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="icon-option text-center p-2 border rounded cursor-pointer"
                                                                                onclick="selectIcon('fas fa-smile')">
                                                                                <i class="fas fa-smile fs-3"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" id="icon" name="icon"
                                                                        value="<?php echo htmlspecialchars($service->icon); ?>">
                                                                </div>
                                                            </div>
                                                            <!-- Segunda columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="duration_minutes"
                                                                        class="form-label">Duración (minutos)</label>
                                                                    <input type="number" id="duration_minutes"
                                                                        name="duration_minutes" class="form-control"
                                                                        min="1" oninput="updatePreview()"
                                                                        value="<?php echo htmlspecialchars($service->duration_minutes); ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="price" class="form-label">Precio</label>
                                                                    <input type="number" id="price" name="price"
                                                                        class="form-control" step="0.01" min="0"
                                                                        oninput="updatePreview()"
                                                                        value="<?php echo htmlspecialchars($service->price); ?>">
                                                                </div>
                                                                <div class="mb-3 form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="is_featured" name="is_featured" value="1"
                                                                        <?php echo $service->is_featured ? 'checked' : ''; ?>
                                                                        onchange="updatePreview()">
                                                                    <label class="form-check-label"
                                                                        for="is_featured">Destacado</label>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="features"
                                                                        class="form-label">Características (separadas
                                                                        por comas)</label>
                                                                    <input type="text" id="features" name="features"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars(implode(', ', json_decode($service->features))); ?>"
                                                                        placeholder="Ej: Consulta general, Examen físico, Receta médica"
                                                                        oninput="updatePreview()">
                                                                    <small class="text-muted">Separa las características
                                                                        con comas (,)</small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Previsualización en tiempo real -->
                                                        <div class="row mt-4">
                                                            <div class="col-12">
                                                                <h5>Previsualización del Servicio</h5>
                                                                <div class="card p-3">
                                                                    <div class="row g-4">
                                                                        <div class="col-lg-4 col-md-6 mx-auto">
                                                                            <div class="service-card" id="preview-card">
                                                                                <div class="service-header">
                                                                                    <div class="service-icon">
                                                                                        <i class="fas fa-tooth"
                                                                                            id="preview-icon"></i>
                                                                                    </div>
                                                                                    <span class="service-category"
                                                                                        id="preview-category">General</span>
                                                                                    <div class="featured-badge"
                                                                                        id="preview-featured"
                                                                                        style="display: none;">Destacado
                                                                                    </div>
                                                                                </div>
                                                                                <div class="service-body">
                                                                                    <h4 id="preview-name">Nombre del
                                                                                        Servicio</h4>
                                                                                    <p id="preview-description">
                                                                                        Descripción del servicio...</p>
                                                                                    <div class="service-features"
                                                                                        id="preview-features">
                                                                                        <!-- Características se insertan aquí -->
                                                                                    </div>
                                                                                </div>
                                                                                <div class="service-footer">
                                                                                    <a href="#" class="service-btn">
                                                                                        Solicitar Cita
                                                                                        <i
                                                                                            class="fas fa-arrow-right"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="btn btn-success mt-3">Actualizar
                                                            Servicio</button>
                                                    </form>

                                                    <style>
                                                    .cursor-pointer {
                                                        cursor: pointer;
                                                    }

                                                    .service-card {
                                                        border: 1px solid #dee2e6;
                                                        border-radius: 0.5rem;
                                                        padding: 1.5rem;
                                                        margin: 0.5rem 0;
                                                        transition: all 0.3s;
                                                        background-color: white;
                                                        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                                                    }

                                                    .service-header {
                                                        display: flex;
                                                        justify-content: space-between;
                                                        align-items: center;
                                                        margin-bottom: 1rem;
                                                    }

                                                    .service-icon {
                                                        font-size: 2rem;
                                                        color: #0d6efd;
                                                    }

                                                    .service-category {
                                                        background-color: #e9ecef;
                                                        padding: 0.25rem 0.5rem;
                                                        border-radius: 0.25rem;
                                                        font-size: 0.8rem;
                                                        font-weight: bold;
                                                        text-transform: uppercase;
                                                    }

                                                    .featured-badge {
                                                        background-color: #ffc107;
                                                        color: #212529;
                                                        padding: 0.25rem 0.5rem;
                                                        border-radius: 0.25rem;
                                                        font-size: 0.8rem;
                                                        font-weight: bold;
                                                        margin-left: 0.5rem;
                                                    }

                                                    .service-body h4 {
                                                        margin: 0 0 1rem 0;
                                                        color: #212529;
                                                    }

                                                    .service-body p {
                                                        margin: 0 0 1rem 0;
                                                        color: #6c757d;
                                                    }

                                                    .service-features {
                                                        margin: 1rem 0;
                                                    }

                                                    .feature-badge {
                                                        background-color: #e9ecef;
                                                        color: #495057;
                                                        padding: 0.25rem 0.5rem;
                                                        border-radius: 0.25rem;
                                                        font-size: 0.8rem;
                                                        margin: 0.125rem;
                                                        display: inline-block;
                                                    }

                                                    .service-btn {
                                                        background-color: #0d6efd;
                                                        color: white;
                                                        padding: 0.5rem 1rem;
                                                        border-radius: 0.25rem;
                                                        text-decoration: none;
                                                        display: inline-flex;
                                                        align-items: center;
                                                        gap: 0.25rem;
                                                        border: none;
                                                        width: 100%;
                                                        justify-content: center;
                                                        text-align: center;
                                                    }

                                                    .service-btn:hover {
                                                        background-color: #0b5ed7;
                                                        color: white;
                                                    }

                                                    .icon-option.selected {
                                                        border-color: #0d6efd !important;
                                                        background-color: #e7f3ff !important;
                                                    }
                                                    </style>

                                                    <script>
                                                    let selectedIcon =
                                                        '<?php echo htmlspecialchars($service->icon, ENT_QUOTES); ?>';

                                                    function selectIcon(iconClass) {
                                                        // Remover clase 'selected' de todos los iconos
                                                        document.querySelectorAll('.icon-option').forEach(option => {
                                                            option.classList.remove('selected');
                                                        });

                                                        // Añadir clase 'selected' al icono seleccionado
                                                        event.currentTarget.classList.add('selected');

                                                        // Actualizar icono seleccionado
                                                        selectedIcon = iconClass;
                                                        document.getElementById('icon').value = iconClass;

                                                        // Actualizar previsualización
                                                        updatePreview();
                                                    }

                                                    function updatePreview() {
                                                        const name = document.getElementById('name').value ||
                                                            'Nombre del Servicio';
                                                        const description = document.getElementById('description')
                                                            .value || 'Descripción del servicio...';
                                                        const category = document.getElementById('category_id').value ||
                                                            'General';
                                                        const features = document.getElementById('features').value;
                                                        const isFeatured = document.getElementById('is_featured')
                                                            .checked;

                                                        // Actualizar icono
                                                        // Actualizar icono (mantener 'fas' y cambiar solo el nombre del icono)
                                                        const iconElement = document.getElementById('preview-icon');
                                                        const iconClassParts = selectedIcon.split(' ');
                                                        if (iconClassParts.length > 0) {
                                                            // Mantener 'fas' y usar solo la última parte como nombre del icono
                                                            const iconName = iconClassParts[iconClassParts.length - 1];
                                                            iconElement.className = 'fas ' + iconName;
                                                        }

                                                        // Actualizar categoría (convertir a clase CSS)
                                                        const categoryClass = category.toLowerCase().replace(/\s+/g,
                                                            '-');
                                                        const previewCard = document.getElementById('preview-card');
                                                        previewCard.className = 'service-card ' + categoryClass;

                                                        // Actualizar texto de categoría
                                                        document.getElementById('preview-category').textContent =
                                                            document.getElementById('category_id').options[document
                                                                .getElementById('category_id').selectedIndex].text;

                                                        // Actualizar nombre
                                                        document.getElementById('preview-name').textContent = name;

                                                        // Actualizar descripción
                                                        document.getElementById('preview-description').textContent =
                                                            description;

                                                        // Actualizar destacado
                                                        const featuredBadge = document.getElementById(
                                                            'preview-featured');
                                                        if (isFeatured) {
                                                            featuredBadge.style.display = 'inline-block';
                                                        } else {
                                                            featuredBadge.style.display = 'none';
                                                        }

                                                        // Actualizar características
                                                        const featuresContainer = document.getElementById(
                                                            'preview-features');
                                                        featuresContainer.innerHTML = '';

                                                        if (features) {
                                                            const featureArray = features.split(',').map(f => f.trim())
                                                                .filter(f => f);
                                                            featureArray.forEach(feature => {
                                                                const badge = document.createElement('span');
                                                                badge.className = 'feature-badge';
                                                                badge.textContent = feature;
                                                                featuresContainer.appendChild(badge);
                                                            });
                                                        }

                                                        // Añadir información adicional si existe
                                                        if (duration || price) {
                                                            const additionalInfo = document.createElement('p');
                                                            additionalInfo.className = 'text-muted mb-0';
                                                            additionalInfo.style.fontSize = '0.9rem';
                                                            additionalInfo.innerHTML = '';

                                                            if (duration) {
                                                                additionalInfo.innerHTML +=
                                                                    `<strong>Duración:</strong> ${duration} min<br>`;
                                                            }
                                                            if (price) {
                                                                additionalInfo.innerHTML +=
                                                                    `<strong>Precio:</strong> $${parseFloat(price).toFixed(2)}`;
                                                            }

                                                            featuresContainer.appendChild(additionalInfo);
                                                        }
                                                    }

                                                    // Inicializar previsualización
                                                    updatePreview();
                                                    </script>
                                                </div>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Start -->
            <?php include 'includes/footer.php'; ?>
            <!-- end Footer -->

        </div>
        <!-- END wrapper -->

        <!-- Theme Settings -->
        <?php include 'includes/theme.php'; ?>


        <!-- Vendor js -->
        <script src="assets/admin/assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/admin/assets/js/app.js"></script>


</body>



</html>