CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    phone VARCHAR(15)
);

CREATE TABLE properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    city VARCHAR(50),
    price INT,
    gender VARCHAR(20),
    rating FLOAT,
    image VARCHAR(255),
    description TEXT
);

CREATE TABLE amenities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100)
);

CREATE TABLE property_amenities (
    property_id INT,
    amenity_id INT
);

CREATE TABLE interested_users (
    user_id INT,
    property_id INT
);

INSERT INTO properties
(name, city, price, gender, rating, image, description)
VALUES
('Sunshine PG','Ambala',6500,'Boys',4.5,'pg1.jpg','Comfortable PG near college.'),
('Green Residency','Kurukshetra',7000,'Girls',4.2,'pg2.jpg','Safe and secure accommodation.'),
('City Stay','Chandigarh',8500,'Co-Living',4.8,'pg3.jpg','Premium rooms with WiFi.'),
('Dream PG','Delhi',9000,'Girls',4.7,'pg4.jpg','Luxury student accommodation.');