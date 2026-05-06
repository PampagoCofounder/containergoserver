-- SQL script to create the empresa_comercio table con clave foranea de datos_empresa

CREATE TABLE empresa_comercio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT,
    cantidad_clientes INT,
    productos_importados INT,
    productos_exportados INT,
    costos DECIMAL(15,2),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
);