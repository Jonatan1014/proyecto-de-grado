USE clinic_db;

-- ==========================================
-- 1. INSERTAR CLÍNICAS
-- ==========================================
INSERT INTO clinics (name, address, phone, email, schedule) VALUES
('Clínica Dental Sonrisa', 'Calle 123 #45-67, Bogotá', '601-2345678', 'info@clinicasonrisa.com', 'Lun-Vie: 8:00-18:00, Sáb: 9:00-13:00'),
('Centro Médico Salud Total', 'Carrera 15 #80-25, Bogotá', '601-8765432', 'contacto@saludtotal.com', 'Lun-Vie: 7:00-19:00');

-- ==========================================
-- 2. INSERTAR DOCTORES
-- ==========================================
INSERT INTO doctors (idnumber, name, specialization, phone, email, license_number) VALUES
('1234567890', 'Dr. Juan Pérez', 'Odontología General', '310-1234567', 'juan.perez@clinica.com', 'ODO-12345'),
('0987654321', 'Dra. María González', 'Ortodoncia', '320-9876543', 'maria.gonzalez@clinica.com', 'ODO-54321'),
('1122334455', 'Dr. Carlos Ramírez', 'Endodoncia', '315-1122334', 'carlos.ramirez@clinica.com', 'ODO-67890');

-- ==========================================
-- 3. INSERTAR PACIENTES
-- ==========================================
INSERT INTO patients (name, lastname, idnumber, birth_date, gender, phone, email, address, emergency_contact_name, emergency_contact_phone) VALUES
('Ana', 'Martínez', '1001234567', '1990-05-15', 'F', '300-1111111', 'ana.martinez@email.com', 'Calle 50 #20-30, Bogotá', 'Pedro Martínez', '300-2222222'),
('Luis', 'Hernández', '1002345678', '1985-08-22', 'M', '310-3333333', 'luis.hernandez@email.com', 'Carrera 70 #40-50, Bogotá', 'Carmen Hernández', '310-4444444'),
('Sofia', 'Torres', '1003456789', '1995-12-10', 'F', '320-5555555', 'sofia.torres@email.com', 'Avenida 68 #30-15, Bogotá', 'Miguel Torres', '320-6666666'),
('Jorge', 'Díaz', '1004567890', '1988-03-25', 'M', '315-7777777', 'jorge.diaz@email.com', 'Calle 100 #15-20, Bogotá', 'Laura Díaz', '315-8888888');

-- ==========================================
-- 4. INSERTAR USUARIOS
-- ==========================================
INSERT INTO users (username, email, password, role, is_active) VALUES
('admin_root', 'iadevelopment404@gmail.com', '$2y$10$oXi2hIoeMvISY7qYKM/WFeEc86LeZQAZXDHHthf8r/.0gJUlqPpvW', 'root', TRUE),
('admin_principal', 'jonatan@clinica.com', '$2y$10$oXi2hIoeMvISY7qYKM/WFeEc86LeZQAZXDHHthf8r/.0gJUlqPpvW', 'admin', TRUE),
('admin_recepcion', 'laura@clinica.com', '$2y$10$oXi2hIoeMvISY7qYKM/WFeEc86LeZQAZXDHHthf8r/.0gJUlqPpvW', 'admin', TRUE);

-- ==========================================
-- 5. INSERTAR CATEGORÍAS DE SERVICIOS
-- ==========================================
INSERT INTO service_categories (name) VALUES
('Odontología General'),
('Ortodoncia'),
('Endodoncia'),
('Cirugía Oral'),
('Estética Dental');

-- ==========================================
-- 6. INSERTAR SERVICIOS
-- ==========================================
INSERT INTO services (name, description, duration_minutes, price, category_id, icon, features, is_featured, status) VALUES
('Limpieza Dental', 'Profilaxis dental completa con eliminación de sarro y placa bacteriana', 45, 80000.00, 1, 'tooth-clean', '["Limpieza profunda", "Pulido dental", "Fluorización"]', TRUE, 'active'),
('Ortodoncia Brackets', 'Tratamiento de ortodoncia con brackets metálicos', 60, 2500000.00, 2, 'braces', '["Consulta inicial", "Brackets metálicos", "Controles mensuales"]', TRUE, 'active'),
('Endodoncia', 'Tratamiento de conductos radiculares', 90, 350000.00, 3, 'tooth-root', '["Anestesia local", "Limpieza de conductos", "Obturación"]', FALSE, 'active'),
('Extracción Simple', 'Extracción de diente sin complicaciones', 30, 120000.00, 4, 'tooth-extract', '["Anestesia local", "Extracción", "Medicación"]', FALSE, 'active'),
('Blanqueamiento Dental', 'Blanqueamiento dental profesional', 60, 450000.00, 5, 'tooth-white', '["Limpieza previa", "Aplicación de gel", "Lámpara LED"]', TRUE, 'active');

-- ==========================================
-- 7. INSERTAR CITAS
-- ==========================================
INSERT INTO appointments (patient_id, doctor_id, service_id, appointment_date, status, notes) VALUES
(1, 1, 1, '2025-10-15 10:00:00', 'scheduled', 'Primera consulta - Limpieza general'),
(2, 2, 2, '2025-10-16 14:00:00', 'scheduled', 'Instalación de brackets'),
(3, 3, 3, '2025-10-17 09:00:00', 'scheduled', 'Tratamiento de conducto molar inferior'),
(1, 1, 5, '2025-10-20 11:00:00', 'completed', 'Blanqueamiento completado exitosamente'),
(4, 1, 4, '2025-10-18 15:00:00', 'cancelled', 'Paciente canceló por motivos personales');

-- ==========================================
-- 8. INSERTAR EVENTOS DEL CALENDARIO
-- ==========================================
INSERT INTO events_calendar (title, description, start_datetime, end_datetime, event_type, appointment_id, patient_id, doctor_id, is_reminder_sent, reminder_datetime) VALUES
('Cita: Limpieza Dental - Ana Martínez', 'Limpieza dental programada', '2025-10-15 10:00:00', '2025-10-15 10:45:00', 'appointment', 1, 1, 1, FALSE, '2025-10-14 10:00:00'),
('Cita: Ortodoncia - Luis Hernández', 'Instalación de brackets', '2025-10-16 14:00:00', '2025-10-16 15:00:00', 'appointment', 2, 2, 2, FALSE, '2025-10-15 14:00:00'),
('Recordatorio: Revisión pacientes', 'Revisar historias clínicas pendientes', '2025-10-19 08:00:00', '2025-10-19 09:00:00', 'reminder', NULL, NULL, 1, FALSE, NULL);

-- ==========================================
-- 9. INSERTAR HISTORIAS CLÍNICAS DENTALES
-- ==========================================
INSERT INTO dental_clinical_records (
    patient_id, doctor_id, appointment_id, history_number, registration_date,
    reason_consultation, current_illness, medical_history, family_history,
    general_exam, local_exam, odontogram, main_diagnosis, secondary_diagnosis,
    treatment_plan, final_observations
) VALUES
(1, 1, 1, 'HC-2025-001', '2025-10-15',
    'Dolor en molar superior derecho',
    'Paciente refiere dolor intermitente de 3 días de evolución',
    'Hipertensión controlada con medicamento',
    'Madre con diabetes tipo 2',
    'Paciente en buen estado general, signos vitales normales',
    'Caries profunda en pieza 16, encías levemente inflamadas',
    '{"teeth": [{"number": 16, "condition": "caries", "severity": "profunda"}]}',
    'Caries dental profunda pieza 16',
    'Gingivitis leve',
    '[{"treatment": "Endodoncia", "tooth": 16, "cost": 350000, "sessions": 2, "date": "2025-10-22"}]',
    'Se programa endodoncia. Se recomienda mejorar higiene oral.'
),
(2, 2, 2, 'HC-2025-002', '2025-10-16',
    'Consulta para ortodoncia',
    'Paciente desea mejorar alineación dental',
    'Sin antecedentes médicos relevantes',
    'Sin antecedentes familiares relevantes',
    'Paciente sano, sin complicaciones',
    'Apiñamiento dental anterior, mordida cruzada leve',
    '{"teeth": [{"number": 11, "condition": "apiñamiento"}, {"number": 12, "condition": "apiñamiento"}]}',
    'Maloclusión Clase II',
    'Apiñamiento dental anterior',
    '[{"treatment": "Ortodoncia con brackets", "cost": 2500000, "duration_months": 18, "start_date": "2025-10-16"}]',
    'Tratamiento estimado de 18 meses con controles mensuales.'
);

-- ==========================================
-- 10. INSERTAR HISTORIAS CLÍNICAS GENERALES
-- ==========================================
INSERT INTO clinical_records (patient_id, doctor_id, appointment_id, date, diagnosis, treatment, observations) VALUES
(3, 3, 3, '2025-10-17', 'Pulpitis aguda', 'Endodoncia programada para molar 36', 'Paciente con dolor severo, se prescribe analgésico'),
(4, 1, 5, '2025-10-18', 'Pericoronaritis', 'Extracción de cordal cancelada', 'Paciente canceló cita, reprogramar');

-- ==========================================
-- 11. INSERTAR DETALLES DE HISTORIAS CLÍNICAS
-- ==========================================
INSERT INTO medical_records_details (clinical_record_id, detail_type, detail_value) VALUES
(1, 'Presión Arterial', '120/80 mmHg'),
(1, 'Medicación Actual', 'Losartán 50mg/día'),
(1, 'Alergias', 'Penicilina'),
(2, 'Signos Vitales', 'Normales'),
(2, 'Observaciones Radiográficas', 'Cordal inferior izquierdo parcialmente erupcionado');

