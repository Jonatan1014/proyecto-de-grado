-- ====================================
-- DATOS DE PRUEBA PARA CLINIC_DB
-- ====================================

USE clinic_db;

-- 1. INSERTAR CLÍNICAS
INSERT INTO clinics (name, address, phone, email, schedule) VALUES
('Clínica Salud Total', 'Calle 45 #23-67, Bogotá', '601-3456789', 'contacto@saludtotal.com', 'Lunes a Viernes: 7:00 AM - 7:00 PM, Sábados: 8:00 AM - 2:00 PM'),
('Centro Médico El Bosque', 'Carrera 15 #89-45, Bogotá', '601-7654321', 'info@elbosque.com', 'Lunes a Viernes: 6:00 AM - 8:00 PM, Sábados: 7:00 AM - 4:00 PM'),
('Clínica San Rafael', 'Avenida 68 #34-12, Bogotá', '601-2345678', 'admin@sanrafael.com', 'Lunes a Domingo: 24 horas');

-- 2. INSERTAR USUARIOS
INSERT INTO users (username, email, password, role, is_active) VALUES
('admin_root', 'iadevelopment404@gmail.com.com', '$2y$10$oXi2hIoeMvISY7qYKM/WFeEc86LeZQAZXDHHthf8r/.0gJUlqPpvW', 'root', TRUE),
('admin_principal', 'jonatan@clinica.com', '$2y$10$oXi2hIoeMvISY7qYKM/WFeEc86LeZQAZXDHHthf8r/.0gJUlqPpvW', 'admin', TRUE),
('admin_recepcion', 'laura@clinica.com', '$2y$10$oXi2hIoeMvISY7qYKM/WFeEc86LeZQAZXDHHthf8r/.0gJUlqPpvW', 'admin', TRUE);

-- 3. INSERTAR CATEGORÍAS DE SERVICIOS
INSERT INTO service_categories (name) VALUES
('Consulta General'),
('Especialidades'),
('Diagnóstico'),
('Procedimientos'),
('Laboratorio'),
('Terapias');

-- 4. INSERTAR SERVICIOS
INSERT INTO services (name, description, duration_minutes, price, category_id, icon, features, is_featured, status) VALUES
('Consulta Médica General', 'Consulta con médico general para diagnóstico y tratamiento de enfermedades comunes', 30, 50000.00, 1, 'stethoscope', '["Examen físico", "Diagnóstico inicial", "Receta médica"]', TRUE, 'active'),
('Consulta Cardiología', 'Evaluación y tratamiento de enfermedades cardiovasculares', 45, 120000.00, 2, 'heart', '["Electrocardiograma", "Evaluación cardiovascular", "Plan de tratamiento"]', TRUE, 'active'),
('Consulta Pediatría', 'Atención médica especializada para niños', 40, 80000.00, 2, 'baby', '["Control de crecimiento", "Vacunación", "Diagnóstico pediátrico"]', TRUE, 'active'),
('Radiografía', 'Estudio de imágenes para diagnóstico', 20, 60000.00, 3, 'camera', '["Rayos X", "Informe radiológico"]', FALSE, 'active'),
('Examen de Sangre Completo', 'Análisis completo de sangre', 15, 45000.00, 5, 'droplet', '["Hemograma", "Perfil lipídico", "Glicemia"]', FALSE, 'active'),
('Ecografía', 'Estudio de diagnóstico por ultrasonido', 30, 90000.00, 3, 'scan', '["Imágenes en tiempo real", "Informe médico"]', TRUE, 'active'),
('Fisioterapia', 'Sesión de terapia física y rehabilitación', 60, 70000.00, 6, 'activity', '["Evaluación física", "Ejercicios terapéuticos", "Masajes"]', FALSE, 'active');

-- 5. INSERTAR DOCTORES
INSERT INTO doctors (idnumber, name, specialization, phone, email, license_number) VALUES
('1234567890', 'Dr. Carlos Méndez Ruiz', 'Medicina General', '3101234567', 'carlos.mendez@clinica.com', 'MG-2015-001234'),
('2345678901', 'Dra. Ana María López', 'Cardiología', '3109876543', 'ana.lopez@clinica.com', 'CA-2012-005678'),
('3456789012', 'Dr. Roberto Sánchez', 'Pediatría', '3205551234', 'roberto.sanchez@clinica.com', 'PE-2018-009876'),
('4567890123', 'Dra. Laura Fernández', 'Radiología', '3156667890', 'laura.fernandez@clinica.com', 'RA-2016-003456'),
('5678901234', 'Dr. Miguel Ángel Torres', 'Medicina General', '3187778901', 'miguel.torres@clinica.com', 'MG-2019-007890'),
('6789012345', 'Dra. Patricia Gómez', 'Fisioterapia', '3208889012', 'patricia.gomez@clinica.com', 'FT-2017-002345');

-- 6. INSERTAR PACIENTES
INSERT INTO patients (name, lastname, idnumber, birth_date, gender, phone, email, address, emergency_contact_name, emergency_contact_phone) VALUES
('Juan', 'Pérez García', '1001234567', '1985-03-15', 'M', '3001234567', 'juan.perez@email.com', 'Calle 100 #15-23, Bogotá', 'María Pérez', '3009876543'),
('María', 'González López', '1002345678', '1990-07-22', 'F', '3112345678', 'maria.gonzalez@email.com', 'Carrera 7 #45-67, Bogotá', 'Pedro González', '3118765432'),
('Carlos', 'Rodríguez Martínez', '1003456789', '1978-11-05', 'M', '3203456789', 'carlos.rodriguez@email.com', 'Avenida 19 #123-45, Bogotá', 'Laura Rodríguez', '3207654321'),
('Ana', 'Martínez Silva', '1004567890', '1995-02-18', 'F', '3154567890', 'ana.martinez@email.com', 'Calle 72 #8-90, Bogotá', 'José Martínez', '3156543210'),
('Luis', 'Hernández Castro', '1005678901', '1982-09-30', 'M', '3185678901', 'luis.hernandez@email.com', 'Carrera 30 #50-12, Bogotá', 'Sandra Hernández', '3189876543'),
('Sofia', 'Ramírez Ortiz', '1006789012', '2015-05-12', 'F', '3016789012', 'sofia.ramirez@email.com', 'Calle 53 #25-34, Bogotá', 'Carmen Ortiz', '3018765432'),
('Diego', 'Torres Vargas', '1007890123', '1988-12-08', 'M', '3207890123', 'diego.torres@email.com', 'Avenida 68 #78-90, Bogotá', 'Adriana Vargas', '3209876543');

-- 7. INSERTAR CITAS
INSERT INTO appointments (patient_id, doctor_id, service_id, appointment_date, status, notes) VALUES
(1, 1, 1, '2025-10-15 09:00:00', 'scheduled', 'Control de presión arterial'),
(2, 2, 2, '2025-10-15 10:30:00', 'scheduled', 'Revisión cardiológica anual'),
(3, 1, 1, '2025-10-16 14:00:00', 'scheduled', 'Dolor de cabeza persistente'),
(4, 3, 3, '2025-10-17 11:00:00', 'scheduled', 'Control de crecimiento'),
(5, 4, 4, '2025-10-18 08:30:00', 'scheduled', 'Radiografía de tórax'),
(6, 3, 3, '2025-10-19 16:00:00', 'scheduled', 'Vacunación'),
(7, 6, 7, '2025-10-20 15:00:00', 'scheduled', 'Rehabilitación de rodilla'),
(1, 1, 1, '2025-10-05 09:00:00', 'completed', 'Consulta por gripe - Tratamiento recetado'),
(2, 2, 2, '2025-09-20 10:00:00', 'completed', 'Evaluación cardiovascular - Todo normal'),
(3, 5, 5, '2025-10-03 07:30:00', 'cancelled', 'Paciente canceló por motivos personales');

-- 8. INSERTAR EVENTOS DEL CALENDARIO
INSERT INTO events_calendar (title, description, start_datetime, end_datetime, event_type, appointment_id, patient_id, doctor_id, reminder_datetime) VALUES
('Cita: Juan Pérez - Dr. Méndez', 'Consulta médica general', '2025-10-15 09:00:00', '2025-10-15 09:30:00', 'appointment', 1, 1, 1, '2025-10-14 18:00:00'),
('Cita: María González - Dra. López', 'Consulta cardiología', '2025-10-15 10:30:00', '2025-10-15 11:15:00', 'appointment', 2, 2, 2, '2025-10-14 18:00:00'),
('Recordatorio Vacunación', 'Vacuna anual para Sofia Ramírez', '2025-10-25 10:00:00', '2025-10-25 10:30:00', 'reminder', NULL, 6, 3, '2025-10-24 09:00:00'),
('Mantenimiento Equipos', 'Revisión de equipos médicos', '2025-10-22 07:00:00', '2025-10-22 12:00:00', 'other', NULL, NULL, NULL, NULL);

-- 9. INSERTAR REGISTROS CLÍNICOS
INSERT INTO clinical_records (patient_id, doctor_id, appointment_id, date, diagnosis, treatment, observations) VALUES
(1, 1, 8, '2025-10-05', 'Resfriado común (J00)', 'Acetaminofén 500mg cada 8 horas por 5 días, hidratación abundante y reposo', 'Paciente presenta síntomas leves. Control en 7 días si persisten síntomas.'),
(2, 2, 9, '2025-09-20', 'Control cardiológico preventivo', 'Continuar con dieta baja en sodio y ejercicio regular', 'Presión arterial: 120/80 mmHg. Frecuencia cardíaca: 72 lpm. Electrocardiograma normal.');

-- 10. INSERTAR DETALLES DE REGISTROS MÉDICOS
INSERT INTO medical_records_details (clinical_record_id, detail_type, detail_value) VALUES
(1, 'Temperatura', '37.8°C'),
(1, 'Presión Arterial', '130/85 mmHg'),
(1, 'Peso', '75 kg'),
(1, 'Medicamentos Recetados', 'Acetaminofén 500mg, Loratadina 10mg'),
(2, 'Presión Arterial', '120/80 mmHg'),
(2, 'Frecuencia Cardíaca', '72 lpm'),
(2, 'Colesterol Total', '180 mg/dL'),
(2, 'Electrocardiograma', 'Normal - Sin alteraciones');

-- ====================================
-- CONSULTAS DE VERIFICACIÓN
-- ====================================

-- Verificar clínicas insertadas
SELECT * FROM clinics;

-- Verificar doctores
SELECT * FROM doctors;

-- Verificar pacientes
SELECT * FROM patients;

-- Verificar servicios con sus categorías
SELECT s.name AS servicio, sc.name AS categoria, s.price, s.status
FROM services s
JOIN service_categories sc ON s.category_id = sc.id;

-- Verificar citas programadas
SELECT 
    a.id,
    CONCAT(p.name, ' ', p.lastname) AS paciente,
    d.name AS doctor,
    s.name AS servicio,
    a.appointment_date,
    a.status
FROM appointments a
JOIN patients p ON a.patient_id = p.id
JOIN doctors d ON a.doctor_id = d.id
JOIN services s ON a.service_id = s.id
ORDER BY a.appointment_date;

-- Verificar registros clínicos con detalles
SELECT 
    cr.id,
    CONCAT(p.name, ' ', p.lastname) AS paciente,
    d.name AS doctor,
    cr.date,
    cr.diagnosis,
    GROUP_CONCAT(CONCAT(mrd.detail_type, ': ', mrd.detail_value) SEPARATOR ' | ') AS detalles
FROM clinical_records cr
JOIN patients p ON cr.patient_id = p.id
JOIN doctors d ON cr.doctor_id = d.id
LEFT JOIN medical_records_details mrd ON cr.id = mrd.clinical_record_id
GROUP BY cr.id;

-- Verificar eventos del calendario
SELECT * FROM events_calendar ORDER BY start_datetime;