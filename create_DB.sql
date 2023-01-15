

CREATE TABLE USER(
ID INT PRIMARY KEY AUTO_INCREMENT,
FirstName VARCHAR(50) NOT NULL,
LastName VARCHAR(50) NOT NULL,
Email VARCHAR(50) UNIQUE NOT NULL ,
PassHash VARCHAR(129) NOT NULL,
LastTimeOnline DATETIME
);

CREATE TABLE Product(
ID INT PRIMARY KEY AUTO_INCREMENT,
NAME VARCHAR(50),
DESCRIPTION VARCHAR(150),
PRICE DECIMAL NOT NULL
);

INSERT INTO Product (NAME, DESCRIPTION, Price) VALUES 
("Oil Filter - Honda Civic", "A high-quality oil filter for use in Honda Civic cars", 12.99),
("Air Filter - Toyota Camry", "A replacement air filter for Toyota Camry cars", 15.99),
("Spark Plugs - Ford Mustang", "A set of new spark plugs for Ford Mustang cars", 24.99),
("Brake Pads - Chevrolet Silverado", "A set of high-performance brake pads for Chevrolet Silverado cars", 45.99),
("Timing Belt - Volkswagen Jetta", "A replacement timing belt for Volkswagen Jetta cars", 32.99),
("Fuel Pump - Nissan Altima", "A new fuel pump for Nissan Altima cars", 68.99),
("Radiator - BMW 3 Series", "A replacement radiator for BMW 3 Series cars", 119.99),
("Water Pump - Jeep Grand Cherokee", "A new water pump for Jeep Grand Cherokee cars", 39.99),
("Alternator - Mercedes-Benz C-Class", "A replacement alternator for Mercedes-Benz C-Class cars", 89.99),
("Battery - Tesla Model S", "A new car battery for Tesla Model S cars", 199.99);

CREATE TABLE ProductOrder(
ID INT PRIMARY KEY AUTO_INCREMENT,
CustomerID INT NOT NULL,
Address VARCHAR(50),
RecieverName VARCHAR(50),
RecieverSurname VARCHAR(50),
RecieverEmail VARCHAR(50),
Price DECIMAL(10,2),
Date DATETIME ,

FOREIGN KEY(CustomerID) REFERENCES USER(ID)
);

SELECT * FROM OrderedProduct;
CREATE TABLE OrderedProduct(
ID INT PRIMARY KEY AUTO_INCREMENT,
ProductID INT NOT NULL,
OrderID INT NOT NULL,

FOREIGN KEY(ProductID) REFERENCES Product(ID),
FOREIGN KEY(OrderID) REFERENCES ProductOrder(ID)
);



USE WEBSHOP;
INSERT INTO ProductOrder(
    CustomerID ,
    Address,
    RecieverName ,
    RecieverSurname,
    RecieverEmail,
    Price,
    Date) 
    VALUES('1', '21312', 'sdada.', 'asdadad','sadasdsa', 23, NOW());
