
DROP TABLE Prescriptions;
DROP TABLE Doctors;
DROP TABLE Medication_Relation;
DROP TABLE Medications;
DROP TABLE Employees;
DROP TABLE Medication_Type;
DROP TABLE Insurance_Relation;
DROP TABLE Insurance;
DROP TABLE Customers;
DROP TABLE Login;

CREATE TABLE Customers (
custId INT (10) NOT NULL AUTO_INCREMENT,
firstName VARCHAR (255) NOT NULL,
lastName VARCHAR (255) NOT NULL,
phone VARCHAR (10) NOT NULL,
email VARCHAR (255) NOT NULL,
address VARCHAR (255) NOT NULL,
city VARCHAR (255) NOT NULL,
state VARCHAR (255) NOT NULL,
zipCode INT (5),
Primary Key (custID)
);

CREATE TABLE Doctors (
doctId INT (10) NOT NULL AUTO_INCREMENT,
firstName VARCHAR (255) NOT NULL,
lastName VARCHAR (255) NOT NULL,
licenseNo VARCHAR (255) NOT NUll,
clinic VARCHAR (255) NOT NULL,
Primary Key (doctID)
);

CREATE TABLE Employees (
empId INT (10) NOT NULL AUTO_INCREMENT,
firstName VARCHAR (255) NOT NULL,
lastName VARCHAR (255) NOT NULL,
phone INT (10) NOT NULL,
email VARCHAR (255) NOT NULL,
address VARCHAR (255) NOT NULL,
city VARCHAR (255) NOT NULL,
state VARCHAR (255) NOT NULL,
zipCode INT (5) NOT NULL,
Primary Key (empId)
);

CREATE TABLE Medication_Type (
medTypeId INT (10) NOT NULL AUTO_INCREMENT,
typeName VARCHAR (255) NOT NULL,
Primary Key (medTypeId)
);

CREATE TABLE Medications (
medId INT (10) Not NULL AUTO_INCREMENT,
name VARCHAR (255) NOT NULL,
supplyQuantity INT (10) Not NULL,
Primary Key (medId)
);

CREATE TABLE Prescriptions (
prescripId INT (10) NOT NULL AUTO_INCREMENT,
doctId INT (10) NOT NULL,
custId INT (10) NOT NULL,
empId INT (10),
medId INT (10) NOT NULL,
refills INT (10) NOT NULL,
pillCount INT (10) NOT NULL,
instructions VARCHAR (255) NOT NULL,
Primary Key (prescripId),
Foreign Key (custId) REFERENCES Customers(custId),
Foreign Key (doctId) REFERENCES Doctors(doctId),
Foreign Key (empId) REFERENCES Employees(empId),
Foreign Key (medId) REFERENCES Medications(medId)
);


CREATE TABLE Insurance (
insId INT (10) NOT NULL AUTO_INCREMENT,
name VARCHAR (255) NOT NULL,
phone INT (10) NOT NULL,
address VARCHAR (255) NOT NULL,
city VARCHAR (255) NOT NULL,
state VARCHAR (255) NOT NULL,
zipCode INT (5) NOT NULL,
Primary Key (insId)
);

CREATE TABLE Medication_Relation (
medId INT (10) NOT NULL,
medTypeId INT (10) NOT NULL,
Foreign Key (medId) REFERENCES Medications(medId),
Foreign Key (medTypeId) REFERENCES Medication_Type(medTypeId)
);

CREATE TABLE Insurance_Relation (
insId INT (10) NOT NULL,
custId INT (10) NOT NULL,
Foreign Key (insId) REFERENCES Insurance(insId),
Foreign Key (custId) REFERENCES Customers(custId)
);

CREATE TABLE Login (
id INT (10) NOT NULL AUTO_INCREMENT,
username VARCHAR(32) NOT NULL,
password VARCHAR(255) NOT NULL,
job TINYINT(1) NOT NULL,
personId INT (10) NOT NULL,
Primary Key (id)
);

insert into Customers Values(null,'Richard','Sherman',7015578952,'rsherman@gmail.com','69420 12th st N','Fargo','ND', 58102);
insert into Customers Values(null,'Aditya','Bhasin',7015557452,'abhasin@gmail.com','123 7th st N','Fargo','ND', 58102);
insert into Customers Values(null,'Billy','Joel',7012348594,'bjoel@gmail.com','324 3rd st S','Jamestown','ND', 58401);
insert into Customers Values(null,'Greg','Oden',7013489234,'goden@gmail.com','5345 5th st E','Trenton','ND', 58853);
insert into Customers Values(null,'Marilyn','Manson',7012389823,'mmanson@gmail.com','PO BOX 532','Dickinson','ND', 58601);


insert into Doctors Values(null,'Buster','Schrader',123459876,'Tyrones Ghetto Clinic');
insert into Doctors Values(null,'Ben','Hapip',123456987,'Weeny Hut Clinic');
insert into Doctors Values(null,'Jordan','Falcon',123456789,'TISA');

insert into Employees Values(null,'Otto', 'Borchert',1447899696,'oborchert@rmail.com','577 81st st n.','Fargo','ND',58102);
insert into Employees Values(null,'Ronnie', 'Hillman',2036904200,'rhman@zmail.com','6923 N. Broadway','Fargo','ND',58102);
insert into Employees Values(null,'Derek', 'Carr',1547894563,'dcarr@rmail.com','57 N. broadway.','Fargo','ND',58102);
insert into Employees Values(null,'Joey', 'Bosa',1947635987,'jbosa@pmail.com','1234 Krishna Ln.','Fargo','ND',58105);


INSERT INTO Login VALUES (NULL, 'admin', '$2y$10$PlzaQHry32a6O4yol5NVY.Ik8RrUlzbiNEzutSR4zNUmYuWPD/T32', 2, -1);
INSERT INTO Login VALUES (NULL, 'bschrade', '$2y$10$PlzaQHry32a6O4yol5NVY.Ik8RrUlzbiNEzutSR4zNUmYuWPD/T32', 1, 1);
INSERT INTO Login VALUES (NULL, 'rhillman', '$2y$10$PlzaQHry32a6O4yol5NVY.Ik8RrUlzbiNEzutSR4zNUmYuWPD/T32', 0, 2);
INSERT INTO Login VALUES (NULL, 'jfalcon', '$2y$10$PlzaQHry32a6O4yol5NVY.Ik8RrUlzbiNEzutSR4zNUmYuWPD/T32', 1, 3);
INSERT INTO Login VALUES (NULL, 'bhapip', '$2y$10$PlzaQHry32a6O4yol5NVY.Ik8RrUlzbiNEzutSR4zNUmYuWPD/T32', 1, 2);
INSERT INTO Login VALUES (NULL, 'oborcher', '$2y$10$PlzaQHry32a6O4yol5NVY.Ik8RrUlzbiNEzutSR4zNUmYuWPD/T32',0,1);

insert into Medication_Type Values(1,'Antihypertensive');
insert into Medication_Type Values(2,'Antihistamine');
insert into Medication_Type Values(3,'Human Growth Hormone');
insert into Medication_Type Values(null,'Antacid');
insert into Medication_Type Values(null,'Laxative');
insert into Medication_Type Values(6,'Vaccine');
insert into Medication_Type Values(null,'Psychedelic');
insert into Medication_Type Values(null,'Opioid');
insert into Medication_Type Values(null,'Pain Reliever');
insert into Medication_Type Values(null,'Anti-Depressant');

insert into Medications Values(null,'Viagra',50);
insert into Medications Values(null,'Cialis',20);
insert into Medications Values(null,'Tums',120);
insert into Medications Values(null,'Tylenol',45);
insert into Medications Values(null,'Mucinex',50);
insert into Medications Values(null,'Vicodin',10);
insert into Medications Values(null,'Pseudoephedrine',70);
insert into Medications Values(null,'Prilosec',80);
insert into Medications Values(null,'Dulcolax',100);
insert into Medications Values(null,'Abilify', 200);


insert into Medication_Relation Values(1,3);
insert into Medication_Relation Values(2,3);
insert into Medication_Relation Values(4,9);
insert into Medication_Relation Values(4,1);
insert into Medication_Relation Values(5,2);
insert into Medication_Relation Values(6,9);
insert into Medication_Relation Values(3,7);
insert into Medication_Relation Values(7,2);
insert into Medication_Relation Values(8,4);
insert into Medication_Relation Values(9,5);
insert into Medication_Relation Values(10,10);


select * from Medication_Relation,Medications,Medication_Type where Medication_Relation.medId = Medications.medId and Medication_Relation.medTypeId = Medication_Type.medTypeId ;

select typeName from Medication_Relation,Medications,Medication_Type where Medication_Relation.medId = Medications.medId and Medication_Relation.medTypeId = Medication_Type.medTypeId ;

insert into Prescriptions Values(null, 2, 1, 2, 1, 3, 20, 'Take after meal');
insert into Prescriptions Values(null, 1, 1, null, 1, 2, 25, 'Take one before bed');

insert into Insurance Values(null, 'State Farm', '14th St W', 'Fargo', 'ND', 58102, 7017538475);
insert into Insurance Values(null, 'Blue Cross', '23rd St E', 'Fargo', 'ND', 58102, 7015436667);

insert into Insurance_Relation Values(1,1);
insert into Insurance_Relation Values(2,1);
insert into Insurance_Relation Values(1,2);
