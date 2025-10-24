/**
 * carrito.js - Funciones para el manejo del carrito de compras
 */

// Agregar producto al carrito
function agregarAlCarrito(productoId, cantidad = 1) {
    const url = 'api/carrito/agregar';
    const data = {
        producto_id: productoId,
        cantidad: cantidad
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion('✓ Producto agregado al carrito', 'success');
            actualizarContadorCarrito(result.total_items || result.totalItems || 0);
        } else {
            mostrarNotificacion('✗ ' + result.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('✗ Error al agregar al carrito', 'error');
    });
}

// Actualizar cantidad de producto en el carrito
function actualizarCantidadCarrito(productoId, cantidad) {
    const url = 'api/carrito/actualizar';
    const data = {
        producto_id: productoId,
        cantidad: cantidad
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            actualizarTotalCarrito(result.total);
        } else {
            mostrarNotificacion('✗ ' + result.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('✗ Error al actualizar cantidad', 'error');
    });
}

// Eliminar producto del carrito
function eliminarDelCarrito(productoId) {
    if (!confirm('¿Está seguro de eliminar este producto del carrito?')) {
        return;
    }

    const url = 'api/carrito/eliminar';
    const data = {
        producto_id: productoId
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion('✓ Producto eliminado', 'success');
            actualizarContadorCarrito(result.total_items || result.totalItems || 0);
            actualizarTotalCarrito(result.total);
            // Remover elemento del DOM
            const elemento = document.querySelector(`[data-producto-id="${productoId}"]`);
            if (elemento) {
                elemento.remove();
            }
            // Recargar si estamos en la página del carrito
            if (window.location.pathname === 'cart') {
                setTimeout(() => location.reload(), 500);
            }
        } else {
            mostrarNotificacion('✗ ' + result.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('✗ Error al eliminar producto', 'error');
    });
}

// Vaciar carrito
function vaciarCarrito() {
    if (!confirm('¿Está seguro de vaciar todo el carrito?')) {
        return;
    }

    const url = 'api/carrito/vaciar';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion('✓ Carrito vaciado', 'success');
            setTimeout(() => location.reload(), 500);
        } else {
            mostrarNotificacion('✗ ' + result.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('✗ Error al vaciar carrito', 'error');
    });
}

// Actualizar contador del carrito en el header
function actualizarContadorCarrito(total) {
    const contador = document.querySelector('.cart-count, #cart-count, [data-cart-count]');
    if (contador) {
        contador.textContent = total;
        if (total > 0) {
            contador.style.display = 'inline-block';
        } else {
            contador.style.display = 'none';
        }
    }
}

// Actualizar total del carrito
function actualizarTotalCarrito(total) {
    const elementos = document.querySelectorAll('.cart-total, [data-cart-total]');
    elementos.forEach(elemento => {
        elemento.textContent = formatearPrecio(total);
    });
}

// Formatear precio
function formatearPrecio(precio) {
    return '$' + new Intl.NumberFormat('es-CO').format(precio);
}

// Mostrar notificación
function mostrarNotificacion(mensaje, tipo = 'info') {
    // Remover notificaciones anteriores
    const notifAnterior = document.querySelector('.notificacion-carrito');
    if (notifAnterior) {
        notifAnterior.remove();
    }

    // Crear nueva notificación
    const notif = document.createElement('div');
    notif.className = `notificacion-carrito notificacion-${tipo}`;
    notif.textContent = mensaje;
    notif.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${tipo === 'success' ? '#28a745' : '#dc3545'};
        color: white;
        padding: 15px 25px;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        z-index: 10000;
        font-size: 14px;
        animation: slideIn 0.3s ease-out;
    `;

    document.body.appendChild(notif);

    // Remover después de 3 segundos
    setTimeout(() => {
        notif.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => notif.remove(), 300);
    }, 3000);
}

// Agregar animaciones CSS
if (!document.querySelector('#carrito-animations')) {
    const style = document.createElement('style');
    style.id = 'carrito-animations';
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

// Event listeners cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    // Botones de agregar al carrito
    document.querySelectorAll('.btn-add-to-cart, [data-add-to-cart]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productoId = this.getAttribute('data-producto-id');
            const cantidad = this.getAttribute('data-cantidad') || 1;
            agregarAlCarrito(productoId, cantidad);
        });
    });

    // Botones de actualizar cantidad
    document.querySelectorAll('.btn-update-quantity').forEach(btn => {
        btn.addEventListener('click', function() {
            const productoId = this.getAttribute('data-producto-id');
            const input = document.querySelector(`input[data-producto-id="${productoId}"]`);
            if (input) {
                actualizarCantidadCarrito(productoId, input.value);
            }
        });
    });

    // Inputs de cantidad (actualización en tiempo real)
    document.querySelectorAll('input[type="number"][data-producto-id]').forEach(input => {
        input.addEventListener('change', function() {
            const productoId = this.getAttribute('data-producto-id');
            actualizarCantidadCarrito(productoId, this.value);
        });
    });

    // Botones de eliminar
    document.querySelectorAll('.btn-remove-from-cart, [data-remove-from-cart]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productoId = this.getAttribute('data-producto-id');
            eliminarDelCarrito(productoId);
        });
    });

    // Botón de vaciar carrito
    const btnVaciarCarrito = document.querySelector('#btn-vaciar-carrito, [data-vaciar-carrito]');
    if (btnVaciarCarrito) {
        btnVaciarCarrito.addEventListener('click', function(e) {
            e.preventDefault();
            vaciarCarrito();
        });
    }
});
