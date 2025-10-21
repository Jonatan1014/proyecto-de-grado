# 📋 Función de Prueba para Crear Médico

## 🎯 Descripción
Esta función permite crear un médico con datos predeterminados de forma rápida y sencilla, ideal para pruebas y desarrollo.

## ✅ Funciones Agregadas

### 1. `addMedicoTest()`
Función interna que crea el médico con datos predeterminados.

### 2. `crearMedicoPrueba()`
Función accesible por URL para crear el médico desde el navegador.

---

## 🚀 Formas de Usar

### **Opción 1: Desde el Navegador (Más Fácil)**

Simplemente accede a esta URL en tu navegador:

```
http://localhost/crear-medico-prueba
```

O si tu proyecto está en una carpeta específica:

```
http://localhost/proyecto-de-grado/crear-medico-prueba
```

**¡Eso es todo!** El médico se creará automáticamente y verás un mensaje de confirmación.

---

### **Opción 2: Desde el Código PHP**

Si quieres llamar la función desde otro archivo PHP:

```php
<?php
require_once __DIR__ . '/src/app/Controllers/MedicoController.php';

$medicoController = new MedicoController();
$id = $medicoController->addMedicoTest();

if ($id) {
    echo "Médico creado con ID: " . $id;
}
?>
```

---

### **Opción 3: Desde una Ruta Existente**

Agrega esto en cualquier controlador o archivo donde lo necesites:

```php
$medicoController = new MedicoController();
$medicoController->addMedicoTest();
```

---

## 📊 Datos del Médico de Prueba

El médico que se crea tiene estos datos predeterminados:

| Campo | Valor |
|-------|-------|
| **Nombre** | Dra. María González Pérez |
| **Especialización** | Medicina General |
| **Teléfono** | 3001234567 |
| **Email** | maria.gonzalez@clinica.com |
| **Número de Licencia** | MG-2025-001 |

---

## 🔧 Características

- ✅ **Sin validaciones**: Los datos se insertan directamente
- ✅ **Sin autenticación requerida en la función base**: Para facilitar las pruebas
- ✅ **Feedback visual**: Muestra mensajes de éxito o error
- ✅ **Retorna el ID**: Puedes obtener el ID del médico creado
- ✅ **Enlace directo**: Incluye un link para ver la lista de médicos

---

## 📝 Ejemplo de Salida

Cuando uses la función desde el navegador, verás algo como:

```
Creando Médico de Prueba...

✅ Médico de prueba creado exitosamente con ID: 5
Nombre: Dra. María González Pérez
Especialización: Medicina General
Teléfono: 3001234567
Email: maria.gonzalez@clinica.com
Licencia: MG-2025-001

Ver lista de médicos
```

---

## ⚠️ Notas Importantes

1. **Solo para desarrollo**: Esta función es para pruebas, no para producción
2. **Verifica duplicados**: Si llamas la función varias veces, creará múltiples médicos con los mismos datos
3. **Base de datos**: Asegúrate de que la tabla `doctors` exista en tu base de datos

---

## 🛠️ Solución de Problemas

### Si no funciona la URL:

1. Verifica que el servidor esté corriendo (XAMPP)
2. Revisa que la ruta en `routes.php` esté correctamente configurada
3. Asegúrate de que el archivo `MedicoController.php` esté en la ubicación correcta

### Si no se crea el médico:

1. Verifica que la tabla `doctors` exista en la base de datos
2. Revisa los permisos de la base de datos
3. Mira los logs de PHP para ver errores específicos

---

## 📞 Contacto

Si tienes problemas, revisa:
- Los logs de Apache en XAMPP
- La consola del navegador (F12)
- El archivo de logs de PHP

---

**¡Listo! Ahora puedes crear médicos de prueba con solo una línea de código o una URL.** 🎉
