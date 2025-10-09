-- Crear base de datos
CREATE DATABASE IF NOT EXISTS clinic_db;
USE clinic_db;

-- Tabla: clinics
CREATE TABLE clinics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(255),
    schedule TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: doctors
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idnumber VARCHAR(50) UNIQUE,
    name VARCHAR(255) NOT NULL,
    specialization VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(255),
    license_number VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla: patients
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    idnumber VARCHAR(50) UNIQUE,
    birth_date DATE,
    gender ENUM('M', 'F', 'Otro'),
    phone VARCHAR(20),
    email VARCHAR(255),
    address TEXT,
    emergency_contact_name VARCHAR(255),
    emergency_contact_phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Agregar tabla users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('root', 'admin') NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- Agregar tabla services-categories
CREATE TABLE service_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla: services (actualizada)
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    duration_minutes INT,
    price DECIMAL(10, 2),
    category_id INT,
    icon VARCHAR(100),
    features JSON,
    is_featured BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES service_categories(id)
);

-- Tabla: appointments
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    service_id INT NOT NULL,
    appointment_date DATETIME NOT NULL,
    status ENUM('scheduled', 'completed', 'cancelled') DEFAULT 'scheduled',
    notes TEXT,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id),
    FOREIGN KEY (service_id) REFERENCES services(id),
    UNIQUE (patient_id, doctor_id, appointment_date), -- Evita citas duplicadas para el mismo paciente y doctor en la misma fecha y hora
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla: clinical_records
CREATE TABLE clinical_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_id INT,
    date DATE NOT NULL,
    diagnosis TEXT,
    treatment TEXT,
    observations TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id),
    FOREIGN KEY (appointment_id) REFERENCES appointments(id),
    UNIQUE (patient_id, date) -- Evita registros clínicos duplicados para el mismo paciente en la misma fecha
);

-- Tabla: medical_records_details
CREATE TABLE medical_records_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clinical_record_id INT NOT NULL,
    detail_type VARCHAR(255),
    detail_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (clinical_record_id) REFERENCES clinical_records(id),
    UNIQUE (clinical_record_id, detail_type) -- Evita detalles duplicados del mismo tipo para un registro clínico
);



-- Insertar datos en clinics
INSERT INTO clinics (name, address, phone, email, schedule) VALUES
('Clínica Dental Sonrisa Perfecta', 'Av. Siempre Viva 123, Ciudad', '555-1234', 'info@sonrisaperfecta.com', 'Lunes a Viernes 8:00 - 18:00');

-- Insertar datos en doctors
INSERT INTO doctors (idnumber, name, specialization, phone, email, license_number) VALUES
('101010','Dr. Juan Pérez', 'Odontología General', '555-5678', 'juan@clinic.com', 'MED123456'),
('202020','Dra. María López', 'Ortodoncia', '555-9012', 'maria@clinic.com', 'MED789012');

-- Insertar datos en patients
INSERT INTO patients (idnumber, name, lastname, birth_date, gender, phone, email, address) VALUES
('303030','Carlos manuel', 'Rodriguez', '1990-05-15', 'M', '555-3456', 'carlos@paciente.com', 'Calle Falsa 123'),
('404040','Ana', 'Martinez', '1985-11-23', 'F', '555-7890', 'ana@paciente.com', 'Av. Central 456');

-- Insertar usuario con rol 'root'
INSERT INTO users (username, email, password, role, is_active) 
VALUES ('root_user', 'iadevelopment404@gmail.com', '$2y$10$oXi2hIoeMvISY7qYKM/WFeEc86LeZQAZXDHHthf8r/.0gJUlqPpvW', 'root', TRUE);

-- Insertar usuario con rol 'admin'
INSERT INTO users (username, email, password, role, is_active) 
VALUES ('admin_user', 'admin@gmail.com', '$2y$10$oXi2hIoeMvISY7qYKM/WFeEc86LeZQAZXDHHthf8r/.0gJUlqPpvW', 'admin', TRUE);

-- Insertar datos en service_categories
INSERT INTO service_categories (name) VALUES
('Dental'),
('Surgery'),
('Pediatrics'),
('Cardiology');

-- Insertar datos en services
INSERT INTO services (
    name, 
    description, 
    duration_minutes, 
    price, 
    category_id, 
    icon, 
    features, 
    is_featured, 
    status
) VALUES (
    'Limpieza Dental Profunda',
    'Procedimiento de limpieza completa que elimina la placa y el sarro acumulados en los dientes y encías.',
    60,
    80.00,
    1,
    'fas fa-tooth',
    '["Limpieza Profunda", "Eliminación de Sarro", "Pulido Dental", "Prevención de Caries"]',
    TRUE,
    'active'
);
INSERT INTO services (
    name, 
    description, 
    duration_minutes, 
    price, 
    category_id, 
    icon, 
    features, 
    is_featured, 
    status
) VALUES (
    'Extracción de Muela del Juicio',
    'Procedimiento quirúrgico para remover muelas del juicio que están impactadas o causan problemas.',
    90,
    350.00,
    2,
    'fas fa-syringe',
    '["Anestesia Local", "Extracción Quirúrgica", "Cirugía Oral", "Recuperación Post-Operativa"]',
    FALSE,
    'active'
);
INSERT INTO services (
    name, 
    description, 
    duration_minutes, 
    price, 
    category_id, 
    icon, 
    features, 
    is_featured, 
    status
) VALUES (
    'Ortodoncia con Brackets',
    'Tratamiento ortodóncico para corregir la alineación de los dientes y mejorar la mordida.',
    45,
    2500.00,
    3,
    'fas fa-smile',
    '["Brackets Metálicos", "Ajustes Mensuales", "Control de Progreso", "Resultados Garantizados"]',
    TRUE,
    'active'
);

-- Insertar datos en appointments
INSERT INTO appointments (patient_id, doctor_id, service_id, appointment_date, status, notes) VALUES
(1, 1, 1, '2025-04-20 10:00:00', 'scheduled', 'Primera cita'),
(2, 2, 3, '2025-04-21 11:00:00', 'completed', 'Revisión');

-- Insertar datos en clinical_records
INSERT INTO clinical_records (patient_id, doctor_id, appointment_id, date, diagnosis, treatment) VALUES
(1, 1, 1, '2025-04-20', 'Sarro leve', 'Limpieza profunda'),
(2, 2, 2, '2025-04-21', 'Desalineación dental', 'Colocación de brackets');

-- Insertar datos en medical_records_details
INSERT INTO medical_records_details (clinical_record_id, detail_type, detail_value) VALUES
(1, 'Síntomas', 'Sensibilidad dental'),
(1, 'Tratamiento Aplicado', 'Fluorización'),
(2, 'Plan de Tratamiento', 'Revisiones mensuales');