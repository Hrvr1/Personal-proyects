DROP TABLE IF EXISTS metodos_pago;
DROP TABLE IF EXISTS lista_favoritos;
DROP TABLE IF EXISTS comentarios;
DROP TABLE IF EXISTS lineacarrito;
DROP TABLE IF EXISTS carrito;
DROP TABLE IF EXISTS lineapedido;
DROP TABLE IF EXISTS pedido;
DROP TABLE IF EXISTS lineaBandejaNotificacion;
DROP TABLE IF EXISTS bandejaNotificacion;
DROP TABLE IF EXISTS vehiculo;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS marcas;
DROP TABLE IF EXISTS consejos;

-- Crear la tabla Consejos
CREATE TABLE consejos (
    consejo_id INT PRIMARY KEY,
    categoria VARCHAR(50),
    pregunta TEXT,
    respuesta TEXT
);

-- Crear la tabla Marca
CREATE TABLE marcas (
    marca_id INT PRIMARY KEY,
    marca VARCHAR(45) NOT NULL
);

-- Crear la tabla Usuarios
CREATE TABLE usuarios (
    username VARCHAR(50) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(50) NOT NULL,
    telefono VARCHAR(18),
    contrasenya VARCHAR(30) NOT NULL,
    calle VARCHAR(50),
    localidad VARCHAR(45),
    provincia VARCHAR(45),
    codigo_postal VARCHAR(6),
    email VARCHAR(45),
    admin INT NOT NULL DEFAULT 0
);

-- Crear la tabla Vehiculo
CREATE TABLE vehiculo (
    vehiculo_id INT PRIMARY key,
    marca_id INT,
    modelo VARCHAR(45) NOT NULL,
    auto_manu VARCHAR(45) NOT NULL,
    kilometraje INT NOT NULL,
    color VARCHAR(45),
    precio decimal(10,2) NOT NULL,
    anyo INT,
    combustible VARCHAR(45) NOT NULL,
    descripcion VARCHAR(200),
    valoracion decimal(2,1),
    url_imagen VARCHAR(100),
    vendido INT NOT NULL DEFAULT 0,
    vendedor_UName VARCHAR(50) NOT NULL,
    CONSTRAINT FK_VEHICULO_MARCA FOREIGN KEY (marca_id) REFERENCES marcas(marca_id)
        on delete set null
        on update CASCADE,
    CONSTRAINT FK_VEHICULO_USUARIO FOREIGN KEY (vendedor_UName) REFERENCES usuarios(username)
        on delete CASCADE
        on update CASCADE
);

-- Crear la tabla Bandejanotificacion
CREATE TABLE bandejaNotificacion (
    notificacion_id INT IDENTITY(1,1) PRIMARY KEY,
    usuario_UName VARCHAR(50) NOT NULL,
    CONSTRAINT FK_BANDEJANOTIFICACION_USUARIO FOREIGN KEY (usuario_UName) REFERENCES usuarios(username)
        on delete CASCADE
        on update CASCADE
);

-- Crear la tabla LineaBandejanotificacion
CREATE TABLE lineaBandejaNotificacion (
    linea_id INT IDENTITY(1,1),
    notificacion_id INT,
    tipo_notificacion VARCHAR(50) NOT NULL,
    fecha_notificacion date not null,
    vehiculo_id INT NOT NULL,
    CONSTRAINT PK_LINEA_BANDEJANOTIFICACION PRIMARY KEY (linea_id, notificacion_id),
    CONSTRAINT FK_LINEA_BANDEJANOTIFICACION_VEHICULO FOREIGN KEY (vehiculo_id) REFERENCES vehiculo(vehiculo_id)
        on delete CASCADE
        on update CASCADE,
    CONSTRAINT FK_LINEA_BANDEJANOTIFICACION_BANDEJA FOREIGN KEY (notificacion_id) REFERENCES bandejaNotificacion(notificacion_id)
        on delete no action
        on update no action
);

-- Crear la tabla Pedido
CREATE TABLE pedido (
    pedido_id INT PRIMARY KEY,
    comprador_UName VARCHAR(50) NOT NULL,
    vendedor_UName VARCHAR(50) NOT NULL,
    fecha_pedido date not null,
    total DECIMAL(10, 2) NOT NULL,
    CONSTRAINT FK_PEDIDO_USUARIO_VENDEDOR FOREIGN key (vendedor_UName) references usuarios (username)
  		on delete CASCADE
  		on update Cascade,
    CONSTRAINT FK_PEDIDO_USUARIO_COMPRADOR FOREIGN key (comprador_UName) references usuarios (username)
  		on delete no action
  		on update no action
);

-- Crear la tabla Lineapedido
CREATE TABLE lineapedido (
    linea_pedido_id INT,
    pedido_id INT,
    comprador_UName VARCHAR(50) NOT NULL,
    vehiculo_id INT NOT NULL,
    importe DECIMAL(10, 2) NOT NULL,
    CONSTRAINT PK_LINPEDIDO PRIMARY key (linea_pedido_id, pedido_id),
  	CONSTRAINT FK_LINPEDIDO_PEDIDO FOREIGN key (pedido_id) references pedido (pedido_id)
  		on delete CASCADE
  		on update Cascade,
  	CONSTRAINT FK_LINPEDIDO_VEHICULO FOREIGN key (vehiculo_id) references vehiculo (vehiculo_id)
  		on update no action
  		on delete no action
);

-- Crear la tabla Carrito con carrito_id auto-incremental
CREATE TABLE carrito (
    carrito_id INT IDENTITY(1,1) PRIMARY KEY,
    usuario_UName VARCHAR(50) NOT NULL,
    CONSTRAINT FK_CARRITO_USUARIO FOREIGN KEY (usuario_UName) REFERENCES usuarios (username)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Crear la tabla Lineacarrito
CREATE TABLE lineacarrito (
    linea_carrito_id INT IDENTITY(1,1) NOT NULL,
    carrito_id INT NOT NULL,
    vehiculo_id INT NOT NULL,
    usuario_UName VARCHAR(50) NOT NULL,
    importe DECIMAL(10, 2) NOT NULL,
    CONSTRAINT PK_LINCARRITO PRIMARY KEY (linea_carrito_id, carrito_id),
    CONSTRAINT FK_LINCARRITO_CARRITO FOREIGN KEY (carrito_id) REFERENCES carrito (carrito_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT FK_LINCARRITO_VEHICULO FOREIGN KEY (vehiculo_id) REFERENCES vehiculo (vehiculo_id)
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

-- Crear la tabla Comentarios
CREATE TABLE comentarios (
    comentario_id INT PRIMARY KEY,
    vehiculo_id INT NOT NULL,
    usuario_UName VARCHAR(50) NOT NULL,
    comentario VARCHAR(200) NOT NULL,
    fecha_comentario date not null,
    CONSTRAINT FK_COMENTARIOS_VEHICULO FOREIGN KEY (vehiculo_id) REFERENCES vehiculo(vehiculo_id)
        on delete CASCADE
        on update CASCADE,
    CONSTRAINT FK_COMENTARIOS_USUARIO FOREIGN KEY (usuario_UName) REFERENCES usuarios(username)
        on delete no action
        on update no action
);

-- Crear la tabla Lista_favoritos
CREATE TABLE lista_favoritos (
    lista_favorito_id INT IDENTITY(1,1) NOT NULL,
    usuario_UName VARCHAR(50) NOT NULL,
    vehiculo_id INT NOT NULL,
    CONSTRAINT FK_LISTAFAVORITOS_USUARIO FOREIGN KEY (usuario_UName) REFERENCES usuarios(username)
        on delete CASCADE
        on update CASCADE,
    CONSTRAINT FK_LISTAFAVORITOS_VEHICULO FOREIGN KEY (vehiculo_id) REFERENCES vehiculo(vehiculo_id)
        on delete no action
        on update no action
);

-- Crear la tabla Metodos_pago
CREATE TABLE metodos_pago (
    numTarjeta varchar(16) PRIMARY key,
  	cvv varchar(3) null,
  	mes_cad int not null,
  	anyo_cad int not null,
  	usuario varchar(50) not null,
  	CONSTRAINT FK_TARJETA_USUARIO FOREIGN key (usuario) references usuarios (username)
  		on delete CASCADE
  		on update cascade
);

-- Inserts para la tabla Marca
INSERT INTO marcas (marca_id, marca) VALUES
(1, 'Toyota'),
(2, 'Honda'),
(3, 'Ford'),
(4, 'Chevrolet'),
(5, 'Volkswagen'),
(6, 'BMW'),
(7, 'Mercedes-Benz'),
(8, 'Audi'),
(9, 'Hyundai'),
(10, 'Kia'),
(11, 'Subaru'),
(12, 'Mazda'),
(13, 'Nissan'),
(14, 'Jeep'),
(15, 'Fiat'),
(16, 'Renault'),
(17, 'Peugeot'),
(18, 'Volvo'),
(19, 'Land Rover'),
(20, 'Mitsubishi'),
(21, 'Suzuki'),
(22, 'Lexus'),
(23, 'Opel');

-- Inserts para la tabla Usuarios
INSERT INTO usuarios (username, nombre, apellidos, telefono, contrasenya, calle, localidad, provincia, codigo_postal, email, admin) VALUES
('jcz', 'Jiahao', 'Chen Zhou', '611222333', '123456', 'Serrano, nº3, 6ºA', 'Alicante', 'Alicante', '03003', 'jcz13@gcloud.ua.es', 1),
('hrv', 'Hugo', 'Redondo Valdés', '626333770', 'contrasenya', 'Gran Via, nº2, 8ºB', 'Alicante', 'Alicante', '03402', 'hrvr1@gcloud.ua.es', 1),
('omr', 'Oscar', 'Massanet Robles', '611654326', '060504', 'Bono Guarner, nº12, 3ºC', 'Alicante', 'Alicante', '03005', 'omr10@gcloud.ua.es', 1),
('dqm', 'David', 'Quevedo Mora', '625421300', '012345', 'Pinto, nº1, 1ºA', 'Alicante', 'Alicante', '03008', 'dqm2@gcloud.ua.es', 1),
('yc', 'Yamina', 'Chibane', '602426879', '063215', 'Gabinete, nº11, 2ºB', 'Alicante', 'Alicante', '03006', 'yc27@gcloud.ua.es', 1),
('rc', 'Rahma', 'Chibane', '611259249', '078093', 'Pintor, nº9, 8ºC', 'Alicante', 'Alicante', '03030', 'rc75@gcloud.ua.es', 1),
('user123', 'Juan', 'García', '611234567', '1234', 'Calle Principal', 'Madrid', 'Madrid', '28001', 'juan@example.com', 0),
('maria87', 'María', 'López', '622345678', '7654', 'Avenida Central', 'Barcelona', 'Barcelona', '08001', 'maria@example.com', 0),
('pedro_m', 'Pedro', 'Martínez', '633456789', '4567', 'Calle Mayor', 'Valencia', 'Valencia', '46001', 'pedro@example.com', 0),
('ana_rodr', 'Ana', 'Rodríguez', '644567890', '2345', 'Plaza Principal', 'Sevilla', 'Sevilla', '41001', 'ana@example.com', 0),
('lucia77', 'Lucía', 'Gómez', '655678901', '9876', 'Paseo Central', 'Málaga', 'Málaga', '29001', 'lucia@example.com', 0),
('davidc90', 'David', 'Cruz', '666789012', '3456', 'Calle Mayor', 'Madrid', 'Madrid', '28001', 'david@example.com', 0),
('laura89', 'Laura', 'Fernández', '677890123', '8765', 'Avenida Principal', 'Barcelona', 'Barcelona', '08001', 'laura@example.com', 0),
('sergio92', 'Sergio', 'Hernández', '688901234', '6543', 'Calle Mayor', 'Valencia', 'Valencia', '46001', 'sergio@example.com', 0),
('julialopez', 'Julia', 'López', '699012345', '5678', 'Plaza Mayor', 'Sevilla', 'Sevilla', '41001', 'julia@example.com', 0),
('mario_g', 'Mario', 'García', '600123456', '0123', 'Paseo Central', 'Málaga', 'Málaga', '29001', 'mario@example.com', 0);

-- Inserts para la tabla Vehiculo
INSERT INTO vehiculo (vehiculo_id, marca_id, modelo, auto_manu, kilometraje, color, precio, anyo, combustible, descripcion, valoracion, url_imagen, vendido, vendedor_UName) VALUES
(1, 1, 'Corolla', 'Manual', 71867, 'Blanco', 19999.00, 2019, 'Gasolina', 'Toyota Corolla en excelente estado.', 4.5, '/App_Images/vehiculos/toyota_corolla_blanco.jpg', 1, 'lucia77'),
(2, 2, 'Civic', 'Manual', 100300, 'Rojo', 14999.00, 2017, 'Gasolina', 'Honda Civic bien cuidado.', 4.3, '/App_Images/vehiculos/honda_civic_rojo.jpg', 1, 'jcz'),
(3, 3, 'Focus', 'Manual', 101607, 'Gris oscuro', 12899.00, 2016, 'Diesel', 'Ford Focus con bajo consumo de combustible.', 4.0, '/App_Images/vehiculos/ford_focus_grisOscuro.jpg', 1, 'jcz'),
(4, 4, 'Trax', 'Manual', 131821, 'Blanco', 10199.00, 2013, 'Diesel', 'Chevrolet Trax muy comodo para la familia.', 4.6, '/App_Images/vehiculos/chevrolet_trax_blanco.jpg', 1, 'davidc90'),
(5, 5, 'Golf', 'Manual', 122676, 'Gris', 15399.00, 2013, 'Gasolina', 'Volkswagen Golf en perfecto estado.', 4.8, '/App_Images/vehiculos/volkswagen_golf_gris.jpg', 1, 'omr'),
(6, 6, '3 Series', 'Automático', 86352, 'Blanco', 25299.00, 2020, 'Gasolina', 'BMW 3 Series en excelente estado.', 4.6, '/App_Images/vehiculos/bmw_3series_blanco.jpg', 1, 'omr'),
(7, 7, 'C-Class', 'Automático', 73813, 'Gris', 27099.00, 2019, 'Diesel', 'Mercedes-Benz C-Class bien cuidado.', 4.7, '/App_Images/vehiculos/mercedes_C-Class_gris.jpg', 0, 'laura89'),
(8, 8, 'A4', 'Manual', 101173, 'Negro', 22299.00, 2017, 'Diesel', 'Audi A4 con bajo consumo de combustible.', 4.4, '/App_Images/vehiculos/audi_a4_negro.jpg', 0, 'dqm'),
(9, 9, 'Kona', 'Automático', 47044, 'Gris oscuro', 19618.00, 2022, 'Híbrido', 'Hyundai Kona con carga eléctrica rapida y mucha autonomía.', 4.5, '/App_Images/vehiculos/hyundai_kona_grisOscuro.jpg', 0, 'dqm'),
(10, 10, 'Sportage', 'Manual', 155509, 'Blanco', 9799.00, 2013, 'Gasolina', 'Kia Sportage en perfecto estado.', 3.9, '/App_Images/vehiculos/kia_sportage_blanco.jpg', 0, 'sergio92'),
(11, 11, 'Forester', 'Automático', 29193, 'Verde oscuro', 26666.00, 2019, 'Híbrido', 'Subaru Forester en excelente estado.', 4.5, '/App_Images/vehiculos/subaru_forester_verdeOscuro.jpg', 0, 'yc'),
(12, 12, 'CX-30', 'Automático', 25014, 'Azul medianoche', 23428.00, 2020, 'Gasolina', 'Mazda CX-30 bien cuidado.', 4.4, '/App_Images/vehiculos/mazda_cx-30_azulMedianoche.jpg', 0, 'yc'),
(13, 13, 'Qashqai', 'Manual', 22535, 'Negro', 19237.00, 2021, 'Gasolina', 'Nissan Qashqai con bajo kilometraje.', 4.3, '/App_Images/vehiculos/nissan_qashqai_negro.jpg', 0, 'julialopez'),
(14, 14, 'Compass', 'Manual', 145995, 'Blanco', 15799.00, 2018, 'Diesel', 'Jeep Compass para aventuras todoterreno.', 4.7, '/App_Images/vehiculos/jeep_compass_blanco.jpg', 0, 'rc'),
(15, 15, '500', 'Manual', 131635, 'Gris', 6899.00, 2014, 'Gasolina', 'Fiat 500 perfecto para la ciudad.', 4.0, '/App_Images/vehiculos/fiat_500_gris.jpg', 0, 'rc'),
(16, 16, 'Clio', 'Manual', 10462, 'Azul', 20094.00, 2023, 'Gasolina', 'Renault Clio económico y fiable.', 4.1, '/App_Images/vehiculos/renault_clio_azul.jpg', 0, 'ana_rodr'),
(17, 17, '208', 'Manual', 58070, 'Plata', 10570.00, 2019, 'Diesel', 'Peugeot 208 en buen estado general.', 4.2, '/App_Images/vehiculos/peugot_208_plata.jpg', 0, 'hrv'),
(18, 18, 'XC60', 'Manual', 156338, 'Blanco', 14599.00, 2014, 'Diesel', 'Volvo XC60 con todas las comodidades.', 4.9, '/App_Images/vehiculos/volvo_xc60_blanco.jpg', 0, 'hrv'),
(19, 19, 'Discovery 5', 'Manual', 70157, 'Negro', 30099.00, 2017, 'Diesel', 'Land Rover Discovery 5, lujo y potencia.', 5.0, '/App_Images/vehiculos/landRover_discovery5_negro.jpg', 0, 'hrv'),
(20, 20, 'L 200', 'Manual', 33333, 'Blanco', 27523.00, 2021, 'Diesel', 'Mitsubishi L 200 espacioso y cómodo.', 4.6, '/App_Images/vehiculos/mitsubishi_l200_blanco.jpg', 0, 'jcz'),
(21, 21, 'Swift', 'Manual', 94651, 'Rojo', 12666.00, 2019, 'Gasolina', 'Suzuki Swift ágil y divertido de conducir.', 4.2, '/App_Images/vehiculos/suzuki_swift_rojo.jpg', 0, 'pedro_m'),
(22, 22, 'UX-Serie', 'Automático', 53806, 'Blanco', 24475.00, 2020, 'Híbrido', 'Lexus UX-Serie con un diseño sofisticado.', 4.9, '/App_Images/vehiculos/lexus-uxSerie_blanco.jpg', 0, 'maria87'),
(23, 23, 'Zafira Tourer','Manual', 84596, 'Blanco', 11499.00, 2016, 'Gasolina', 'Opel Zafira Tourer en excelente estado, bajo consumo de combustible.', 4.5, '/App_Images/vehiculos/opel_zafiraTourer_blanco.jpg', 0, 'user123');

-- Inserts para la tabla Pedido
INSERT INTO pedido (pedido_id, comprador_UName, vendedor_UName, fecha_pedido, total) VALUES
(1, 'user123', 'lucia77', '2024-03-14', 19999.00),
(2, 'mario_g', 'jcz', '2024-03-15', 14999.00),
(3, 'lucia77', 'jcz', '2024-02-10', 12899.00),
(4, 'ana_rodr', 'davidc90', '2024-04-20', 10199.00),
(5, 'davidc90', 'omr', '2023-12-21', 15399.00),
(6, 'laura89', 'omr', '2024-02-14', 25299.00);

-- Inserts para la tabla Lineapedido
INSERT INTO lineapedido (linea_pedido_id, pedido_id, comprador_UName,vehiculo_id, importe) VALUES
(1, 1, 'user123', 1, 19999.00),
(2, 2, 'mario_g', 2, 14999.00),
(3, 3, 'lucia77', 3, 12899.00),
(4, 4, 'ana_rodr', 4, 10199.00),
(5, 5, 'davidc90', 5, 15399.00),
(6, 6, 'laura89', 6, 25299.00);

-- Inserts para la tabla BandejaNotificacion
INSERT INTO bandejaNotificacion (usuario_UName) VALUES
('user123'),
('mario_g'),
('lucia77'),
('ana_rodr'),
('davidc90'),
('laura89'),
('lucia77'),
('jcz'),
('jcz'),
('davidc90'),
('omr'),
('omr');

-- Inserts para la tabla LineaBandejaNotificacion
INSERT INTO lineaBandejaNotificacion (notificacion_id, tipo_notificacion, fecha_notificacion, vehiculo_id) VALUES
(1, 'Compra', '2024-03-14', 1),
(2, 'Compra', '2024-03-15', 2),
(3, 'Compra', '2024-02-10', 3),
(4, 'Compra', '2024-04-20', 4),
(5, 'Compra', '2023-12-21', 5),
(6, 'Compra', '2024-02-14', 6),
(7, 'Venta', '2024-03-14', 1),
(8, 'Venta', '2024-03-15', 2),
(9, 'Venta', '2024-02-10', 3),
(10, 'Venta', '2024-04-20', 4),
(11, 'Venta', '2023-12-21', 5),
(12, 'Venta', '2024-02-14', 6);

-- Inserts para la tabla Carrito
INSERT INTO carrito (usuario_UName) VALUES
('user123'),
('mario_g'),
('lucia77'),
('ana_rodr'),
('davidc90'),
('laura89');

-- Inserts para la tabla Lineacarrito
INSERT INTO lineacarrito (carrito_id, vehiculo_id,usuario_UName, importe) VALUES
(1, 7, 'user123', 27099.00),
(2, 8, 'mario_g', 22299.00),
(3, 9, 'lucia77', 19618.00),
(4, 10, 'ana_rodr', 9799.00),
(5, 11, 'davidc90', 26666.00),
(6, 12, 'laura89', 23428.00);

-- Inserts para la tabla Comentarios
INSERT INTO comentarios (comentario_id, vehiculo_id, usuario_UName, comentario, fecha_comentario) VALUES
(1,1, 'user123', '¡Excelente coche! Estoy muy satisfecho con mi compra.','2023-03-14'),
(2,2, 'mario_g', 'El color rojo le da un aspecto muy deportivo.','2024-01-24'),
(3,3, 'lucia77', 'Muy cómodo y espacioso.','2024-04-11'),
(4,4, 'ana_rodr', 'Gran relación calidad-precio.','2023-12-04'),
(5,5, 'davidc90', 'Muy buen rendimiento en carretera.','2024-02-28'),
(6,6, 'laura89', '¡Me encanta la sensación de lujo!','2024-02-29'),
(7,7, 'mario_g', 'El blanco le da un toque elegante.','2023-10-02'),
(8,8, 'ana_rodr', 'Excelente relación calidad-precio.','2024-05-16'),
(9,9, 'lucia77', 'Muy práctico para la ciudad.','2023-11-22'),
(10,10, 'user123', 'Gran espacio interior.','2024-01-31'),
(11,11, 'davidc90', 'Buena relación calidad-precio.','2024-01-01'),
(12,12, 'laura89', '¡Me encanta su diseño!','2024-02-21'),
(13,13, 'lucia77', 'Muy económico en consumo de combustible.','2024-02-14'),
(14,14, 'ana_rodr', 'Perfecto para aventuras todoterreno.','2024-08-01'),
(15,15, 'mario_g', 'Ideal para desplazamientos urbanos.','2024-06-06'),
(16,16, 'davidc90', 'Gran agilidad en la conducción.','2024-07-18'),
(17,17, 'laura89', 'Excelente opción para la ciudad.','2023-10-08'),
(18,18, 'user123', 'Muy confortable y seguro.','2024-03-14'),
(19,19, 'ana_rodr', 'Potente y espacioso.','2024-04-01'),
(20,20, 'mario_g', 'Robusto y fiable.','2024-06-24'),
(21,21, 'davidc90', 'Ágil y divertido de conducir.','2023-03-23'),
(22,22, 'laura89', 'Diseño sofisticado y elegante.','2024-04-24'),
(23,23, 'lucia77', 'Muy práctico y versátil.','2024-11-11');

-- Inserts para la tabla Lista_favoritos
INSERT INTO lista_favoritos (usuario_UName, vehiculo_id) VALUES
('user123', 13),
('user123', 14),
('user123', 15),
('mario_g', 16),
('mario_g', 17),
('mario_g', 18),
('lucia77', 19),
('lucia77', 20),
('lucia77', 21),
('ana_rodr', 22),
('ana_rodr', 23),
('ana_rodr', 1),
('davidc90', 2),
('davidc90', 3),
('davidc90', 4),
('laura89', 5),
('laura89', 6),
('laura89', 7);


-- Inserts para la tabla Metodos_pago
INSERT INTO metodos_pago (numTarjeta, cvv, mes_cad, anyo_cad, usuario) VALUES
('1234567890123456', '123', 12, 2025, 'user123'),
('9876543210987654', '456', 11, 2024, 'mario_g'),
('8765432109876543', '789', 10, 2024, 'lucia77'),
('5678901234567890', '321', 9, 2025, 'ana_rodr'),
('4567890123456789', '654', 8, 2024, 'davidc90'),
('3456789012345678', '987', 7, 2023, 'laura89');

-- Inserts para la tabla Consejos
INSERT INTO consejos (consejo_id, categoria, pregunta, respuesta)VALUES
(1, 'Compras', '¿Por qué OnlyCars ofrece la mejor experiencia del mercado?', 'Con OnlyCars siempre tendrás la confianza de haber hecho una buena compra. Desde que aterrizas en nuestra web, conocerás el estado exacto del coche de buena mano que vas a llevarte, gracias a que mostramos un croquis especificando las pequeñas imperfecciones que pueda tener el vehículo debido a su propia historia. Te aseguramos una compra sin temor a desperfectos o vicios ocultos. Además, encontrarás un solo precio, sin regateos ni dobles intenciones. Y si después de todo esto no estás completamente seguro de tu compra, dispondrás de 15 días o 1000 kilómetros de tranquilidad para probar y devolver tu coche, sin preguntas y con reembolso del 100%.'),
(2, 'Compras', '¿Cómo se que funciona todo en el coche como debería?', 'En OnlyCars sólo encontrarás coches con un historial libre de accidentes o averías. Además de facilitarte el informe de la certificación de 320 puntos, nuestros certificadores estarán a tu disposición para cualquier duda.'),
(3, 'Compras', '¿Por qué es la experiencia de compra mas cómoda?', 'Llevamos el coche al lugar que nos indiques. Hacemos todos los papeleos y estamos a tu disposición para cualquier duda que pueda surgirte durante todo el proceso.'),
(4, 'Ventas', '¿Puedo vender mi coche sin comprar un coche de OnlyCars?', '¡Por supuesto! Siempre que el vehículo que quieras vender cumpla con los requisitos de OnlyCars, podrás vender tu coche con nosotros, aunque no estés interesado en adquirir uno nuevo.'),
(5, 'Ventas', '¿Por qué vender mi coche en OnlyCars es una experiencia segura y fiable?', 'Somos líderes en Europa en la venta de coches online, ofrecemos tasaciones de mercado por encima de la media y además no tendrás costes extras, nosotros asumimos el cambio de titularidad del vehículo.'),
(6, 'Ventas', '¿Puedo vender un coche de empresa?', 'Sí, es posible vender un coche de empresa con Clicars.
Para ello, debes facilitarnos la siguiente documentación:
	-Las escrituras de la empresa, dónde figura el administrador
	-CIF de la empresa y DNI del administrador. El contrato de compraventa sólo podrá ser firmado por el administrador
	-Factura de venta a Clicars'),
(7,'Garantía OnlyCars', '¿En que consiste la garantía OnlyCars?', 'La Garantía OnlyCars cubre las reparaciones de un fallo mecánico, eléctrico y electrónico de carácter fortuito e imprevisto y de origen interno para un funcionamiento normal del vehículo.'),
(8, 'Garantía Onlycars', '¿Qué cubre la garantía OnlyCars?', 'La Garantía Premium incluye vehículo de sustitución a partir del tercer día de inmovilización en taller (sujeto a condiciones). Además de:
	-Motor
	-Caja de cambios
	-Turbo
	-EGR
	-Sistema anticontaminación
	-Sistema de refrigeración
	-Sistema de alimentación
	-Sistema de GLP/GNC (si el vh lo equipa)
	-Sistema de lubricación
	-Sistema de dirección
	-Sistema de seguridad
	-Sistema eléctrico
	-Sistema Infoentretenimiento
	-Circuito de climatización
	-Embrague
	-Volante motor
	-Batería de arranque
	-Faros y pilotos LED
La Garantía Premium OnlyCars será de aplicación para las averías que se produzcan, exclusivamente, en España.'),
(9, 'Garantía OnlyCars', '¿Qué no cubre la garantía OnlyCars?', 'Las piezas cuando el fallo se deba al uso y desgaste normal del coche, como, por ejemplo, los elementos que deban ser sustituidos conforme el plan de mantenimiento del mismo.
	-Las baterías de alta tensión o baterías de empuje en coches eléctricos e híbridos, cualquiera que sea su 
	 tipología, como eléctrico de baterías o 100% eléctrico (VEB), eléctrico de autonomía extendida (EVER), 
	híbrido (HEV) o híbrido enchufable (PHEV).
	-En coches a gas (GNC / GLP), no se contempla la revisión para pasar el certificado de estanqueidad de
	 los depósitos (requisito, que esté vigente para pasar ITV).
	-Elementos de carrocería, pintura, neumáticos, llantas y tapacubos.
	-Los accesorios no montados durante el proceso de fabricación del coche.
	-Equipamiento de confort (a menos que se deba a un fallo eléctrico / electrónico)
	-Reparaciones preventivas
	-La línea completa de escape (del colector al silenciador). FAP . Catalizador
	-Usos inapropiados del vehículo y fuerza mayor. Como por ejemplo: robos, incendios.'),
(10, 'Servicio de mantenimiento', '¿Qué es el servicio de mantenimiento?', 'El mantenimiento de un coche es el conjunto de tareas y revisiones que se realizan de forma periódica para garantizar su correcto funcionamiento y seguridad. La revisión debe hacerse de manera regular o bien por kilometraje o según los años que indique el fabricante.
Cabe destacar que no lo debemos confundir con el seguro de tu coche.'),
(11, 'Servicio de mantenimiento', '¿Qué incluye el servicio de mantenimiento?', 
'          -Cambio de aceite de motor según intervalo, cantidad y especificaciones del fabricante.
	-Cambio del filtro de aceite, filtro incluido, cuando lo especifique el fabricante.
	-Cambio del filtro de aire, filtro incluido, cuando lo especifique el fabricante.
	-Cambio del filtro de habitáculo, filtro incluido, cuando lo especifique el fabricante.
	-Cambio del filtro de combustible, filtro incluido, cuando lo especifique el fabricante.
	-Puesta a nivel de refrigerante, líquido lavaparabrisas y líquido dirección asistida.
	-Restablecimiento del testigo de revisión.
	-30 puntos de control de los diferentes sistemas del vehículo.'),
(12, 'Servicio de mantenimiento', '¿Puedo contratar el seguro de mi coche en OnlyCars?', '¡Por supuesto! En OnlyCars nos preocupamos por tu seguridad en las carreteras. Si nos lo permites, facilitamos tus datos a nuestra aseguradora colaboradora, Mutua Madrileña, que te ofrecerá una póliza adaptada a tus necesidades y preferencias. Así, tendrás la tranquilidad de contar con una protección completa para tu coche.');DROP TABLE IF EXISTS metodos_pago;
DROP TABLE IF EXISTS lista_favoritos;
DROP TABLE IF EXISTS comentarios;
DROP TABLE IF EXISTS lineacarrito;
DROP TABLE IF EXISTS carrito;
DROP TABLE IF EXISTS lineapedido;
DROP TABLE IF EXISTS pedido;
DROP TABLE IF EXISTS lineaBandejaNotificacion;
DROP TABLE IF EXISTS bandejaNotificacion;
DROP TABLE IF EXISTS vehiculo;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS marcas;
DROP TABLE IF EXISTS consejos;

-- Crear la tabla Consejos
CREATE TABLE consejos (
    consejo_id INT PRIMARY KEY,
    categoria VARCHAR(50),
    pregunta TEXT,
    respuesta TEXT
);

-- Crear la tabla Marca
CREATE TABLE marcas (
    marca_id INT PRIMARY KEY,
    marca VARCHAR(45) NOT NULL
);

-- Crear la tabla Usuarios
CREATE TABLE usuarios (
    username VARCHAR(50) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(50) NOT NULL,
    telefono VARCHAR(18),
    contrasenya VARCHAR(30) NOT NULL,
    calle VARCHAR(50),
    localidad VARCHAR(45),
    provincia VARCHAR(45),
    codigo_postal VARCHAR(6),
    email VARCHAR(45),
    admin INT NOT NULL DEFAULT 0
);

-- Crear la tabla Vehiculo
CREATE TABLE vehiculo (
    vehiculo_id INT PRIMARY key,
    marca_id INT,
    modelo VARCHAR(45) NOT NULL,
    auto_manu VARCHAR(45) NOT NULL,
    kilometraje INT NOT NULL,
    color VARCHAR(45),
    precio decimal(10,2) NOT NULL,
    anyo INT,
    combustible VARCHAR(45) NOT NULL,
    descripcion VARCHAR(200),
    valoracion decimal(2,1),
    url_imagen VARCHAR(100),
    vendido INT NOT NULL DEFAULT 0,
    vendedor_UName VARCHAR(50) NOT NULL,
    CONSTRAINT FK_VEHICULO_MARCA FOREIGN KEY (marca_id) REFERENCES marcas(marca_id)
        on delete set null
        on update CASCADE,
    CONSTRAINT FK_VEHICULO_USUARIO FOREIGN KEY (vendedor_UName) REFERENCES usuarios(username)
        on delete CASCADE
        on update CASCADE
);

-- Crear la tabla Bandejanotificacion
CREATE TABLE bandejaNotificacion (
    notificacion_id INT PRIMARY KEY,
    usuario_UName VARCHAR(50) NOT NULL,
    CONSTRAINT FK_BANDEJANOTIFICACION_USUARIO FOREIGN KEY (usuario_UName) REFERENCES usuarios(username)
        on delete CASCADE
        on update CASCADE
);

-- Crear la tabla LineaBandejanotificacion
CREATE TABLE lineaBandejaNotificacion (
    linea_id INT,
    notificacion_id INT,
    tipo_notificacion VARCHAR(50) NOT NULL,
    fecha_notificacion date not null,
    vehiculo_id INT NOT NULL,
    CONSTRAINT PK_LINEA_BANDEJANOTIFICACION PRIMARY KEY (linea_id, notificacion_id),
    CONSTRAINT FK_LINEA_BANDEJANOTIFICACION_VEHICULO FOREIGN KEY (vehiculo_id) REFERENCES vehiculo(vehiculo_id)
        on delete CASCADE
        on update CASCADE,
    CONSTRAINT FK_LINEA_BANDEJANOTIFICACION_BANDEJA FOREIGN KEY (notificacion_id) REFERENCES bandejaNotificacion(notificacion_id)
        on delete no action
        on update no action
);

-- Crear la tabla Pedido
CREATE TABLE pedido (
    pedido_id INT PRIMARY KEY,
    comprador_UName VARCHAR(50) NOT NULL,
    vendedor_UName VARCHAR(50) NOT NULL,
    fecha_pedido date not null,
    total DECIMAL(10, 2) NOT NULL,
    CONSTRAINT FK_PEDIDO_USUARIO_VENDEDOR FOREIGN key (vendedor_UName) references usuarios (username)
  		on delete CASCADE
  		on update Cascade,
    CONSTRAINT FK_PEDIDO_USUARIO_COMPRADOR FOREIGN key (comprador_UName) references usuarios (username)
  		on delete no action
  		on update no action
);

-- Crear la tabla Lineapedido
CREATE TABLE lineapedido (
    linea_pedido_id INT,
    pedido_id INT,
    comprador_UName VARCHAR(50) NOT NULL,
    vehiculo_id INT NOT NULL,
    importe DECIMAL(10, 2) NOT NULL,
    CONSTRAINT PK_LINPEDIDO PRIMARY key (linea_pedido_id, pedido_id),
  	CONSTRAINT FK_LINPEDIDO_PEDIDO FOREIGN key (pedido_id) references pedido (pedido_id)
  		on delete CASCADE
  		on update Cascade,
  	CONSTRAINT FK_LINPEDIDO_VEHICULO FOREIGN key (vehiculo_id) references vehiculo (vehiculo_id)
  		on update no action
  		on delete no action
);

-- Crear la tabla Carrito con carrito_id auto-incremental
CREATE TABLE carrito (
    carrito_id INT IDENTITY(1,1) PRIMARY KEY,
    usuario_UName VARCHAR(50) NOT NULL,
    CONSTRAINT FK_CARRITO_USUARIO FOREIGN KEY (usuario_UName) REFERENCES usuarios (username)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Crear la tabla Lineacarrito
CREATE TABLE lineacarrito (
    linea_carrito_id INT IDENTITY(1,1) NOT NULL,
    carrito_id INT NOT NULL,
    vehiculo_id INT NOT NULL,
    usuario_UName VARCHAR(50) NOT NULL,
    importe DECIMAL(10, 2) NOT NULL,
    CONSTRAINT PK_LINCARRITO PRIMARY KEY (linea_carrito_id, carrito_id),
    CONSTRAINT FK_LINCARRITO_CARRITO FOREIGN KEY (carrito_id) REFERENCES carrito (carrito_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT FK_LINCARRITO_VEHICULO FOREIGN KEY (vehiculo_id) REFERENCES vehiculo (vehiculo_id)
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);

-- Crear la tabla Comentarios
CREATE TABLE comentarios (
    comentario_id INT PRIMARY KEY,
    vehiculo_id INT NOT NULL,
    usuario_UName VARCHAR(50) NOT NULL,
    comentario VARCHAR(200) NOT NULL,
    fecha_comentario date not null,
    CONSTRAINT FK_COMENTARIOS_VEHICULO FOREIGN KEY (vehiculo_id) REFERENCES vehiculo(vehiculo_id)
        on delete CASCADE
        on update CASCADE,
    CONSTRAINT FK_COMENTARIOS_USUARIO FOREIGN KEY (usuario_UName) REFERENCES usuarios(username)
        on delete no action
        on update no action
);

-- Crear la tabla Lista_favoritos
CREATE TABLE lista_favoritos (
    lista_favorito_id INT IDENTITY(1,1) NOT NULL,
    usuario_UName VARCHAR(50) NOT NULL,
    vehiculo_id INT NOT NULL,
    CONSTRAINT FK_LISTAFAVORITOS_USUARIO FOREIGN KEY (usuario_UName) REFERENCES usuarios(username)
        on delete CASCADE
        on update CASCADE,
    CONSTRAINT FK_LISTAFAVORITOS_VEHICULO FOREIGN KEY (vehiculo_id) REFERENCES vehiculo(vehiculo_id)
        on delete no action
        on update no action
);

-- Crear la tabla Metodos_pago
CREATE TABLE metodos_pago (
    numTarjeta varchar(16) PRIMARY key,
  	cvv varchar(3) null,
  	mes_cad int not null,
  	anyo_cad int not null,
  	usuario varchar(50) not null,
  	CONSTRAINT FK_TARJETA_USUARIO FOREIGN key (usuario) references usuarios (username)
  		on delete CASCADE
  		on update cascade
);

-- Inserts para la tabla Marca
INSERT INTO marcas (marca_id, marca) VALUES
(1, 'Toyota'),
(2, 'Honda'),
(3, 'Ford'),
(4, 'Chevrolet'),
(5, 'Volkswagen'),
(6, 'BMW'),
(7, 'Mercedes-Benz'),
(8, 'Audi'),
(9, 'Hyundai'),
(10, 'Kia'),
(11, 'Subaru'),
(12, 'Mazda'),
(13, 'Nissan'),
(14, 'Jeep'),
(15, 'Fiat'),
(16, 'Renault'),
(17, 'Peugeot'),
(18, 'Volvo'),
(19, 'Land Rover'),
(20, 'Mitsubishi'),
(21, 'Suzuki'),
(22, 'Lexus'),
(23, 'Opel');

-- Inserts para la tabla Usuarios
INSERT INTO usuarios (username, nombre, apellidos, telefono, contrasenya, calle, localidad, provincia, codigo_postal, email, admin) VALUES
('jcz', 'Jiahao', 'Chen Zhou', '611222333', '123456', 'Serrano, nº3, 6ºA', 'Alicante', 'Alicante', '03003', 'jcz13@gcloud.ua.es', 1),
('hrv', 'Hugo', 'Redondo Valdés', '626333770', 'contrasenya', 'Gran Via, nº2, 8ºB', 'Alicante', 'Alicante', '03402', 'hrvr1@gcloud.ua.es', 1),
('omr', 'Oscar', 'Massanet Robles', '611654326', '060504', 'Bono Guarner, nº12, 3ºC', 'Alicante', 'Alicante', '03005', 'omr10@gcloud.ua.es', 1),
('dqm', 'David', 'Quevedo Mora', '625421300', '012345', 'Pinto, nº1, 1ºA', 'Alicante', 'Alicante', '03008', 'dqm2@gcloud.ua.es', 1),
('yc', 'Yamina', 'Chibane', '602426879', '063215', 'Gabinete, nº11, 2ºB', 'Alicante', 'Alicante', '03006', 'yc27@gcloud.ua.es', 1),
('rc', 'Rahma', 'Chibane', '611259249', '078093', 'Pintor, nº9, 8ºC', 'Alicante', 'Alicante', '03030', 'rc75@gcloud.ua.es', 1),
('user123', 'Juan', 'García', '611234567', '1234', 'Calle Principal', 'Madrid', 'Madrid', '28001', 'juan@example.com', 0),
('maria87', 'María', 'López', '622345678', '7654', 'Avenida Central', 'Barcelona', 'Barcelona', '08001', 'maria@example.com', 0),
('pedro_m', 'Pedro', 'Martínez', '633456789', '4567', 'Calle Mayor', 'Valencia', 'Valencia', '46001', 'pedro@example.com', 0),
('ana_rodr', 'Ana', 'Rodríguez', '644567890', '2345', 'Plaza Principal', 'Sevilla', 'Sevilla', '41001', 'ana@example.com', 0),
('lucia77', 'Lucía', 'Gómez', '655678901', '9876', 'Paseo Central', 'Málaga', 'Málaga', '29001', 'lucia@example.com', 0),
('davidc90', 'David', 'Cruz', '666789012', '3456', 'Calle Mayor', 'Madrid', 'Madrid', '28001', 'david@example.com', 0),
('laura89', 'Laura', 'Fernández', '677890123', '8765', 'Avenida Principal', 'Barcelona', 'Barcelona', '08001', 'laura@example.com', 0),
('sergio92', 'Sergio', 'Hernández', '688901234', '6543', 'Calle Mayor', 'Valencia', 'Valencia', '46001', 'sergio@example.com', 0),
('julialopez', 'Julia', 'López', '699012345', '5678', 'Plaza Mayor', 'Sevilla', 'Sevilla', '41001', 'julia@example.com', 0),
('mario_g', 'Mario', 'García', '600123456', '0123', 'Paseo Central', 'Málaga', 'Málaga', '29001', 'mario@example.com', 0);

-- Inserts para la tabla Vehiculo
INSERT INTO vehiculo (vehiculo_id, marca_id, modelo, auto_manu, kilometraje, color, precio, anyo, combustible, descripcion, valoracion, url_imagen, vendido, vendedor_UName) VALUES
(1, 1, 'Corolla', 'Manual', 71867, 'Blanco', 19999.00, 2019, 'Gasolina', 'Toyota Corolla en excelente estado.', 4.5, '/App_Images/vehiculos/toyota_corolla_blanco.jpg', 1, 'lucia77'),
(2, 2, 'Civic', 'Manual', 100300, 'Rojo', 14999.00, 2017, 'Gasolina', 'Honda Civic bien cuidado.', 4.3, '/App_Images/vehiculos/honda_civic_rojo.jpg', 1, 'jcz'),
(3, 3, 'Focus', 'Manual', 101607, 'Gris oscuro', 12899.00, 2016, 'Diesel', 'Ford Focus con bajo consumo de combustible.', 4.0, '/App_Images/vehiculos/ford_focus_grisOscuro.jpg', 1, 'jcz'),
(4, 4, 'Trax', 'Manual', 131821, 'Blanco', 10199.00, 2013, 'Diesel', 'Chevrolet Trax muy comodo para la familia.', 4.6, '/App_Images/vehiculos/chevrolet_trax_blanco.jpg', 1, 'davidc90'),
(5, 5, 'Golf', 'Manual', 122676, 'Gris', 15399.00, 2013, 'Gasolina', 'Volkswagen Golf en perfecto estado.', 4.8, '/App_Images/vehiculos/volkswagen_golf_gris.jpg', 1, 'omr'),
(6, 6, '3 Series', 'Automático', 86352, 'Blanco', 25299.00, 2020, 'Gasolina', 'BMW 3 Series en excelente estado.', 4.6, '/App_Images/vehiculos/bmw_3series_blanco.jpg', 1, 'omr'),
(7, 7, 'C-Class', 'Automático', 73813, 'Gris', 27099.00, 2019, 'Diesel', 'Mercedes-Benz C-Class bien cuidado.', 4.7, '/App_Images/vehiculos/mercedes_C-Class_gris.jpg', 0, 'laura89'),
(8, 8, 'A4', 'Manual', 101173, 'Negro', 22299.00, 2017, 'Diesel', 'Audi A4 con bajo consumo de combustible.', 4.4, '/App_Images/vehiculos/audi_a4_negro.jpg', 0, 'dqm'),
(9, 9, 'Kona', 'Automático', 47044, 'Gris oscuro', 19618.00, 2022, 'Híbrido', 'Hyundai Kona con carga eléctrica rapida y mucha autonomía.', 4.5, '/App_Images/vehiculos/hyundai_kona_grisOscuro.jpg', 0, 'dqm'),
(10, 10, 'Sportage', 'Manual', 155509, 'Blanco', 9799.00, 2013, 'Gasolina', 'Kia Sportage en perfecto estado.', 3.9, '/App_Images/vehiculos/kia_sportage_blanco.jpg', 0, 'sergio92'),
(11, 11, 'Forester', 'Automático', 29193, 'Verde oscuro', 26666.00, 2019, 'Híbrido', 'Subaru Forester en excelente estado.', 4.5, '/App_Images/vehiculos/subaru_forester_verdeOscuro.jpg', 0, 'yc'),
(12, 12, 'CX-30', 'Automático', 25014, 'Azul medianoche', 23428.00, 2020, 'Gasolina', 'Mazda CX-30 bien cuidado.', 4.4, '/App_Images/vehiculos/mazda_cx-30_azulMedianoche.jpg', 0, 'yc'),
(13, 13, 'Qashqai', 'Manual', 22535, 'Negro', 19237.00, 2021, 'Gasolina', 'Nissan Qashqai con bajo kilometraje.', 4.3, '/App_Images/vehiculos/nissan_qashqai_negro.jpg', 0, 'julialopez'),
(14, 14, 'Compass', 'Manual', 145995, 'Blanco', 15799.00, 2018, 'Diesel', 'Jeep Compass para aventuras todoterreno.', 4.7, '/App_Images/vehiculos/jeep_compass_blanco.jpg', 0, 'rc'),
(15, 15, '500', 'Manual', 131635, 'Gris', 6899.00, 2014, 'Gasolina', 'Fiat 500 perfecto para la ciudad.', 4.0, '/App_Images/vehiculos/fiat_500_gris.jpg', 0, 'rc'),
(16, 16, 'Clio', 'Manual', 10462, 'Azul', 20094.00, 2023, 'Gasolina', 'Renault Clio económico y fiable.', 4.1, '/App_Images/vehiculos/renault_clio_azul.jpg', 0, 'ana_rodr'),
(17, 17, '208', 'Manual', 58070, 'Plata', 10570.00, 2019, 'Diesel', 'Peugeot 208 en buen estado general.', 4.2, '/App_Images/vehiculos/peugot_208_plata.jpg', 0, 'hrv'),
(18, 18, 'XC60', 'Manual', 156338, 'Blanco', 14599.00, 2014, 'Diesel', 'Volvo XC60 con todas las comodidades.', 4.9, '/App_Images/vehiculos/volvo_xc60_blanco.jpg', 0, 'hrv'),
(19, 19, 'Discovery 5', 'Manual', 70157, 'Negro', 30099.00, 2017, 'Diesel', 'Land Rover Discovery 5, lujo y potencia.', 5.0, '/App_Images/vehiculos/landRover_discovery5_negro.jpg', 0, 'hrv'),
(20, 20, 'L 200', 'Manual', 33333, 'Blanco', 27523.00, 2021, 'Diesel', 'Mitsubishi L 200 espacioso y cómodo.', 4.6, '/App_Images/vehiculos/mitsubishi_l200_blanco.jpg', 0, 'jcz'),
(21, 21, 'Swift', 'Manual', 94651, 'Rojo', 12666.00, 2019, 'Gasolina', 'Suzuki Swift ágil y divertido de conducir.', 4.2, '/App_Images/vehiculos/suzuki_swift_rojo.jpg', 0, 'pedro_m'),
(22, 22, 'UX-Serie', 'Automático', 53806, 'Blanco', 24475.00, 2020, 'Híbrido', 'Lexus UX-Serie con un diseño sofisticado.', 4.9, '/App_Images/vehiculos/lexus-uxSerie_blanco.jpg', 0, 'maria87'),
(23, 23, 'Zafira Tourer','Manual', 84596, 'Blanco', 11499.00, 2016, 'Gasolina', 'Opel Zafira Tourer en excelente estado, bajo consumo de combustible.', 4.5, '/App_Images/vehiculos/opel_zafiraTourer_blanco.jpg', 0, 'user123');

-- Inserts para la tabla Pedido
INSERT INTO pedido (pedido_id, comprador_UName, vendedor_UName, fecha_pedido, total) VALUES
(1, 'user123', 'lucia77', '2024-03-14', 19999.00),
(2, 'mario_g', 'jcz', '2024-03-15', 14999.00),
(3, 'lucia77', 'jcz', '2024-02-10', 12899.00),
(4, 'ana_rodr', 'davidc90', '2024-04-20', 10199.00),
(5, 'davidc90', 'omr', '2023-12-21', 15399.00),
(6, 'laura89', 'omr', '2024-02-14', 25299.00);

-- Inserts para la tabla Lineapedido
INSERT INTO lineapedido (linea_pedido_id, pedido_id, comprador_UName,vehiculo_id, importe) VALUES
(1, 1, 'user123', 1, 19999.00),
(2, 2, 'mario_g', 2, 14999.00),
(3, 3, 'lucia77', 3, 12899.00),
(4, 4, 'ana_rodr', 4, 10199.00),
(5, 5, 'davidc90', 5, 15399.00),
(6, 6, 'laura89', 6, 25299.00);

-- Inserts para la tabla BandejaNotificacion
INSERT INTO bandejaNotificacion (notificacion_id, usuario_UName) VALUES
(1, 'user123'),
(2, 'mario_g'),
(3, 'lucia77'),
(4, 'ana_rodr'),
(5, 'davidc90'),
(6, 'laura89'),
(7, 'lucia77'),
(8, 'jcz'),
(9, 'jcz'),
(10, 'davidc90'),
(11, 'omr'),
(12, 'omr');

-- Inserts para la tabla LineaBandejaNotificacion
INSERT INTO lineaBandejaNotificacion (linea_id, notificacion_id, tipo_notificacion, fecha_notificacion, vehiculo_id) VALUES
(1, 1, 'Compra', '2024-03-14', 1),
(2, 2, 'Compra', '2024-03-15', 2),
(3, 3, 'Compra', '2024-02-10', 3),
(4, 4, 'Compra', '2024-04-20', 4),
(5, 5, 'Compra', '2023-12-21', 5),
(6, 6, 'Compra', '2024-02-14', 6),
(7, 7, 'Venta', '2024-03-14', 1),
(8, 8, 'Venta', '2024-03-15', 2),
(9, 9, 'Venta', '2024-02-10', 3),
(10, 10, 'Venta', '2024-04-20', 4),
(11, 11, 'Venta', '2023-12-21', 5),
(12, 12, 'Venta', '2024-02-14', 6);

-- Inserts para la tabla Carrito
INSERT INTO carrito (usuario_UName) VALUES
('user123'),
('mario_g'),
('lucia77'),
('ana_rodr'),
('davidc90'),
('laura89');

-- Inserts para la tabla Lineacarrito
INSERT INTO lineacarrito (carrito_id, vehiculo_id,usuario_UName, importe) VALUES
(1, 7, 'user123', 27099.00),
(2, 8, 'mario_g', 22299.00),
(3, 9, 'lucia77', 19618.00),
(4, 10, 'ana_rodr', 9799.00),
(5, 11, 'davidc90', 26666.00),
(6, 12, 'laura89', 23428.00);

-- Inserts para la tabla Comentarios
INSERT INTO comentarios (comentario_id, vehiculo_id, usuario_UName, comentario, fecha_comentario) VALUES
(1,1, 'user123', '¡Excelente coche! Estoy muy satisfecho con mi compra.','2023-03-14'),
(2,2, 'mario_g', 'El color rojo le da un aspecto muy deportivo.','2024-01-24'),
(3,3, 'lucia77', 'Muy cómodo y espacioso.','2024-04-11'),
(4,4, 'ana_rodr', 'Gran relación calidad-precio.','2023-12-04'),
(5,5, 'davidc90', 'Muy buen rendimiento en carretera.','2024-02-28'),
(6,6, 'laura89', '¡Me encanta la sensación de lujo!','2024-02-29'),
(7,7, 'mario_g', 'El blanco le da un toque elegante.','2023-10-02'),
(8,8, 'ana_rodr', 'Excelente relación calidad-precio.','2024-05-16'),
(9,9, 'lucia77', 'Muy práctico para la ciudad.','2023-11-22'),
(10,10, 'user123', 'Gran espacio interior.','2024-01-31'),
(11,11, 'davidc90', 'Buena relación calidad-precio.','2024-01-01'),
(12,12, 'laura89', '¡Me encanta su diseño!','2024-02-21'),
(13,13, 'lucia77', 'Muy económico en consumo de combustible.','2024-02-14'),
(14,14, 'ana_rodr', 'Perfecto para aventuras todoterreno.','2024-08-01'),
(15,15, 'mario_g', 'Ideal para desplazamientos urbanos.','2024-06-06'),
(16,16, 'davidc90', 'Gran agilidad en la conducción.','2024-07-18'),
(17,17, 'laura89', 'Excelente opción para la ciudad.','2023-10-08'),
(18,18, 'user123', 'Muy confortable y seguro.','2024-03-14'),
(19,19, 'ana_rodr', 'Potente y espacioso.','2024-04-01'),
(20,20, 'mario_g', 'Robusto y fiable.','2024-06-24'),
(21,21, 'davidc90', 'Ágil y divertido de conducir.','2023-03-23'),
(22,22, 'laura89', 'Diseño sofisticado y elegante.','2024-04-24'),
(23,23, 'lucia77', 'Muy práctico y versátil.','2024-11-11');

-- Inserts para la tabla Lista_favoritos
INSERT INTO lista_favoritos (usuario_UName, vehiculo_id) VALUES
('user123', 13),
('user123', 14),
('user123', 15),
('mario_g', 16),
('mario_g', 17),
('mario_g', 18),
('lucia77', 19),
('lucia77', 20),
('lucia77', 21),
('ana_rodr', 22),
('ana_rodr', 23),
('ana_rodr', 1),
('davidc90', 2),
('davidc90', 3),
('davidc90', 4),
('laura89', 5),
('laura89', 6),
('laura89', 7);


-- Inserts para la tabla Metodos_pago
INSERT INTO metodos_pago (numTarjeta, cvv, mes_cad, anyo_cad, usuario) VALUES
('1234567890123456', '123', 12, 2025, 'user123'),
('9876543210987654', '456', 11, 2024, 'mario_g'),
('8765432109876543', '789', 10, 2024, 'lucia77'),
('5678901234567890', '321', 9, 2025, 'ana_rodr'),
('4567890123456789', '654', 8, 2024, 'davidc90'),
('3456789012345678', '987', 7, 2023, 'laura89');

-- Inserts para la tabla Consejos
INSERT INTO consejos (consejo_id, categoria, pregunta, respuesta)VALUES
(1, 'Compras', '¿Por qué OnlyCars ofrece la mejor experiencia del mercado?', 'Con OnlyCars siempre tendrás la confianza de haber hecho una buena compra. Desde que aterrizas en nuestra web, conocerás el estado exacto del coche de buena mano que vas a llevarte, gracias a que mostramos un croquis especificando las pequeñas imperfecciones que pueda tener el vehículo debido a su propia historia. Te aseguramos una compra sin temor a desperfectos o vicios ocultos. Además, encontrarás un solo precio, sin regateos ni dobles intenciones. Y si después de todo esto no estás completamente seguro de tu compra, dispondrás de 15 días o 1000 kilómetros de tranquilidad para probar y devolver tu coche, sin preguntas y con reembolso del 100%.'),
(2, 'Compras', '¿Cómo se que funciona todo en el coche como debería?', 'En OnlyCars sólo encontrarás coches con un historial libre de accidentes o averías. Además de facilitarte el informe de la certificación de 320 puntos, nuestros certificadores estarán a tu disposición para cualquier duda.'),
(3, 'Compras', '¿Por qué es la experiencia de compra mas cómoda?', 'Llevamos el coche al lugar que nos indiques. Hacemos todos los papeleos y estamos a tu disposición para cualquier duda que pueda surgirte durante todo el proceso.'),
(4, 'Ventas', '¿Puedo vender mi coche sin comprar un coche de OnlyCars?', '¡Por supuesto! Siempre que el vehículo que quieras vender cumpla con los requisitos de OnlyCars, podrás vender tu coche con nosotros, aunque no estés interesado en adquirir uno nuevo.'),
(5, 'Ventas', '¿Por qué vender mi coche en OnlyCars es una experiencia segura y fiable?', 'Somos líderes en Europa en la venta de coches online, ofrecemos tasaciones de mercado por encima de la media y además no tendrás costes extras, nosotros asumimos el cambio de titularidad del vehículo.'),
(6, 'Ventas', '¿Puedo vender un coche de empresa?', 'Sí, es posible vender un coche de empresa con Clicars.
Para ello, debes facilitarnos la siguiente documentación:
	-Las escrituras de la empresa, dónde figura el administrador
	-CIF de la empresa y DNI del administrador. El contrato de compraventa sólo podrá ser firmado por el administrador
	-Factura de venta a Clicars'),
(7,'Garantía OnlyCars', '¿En que consiste la garantía OnlyCars?', 'La Garantía OnlyCars cubre las reparaciones de un fallo mecánico, eléctrico y electrónico de carácter fortuito e imprevisto y de origen interno para un funcionamiento normal del vehículo.'),
(8, 'Garantía Onlycars', '¿Qué cubre la garantía OnlyCars?', 'La Garantía Premium incluye vehículo de sustitución a partir del tercer día de inmovilización en taller (sujeto a condiciones). Además de:
	-Motor
	-Caja de cambios
	-Turbo
	-EGR
	-Sistema anticontaminación
	-Sistema de refrigeración
	-Sistema de alimentación
	-Sistema de GLP/GNC (si el vh lo equipa)
	-Sistema de lubricación
	-Sistema de dirección
	-Sistema de seguridad
	-Sistema eléctrico
	-Sistema Infoentretenimiento
	-Circuito de climatización
	-Embrague
	-Volante motor
	-Batería de arranque
	-Faros y pilotos LED
La Garantía Premium OnlyCars será de aplicación para las averías que se produzcan, exclusivamente, en España.'),
(9, 'Garantía OnlyCars', '¿Qué no cubre la garantía OnlyCars?', 'Las piezas cuando el fallo se deba al uso y desgaste normal del coche, como, por ejemplo, los elementos que deban ser sustituidos conforme el plan de mantenimiento del mismo.
	-Las baterías de alta tensión o baterías de empuje en coches eléctricos e híbridos, cualquiera que sea su 
	 tipología, como eléctrico de baterías o 100% eléctrico (VEB), eléctrico de autonomía extendida (EVER), 
	híbrido (HEV) o híbrido enchufable (PHEV).
	-En coches a gas (GNC / GLP), no se contempla la revisión para pasar el certificado de estanqueidad de
	 los depósitos (requisito, que esté vigente para pasar ITV).
	-Elementos de carrocería, pintura, neumáticos, llantas y tapacubos.
	-Los accesorios no montados durante el proceso de fabricación del coche.
	-Equipamiento de confort (a menos que se deba a un fallo eléctrico / electrónico)
	-Reparaciones preventivas
	-La línea completa de escape (del colector al silenciador). FAP . Catalizador
	-Usos inapropiados del vehículo y fuerza mayor. Como por ejemplo: robos, incendios.'),
(10, 'Servicio de mantenimiento', '¿Qué es el servicio de mantenimiento?', 'El mantenimiento de un coche es el conjunto de tareas y revisiones que se realizan de forma periódica para garantizar su correcto funcionamiento y seguridad. La revisión debe hacerse de manera regular o bien por kilometraje o según los años que indique el fabricante.
Cabe destacar que no lo debemos confundir con el seguro de tu coche.'),
(11, 'Servicio de mantenimiento', '¿Qué incluye el servicio de mantenimiento?', 
'          -Cambio de aceite de motor según intervalo, cantidad y especificaciones del fabricante.
	-Cambio del filtro de aceite, filtro incluido, cuando lo especifique el fabricante.
	-Cambio del filtro de aire, filtro incluido, cuando lo especifique el fabricante.
	-Cambio del filtro de habitáculo, filtro incluido, cuando lo especifique el fabricante.
	-Cambio del filtro de combustible, filtro incluido, cuando lo especifique el fabricante.
	-Puesta a nivel de refrigerante, líquido lavaparabrisas y líquido dirección asistida.
	-Restablecimiento del testigo de revisión.
	-30 puntos de control de los diferentes sistemas del vehículo.'),
(12, 'Servicio de mantenimiento', '¿Puedo contratar el seguro de mi coche en OnlyCars?', '¡Por supuesto! En OnlyCars nos preocupamos por tu seguridad en las carreteras. Si nos lo permites, facilitamos tus datos a nuestra aseguradora colaboradora, Mutua Madrileña, que te ofrecerá una póliza adaptada a tus necesidades y preferencias. Así, tendrás la tranquilidad de contar con una protección completa para tu coche.');