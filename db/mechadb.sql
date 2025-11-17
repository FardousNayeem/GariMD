USE mechaDB;

CREATE TABLE IF NOT EXISTS mechanics (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  capacity INT NOT NULL DEFAULT 4,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_name VARCHAR(150) NOT NULL,
  address TEXT,
  phone VARCHAR(30) NOT NULL,
  car_license VARCHAR(50) NOT NULL,
  car_engine VARCHAR(100) NOT NULL,
  appointment_date DATE NOT NULL,
  mechanic_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (mechanic_id) REFERENCES mechanics(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE UNIQUE INDEX IF NOT EXISTS ux_car_date ON appointments(car_engine, appointment_date);

INSERT INTO mechanics (name, capacity) VALUES
('Shareeful Islam', 4);
