CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);
INSERT INTO products (name, price) VALUES
('Banana Juice', 2.50),
('Mango Shake', 3.20),
('Avocado Smoothie', 4.00);
