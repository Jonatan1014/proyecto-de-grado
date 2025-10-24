<?php
// Incluir el archivo de helpers
require_once __DIR__ . '/../Utils/Helpers.php';
?>
<!DOCTYPE html>
<html lang="es" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Carrito de Compras - Karma Shop</title>

    <!--
            CSS
            ============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>

    <!-- Start Header Area -->
    <?php include 'includes/header.php'; ?>
    <!-- End Header Area -->

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Carrito de Compras</h1>
                    <nav class="d-flex align-items-center">
                        <a href="home">Inicio<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Carrito</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <?php if (empty($items)): ?>
                    <!-- Carrito vacío -->
                    <div class="row">
                        <div class="col-lg-12 text-center py-5">
                            <i class="fa fa-shopping-cart" style="font-size: 100px; color: #ccc;"></i>
                            <h3 class="mt-4">Tu carrito está vacío</h3>
                            <p class="text-muted">Agrega productos para comenzar a comprar</p>
                            <a href="category" class="primary-btn mt-3">Ver Productos</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Carrito con productos -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $subtotal = 0;
                                foreach ($items as $item): 
                                    $precioUnitario = $item['precio'];
                                    $totalItem = $precioUnitario * $item['cantidad'];
                                    $subtotal += $totalItem;
                                    $imagenUrl = obtenerImagenProducto($item);
                                ?>
                                <tr data-carrito-id="<?= $item['id'] ?>">
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="img/product/<?= htmlspecialchars($imagenUrl) ?>" 
                                                     alt="<?= htmlspecialchars($item['producto_nombre']) ?>"
                                                     style="width: 100px; height: 100px; object-fit: cover;">
                                            </div>
                                            <div class="media-body">
                                                <p><?= htmlspecialchars($item['producto_nombre']) ?></p>
                                                <?php if (!empty($item['marca_nombre'])): ?>
                                                    <small class="text-muted"><?= htmlspecialchars($item['marca_nombre']) ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h5><?= formatearPrecio($precioUnitario) ?></h5>
                                    </td>
                                    <td>
                                        <div class="product_count">
                                            <input type="text" 
                                                   name="qty" 
                                                   class="input-text qty cart-quantity-input" 
                                                   maxlength="12" 
                                                   value="<?= $item['cantidad'] ?>"
                                                   title="Quantity:" 
                                                   data-carrito-id="<?= $item['id'] ?>"
                                                   data-max-stock="<?= $item['stock'] ?>">
                                            <button class="increase items-count" type="button">
                                                <i class="lnr lnr-chevron-up"></i>
                                            </button>
                                            <button class="reduced items-count" type="button">
                                                <i class="lnr lnr-chevron-down"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="item-total"><?= formatearPrecio($totalItem) ?></h5>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger remove-item" 
                                                data-carrito-id="<?= $item['id'] ?>"
                                                title="Eliminar">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <h5>Subtotal</h5>
                                    </td>
                                    <td>
                                        <h5 id="cart-subtotal"><?= formatearPrecio($subtotal) ?></h5>
                                    </td>
                                    <td></td>
                                </tr>
                                
                                <tr class="out_button_area">
                                    <td>
                                        <button class="gray_btn" id="btn-vaciar-carrito">
                                            <i class="fa fa-trash"></i> Vaciar Carrito
                                        </button>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2">
                                        <div class="checkout_btn_inner d-flex align-items-center">
                                            <a class="gray_btn" href="category">Continuar Comprando</a>
                                            <a class="primary-btn" href="checkout">Proceder al Pago</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <!-- start footer Area -->
    <?php include 'includes/footer.php'; ?>
    <!-- End footer Area -->

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

    <!-- Script del carrito -->
    <script>
    $(document).ready(function() {
        // Función para formatear precio
        function formatearPrecio(precio) {
            return '$' + parseFloat(precio).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
        
        // Función para actualizar subtotal
        function actualizarSubtotal() {
            let subtotal = 0;
            $('tbody tr[data-carrito-id]').each(function() {
                const cantidad = parseInt($(this).find('.cart-quantity-input').val()) || 0;
                const precio = parseFloat($(this).find('td:eq(1) h5').text().replace(/[$,]/g, '')) || 0;
                const total = cantidad * precio;
                subtotal += total;
                
                // Actualizar total del item
                $(this).find('.item-total').text(formatearPrecio(total));
            });
            
            $('#cart-subtotal').text(formatearPrecio(subtotal));
        }
        
        // Incrementar cantidad
        $(document).on('click', '.increase', function() {
            const input = $(this).siblings('.cart-quantity-input');
            const maxStock = parseInt(input.data('max-stock'));
            let cantidad = parseInt(input.val()) || 1;
            
            if (cantidad < maxStock) {
                cantidad++;
                input.val(cantidad);
                actualizarCantidadEnServidor(input.data('carrito-id'), cantidad);
                actualizarSubtotal();
            } else {
                alert('Stock máximo alcanzado: ' + maxStock + ' unidades');
            }
        });
        
        // Decrementar cantidad
        $(document).on('click', '.reduced', function() {
            const input = $(this).siblings('.cart-quantity-input');
            let cantidad = parseInt(input.val()) || 1;
            
            if (cantidad > 1) {
                cantidad--;
                input.val(cantidad);
                actualizarCantidadEnServidor(input.data('carrito-id'), cantidad);
                actualizarSubtotal();
            }
        });
        
        // Cambio manual de cantidad
        $(document).on('change', '.cart-quantity-input', function() {
            const maxStock = parseInt($(this).data('max-stock'));
            let cantidad = parseInt($(this).val()) || 1;
            
            if (cantidad < 1) {
                cantidad = 1;
            } else if (cantidad > maxStock) {
                cantidad = maxStock;
                alert('Stock máximo: ' + maxStock + ' unidades');
            }
            
            $(this).val(cantidad);
            actualizarCantidadEnServidor($(this).data('carrito-id'), cantidad);
            actualizarSubtotal();
        });
        
        // Actualizar cantidad en el servidor
        function actualizarCantidadEnServidor(carritoId, cantidad) {
            $.ajax({
                url: 'api/carrito/actualizar',
                method: 'POST',
                data: {
                    carrito_id: carritoId,
                    cantidad: cantidad
                },
                success: function(response) {
                    console.log('Cantidad actualizada');
                },
                error: function(xhr) {
                    console.error('Error al actualizar cantidad');
                    alert('Error al actualizar la cantidad');
                }
            });
        }
        
        // Eliminar producto
        $(document).on('click', '.remove-item', function() {
            if (!confirm('¿Estás seguro de eliminar este producto del carrito?')) {
                return;
            }
            
            const carritoId = $(this).data('carrito-id');
            const row = $(this).closest('tr');
            
            $.ajax({
                url: 'api/carrito/eliminar',
                method: 'POST',
                data: {
                    carrito_id: carritoId
                },
                success: function(response) {
                    if (response.success) {
                        row.fadeOut(300, function() {
                            $(this).remove();
                            actualizarSubtotal();
                            
                            // Actualizar contador del header
                            if (response.total_items !== undefined) {
                                const badge = $('.cart-count');
                                if (response.total_items > 0) {
                                    badge.text(response.total_items).show();
                                } else {
                                    badge.hide();
                                    // Recargar página si no hay items
                                    location.reload();
                                }
                            }
                        });
                    } else {
                        alert(response.message || 'Error al eliminar producto');
                    }
                },
                error: function(xhr) {
                    console.error('Error al eliminar producto');
                    alert('Error al eliminar el producto del carrito');
                }
            });
        });
        
        // Vaciar carrito
        $('#btn-vaciar-carrito').on('click', function() {
            if (!confirm('¿Estás seguro de vaciar todo el carrito?')) {
                return;
            }
            
            $.ajax({
                url: 'api/carrito/vaciar',
                method: 'POST',
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message || 'Error al vaciar carrito');
                    }
                },
                error: function(xhr) {
                    console.error('Error al vaciar carrito');
                    alert('Error al vaciar el carrito');
                }
            });
        });
    });
    </script>
</body>

</html>