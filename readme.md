# 🦷 Sistema de Gestión de Clínica Dental

Sistema web completo para la gestión de una clínica dental, incluyendo administración de citas, historial clínico, pacientes, médicos y servicios.

## 📋 Tabla de Contenidos

- [Requisitos Previos](#requisitos-previos)
- [Instalación](#instalación)
- [Configuración de la Base de Datos](#configuración-de-la-base-de-datos)
- [Configuración del Proyecto](#configuración-del-proyecto)
- [Ejecución del Proyecto](#ejecución-del-proyecto)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Características](#características)
- [Credenciales por Defecto](#credenciales-por-defecto)
- [Solución de Problemas](#solución-de-problemas)

## 🔧 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado lo siguiente:

### 1. XAMPP (v8.0 o superior)
XAMPP es un paquete que incluye Apache, MySQL, PHP y Perl.

**Descarga e instalación:**
1. Descarga XAMPP desde: https://www.apachefriends.org/
2. Ejecuta el instalador y sigue las instrucciones
3. Instala en la ruta por defecto: `C:\xampp\` (Windows) o `/opt/lampp/` (Linux)
4. Durante la instalación, asegúrate de seleccionar:
   - ✅ Apache
   - ✅ MySQL
   - ✅ PHP
   - ✅ phpMyAdmin

**Verificar instalación:**
```bash
# Abre el Panel de Control de XAMPP
# Windows: Busca "XAMPP Control Panel" en el menú inicio
# Linux: sudo /opt/lampp/manager-linux-x64.run
```

### 2. Composer (Gestor de Dependencias de PHP)
Composer es necesario para instalar las librerías del proyecto.

**Descarga e instalación:**

**Windows:**
1. Descarga desde: https://getcomposer.org/Composer-Setup.exe
2. Ejecuta el instalador
3. Asegúrate de que el instalador detecte la ruta de PHP de XAMPP (ejemplo: `C:\xampp\php\php.exe`)

**Linux/Mac:**
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

**Verificar instalación:**
```bash
composer --version
# Debería mostrar algo como: Composer version 2.x.x
```

### 3. Git (Opcional pero recomendado)
Para clonar el repositorio y control de versiones.

**Descarga:** https://git-scm.com/downloads

## 📥 Instalación

### Paso 1: Obtener el Proyecto

**Opción A - Clonar con Git (Recomendado):**
```bash
# Navega a la carpeta htdocs de XAMPP
cd C:\xampp\htdocs\

# Clona el repositorio
git clone https://github.com/Jonatan1014/proyecto-de-grado.git

# Entra al directorio del proyecto
cd proyecto-de-grado
```

**Opción B - Descarga manual:**
1. Descarga el proyecto como ZIP desde GitHub
2. Extrae el contenido en `C:\xampp\htdocs\proyecto-de-grado`

### Paso 2: Instalar Dependencias PHP

Abre una terminal en la carpeta del proyecto y ejecuta:

```bash
# Asegúrate de estar en la carpeta del proyecto
cd C:\xampp\htdocs\proyecto-de-grado

# Instalar dependencias
composer install
```

Esto instalará automáticamente:
- **TCPDF**: Librería para generación de PDFs (reportes, historiales clínicos)

## 🗄️ Configuración de la Base de Datos

### Paso 1: Iniciar Servicios de XAMPP

1. Abre el **Panel de Control de XAMPP**
2. Inicia los siguientes servicios:
   - ✅ **Apache** (servidor web)
   - ✅ **MySQL** (base de datos)

3. Verifica que los servicios estén corriendo (deben aparecer con fondo verde)

### Paso 2: Crear la Base de Datos Automáticamente

El proyecto incluye scripts SQL para crear la base de datos automáticamente.

**Método 1 - Usando phpMyAdmin (Recomendado para principiantes):**

1. Abre tu navegador y accede a: http://localhost/phpmyadmin
2. Haz clic en la pestaña **"SQL"** en el menú superior
3. Abre el archivo `database/structure.sql` del proyecto con un editor de texto
4. Copia todo el contenido del archivo
5. Pégalo en el editor SQL de phpMyAdmin
6. Haz clic en el botón **"Continuar"** o **"Go"**
7. La base de datos `clinic_db` se creará automáticamente con todas las tablas

**Método 2 - Usando línea de comandos:**

```bash
# Windows (desde la carpeta del proyecto)
C:\xampp\mysql\bin\mysql -u root -p < database/structure.sql

# Linux/Mac
mysql -u root -p < database/structure.sql

# Cuando te pida la contraseña, presiona Enter (por defecto está vacía)
```

**Método 3 - Importar desde phpMyAdmin:**

1. Abre phpMyAdmin: http://localhost/phpmyadmin
2. Crea una nueva base de datos llamada `clinic_db`:
   - Haz clic en **"Nueva"** en el panel izquierdo
   - Nombre: `clinic_db`
   - Cotejamiento: `utf8mb4_general_ci`
   - Clic en **"Crear"**
3. Selecciona la base de datos `clinic_db`
4. Ve a la pestaña **"Importar"**
5. Haz clic en **"Seleccionar archivo"**
6. Navega a `proyecto-de-grado/database/structure.sql`
7. Haz clic en **"Continuar"**

### Paso 3: Cargar Datos de Ejemplo (Opcional)

Si deseas cargar datos de prueba:

```bash
# Usando línea de comandos
C:\xampp\mysql\bin\mysql -u root -p clinic_db < database/example.sql

# O importa el archivo example.sql desde phpMyAdmin (mismo proceso que el paso anterior)
```

### Verificar la Instalación de la Base de Datos

1. Abre phpMyAdmin: http://localhost/phpmyadmin
2. Selecciona la base de datos `clinic_db` en el panel izquierdo
3. Deberías ver las siguientes tablas:
   - ✅ `users` - Usuarios y administradores
   - ✅ `pacientes` - Información de pacientes
   - ✅ `doctores` - Médicos de la clínica
   - ✅ `citas` - Citas médicas
   - ✅ `historial_clinico` - Historiales clínicos
   - ✅ `servicios` - Servicios ofrecidos
   - ✅ `categorias_servicios` - Categorías de servicios

## ⚙️ Configuración del Proyecto

### Configuración de la Conexión a la Base de Datos

El proyecto usa variables de entorno para la configuración. Si necesitas cambiar los datos de conexión:

1. Abre el archivo: `src/config/database.php`
2. Las credenciales por defecto son:
   ```php
   Host: localhost
   Base de datos: clinic_db
   Usuario: root
   Contraseña: (vacía)
   ```

Si necesitas cambiar estos valores, puedes modificar las constantes en el archivo de configuración:

```php
// Configuración local (desarrollo)
$host = 'localhost';
$db_name = 'clinic_db';
$username = 'root';
$password = ''; // Deja vacío si no tienes contraseña en MySQL
```

### Configuración de Rutas

El archivo `src/config/routes.php` define todas las rutas del sistema. No requiere configuración adicional.

## 🚀 Ejecución del Proyecto

### Paso 1: Verificar Servicios

Asegúrate de que Apache y MySQL estén corriendo en el Panel de Control de XAMPP.

### Paso 2: Acceder al Sistema

Abre tu navegador y accede a:

```
http://localhost/proyecto-de-grado/src/public/
```

O si configuraste un Virtual Host:

```
http://localhost/proyecto-de-grado/
```

### Paso 3: Iniciar Sesión

Usa las credenciales por defecto (ver sección [Credenciales por Defecto](#credenciales-por-defecto))

## 📁 Estructura del Proyecto

```
proyecto-de-grado/
├── 📂 database/              # Scripts SQL
│   ├── structure.sql        # Estructura de la base de datos
│   ├── example.sql          # Datos de ejemplo
│   └── dump.sql             # Respaldo de la base de datos
│
├── 📂 src/                   # Código fuente
│   ├── 📂 app/              # Lógica de la aplicación
│   │   ├── Controllers/     # Controladores (lógica de negocio)
│   │   ├── Models/          # Modelos (acceso a datos)
│   │   ├── Services/        # Servicios (autenticación, etc.)
│   │   ├── Views/           # Vistas (HTML/PHP)
│   │   └── Utils/           # Utilidades (validación, conexión)
│   │
│   ├── 📂 config/           # Configuración
│   │   ├── config.php       # Configuración general
│   │   ├── database.php     # Configuración de BD
│   │   └── routes.php       # Rutas del sistema
│   │
│   └── 📂 public/           # Archivos públicos
│       ├── index.php        # Punto de entrada
│       └── assets/          # CSS, JS, imágenes
│
├── 📂 vendor/               # Dependencias de Composer
├── composer.json            # Configuración de Composer
├── README.md               # Este archivo
└── .gitignore              # Archivos ignorados por Git
```

## ✨ Características

### Módulo de Administración
- 👥 **Gestión de Usuarios**: Crear, editar y eliminar administradores (solo ROOT)
- 👨‍⚕️ **Gestión de Médicos**: Administrar doctores y sus especialidades
- 🏥 **Gestión de Servicios**: Catalogar servicios y categorías
- 🗓️ **Calendario de Citas**: Vista completa de todas las citas programadas
- 📊 **Dashboard**: Estadísticas y métricas del sistema

### Módulo de Pacientes
- 📝 **Registro de Pacientes**: Información completa del paciente
- 📅 **Gestión de Citas**: Agendar, modificar y cancelar citas
- 📋 **Historial Clínico**: Registro completo de consultas y tratamientos
- 📄 **Generación de PDFs**: Exportar historiales e informes

### Seguridad
- 🔐 **Sistema de Autenticación**: Login seguro con sesiones
- 🛡️ **Control de Roles**: ROOT, Admin y Usuario
- 🔒 **Contraseñas Encriptadas**: Uso de password_hash()
- ✅ **Validaciones**: Cliente y servidor

## 🔑 Credenciales por Defecto

Después de instalar la base de datos, puedes acceder con:

### Usuario ROOT (Acceso Total)
```
Usuario: root
Contraseña: root123
```

### Usuario Administrador
```
Usuario: admin
Contraseña: admin123
```

> ⚠️ **IMPORTANTE**: Cambia estas contraseñas después de la primera instalación por seguridad.

## 🔧 Solución de Problemas

### Problema: "Error de conexión a la base de datos"

**Soluciones:**
1. Verifica que MySQL esté corriendo en XAMPP
2. Confirma que la base de datos `clinic_db` existe en phpMyAdmin
3. Verifica las credenciales en `src/config/database.php`
4. Asegúrate de que el usuario `root` no tenga contraseña o ajusta la configuración

### Problema: "Página en blanco" o "Error 500"

**Soluciones:**
1. Verifica que Apache esté corriendo
2. Revisa los logs de error en `C:\xampp\apache\logs\error.log`
3. Asegúrate de que PHP esté habilitado en Apache
4. Verifica que el archivo `.htaccess` exista si lo estás usando

### Problema: "Class not found" o errores de Composer

**Soluciones:**
```bash
# Regenera el autoloader de Composer
composer dump-autoload

# O reinstala las dependencias
composer install --no-cache
```

### Problema: Rutas no funcionan (Error 404)

**Soluciones:**
1. Asegúrate de acceder a través de `http://localhost/proyecto-de-grado/src/public/`
2. Verifica que el archivo `index.php` esté en `src/public/`
3. Limpia la caché del navegador (Ctrl + F5)

### Problema: No se cargan los estilos CSS

**Soluciones:**
1. Verifica que la carpeta `assets` esté en `src/public/`
2. Revisa las rutas en las vistas (deben ser relativas a `public/`)
3. Limpia la caché del navegador

### Problema: Sesiones no funcionan

**Soluciones:**
1. Verifica que la carpeta `C:\xampp\tmp` exista
2. Asegúrate de que PHP tenga permisos de escritura en esa carpeta
3. Revisa `php.ini` para confirmar que `session.save_path` esté configurado

## 📞 Soporte

Si encuentras problemas no listados aquí:

1. Revisa los logs de error de Apache: `C:\xampp\apache\logs\error.log`
2. Revisa los logs de PHP en la salida del servidor
3. Verifica que todas las extensiones de PHP necesarias estén habilitadas en `php.ini`:
   - `extension=pdo_mysql`
   - `extension=mbstring`
   - `extension=openssl`

## 📝 Licencia

Este proyecto es parte de un proyecto de grado y está disponible para fines educativos.

## 👨‍💻 Autor

**Jonatan1014**
- GitHub: [@Jonatan1014](https://github.com/Jonatan1014)

---

**¡Disfruta del sistema! 🦷✨**