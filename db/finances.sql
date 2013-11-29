PRAGMA foreign_keys = ON;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Line;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Bill;
DROP TABLE IF EXISTS DocumentTotals;
DROP TABLE IF EXISTS Customer; 
DROP TABLE IF EXISTS BillingAddress;

CREATE TABLE User (
	UserID	INTEGER PRIMARY KEY AUTOINCREMENT,
	UserName 	TEXT NOT NULL,
	Password		TEXT NOT NULL,
	Permission	TEXT NOT NULL
);

CREATE TABLE BillingAddress (
	BillingAddressID	INTEGER PRIMARY KEY AUTOINCREMENT,
	AddressDetail	TEXT NOT NULL,
	City				TEXT NOT NULL,
	PostalCode		TEXT NOT NULL,
	Country			TEXT NOT NULL
);

CREATE TABLE Customer (
	CustomerID		INTEGER PRIMARY KEY AUTOINCREMENT,
	AccountID	INTEGER NOT NULL,
	CustomerTaxID	INTEGER NOT NULL,
	CompanyName		TEXT NOT NULL,
	BillingAddressID	INTEGER REFERENCES BillingAddress(BillingAddressID) NOT NULL,
	Email			TEXT NOT NULL
);

CREATE TABLE DocumentTotals (
	DocumentTotalsID	INTEGER PRIMARY KEY AUTOINCREMENT,
	TaxPayable 		REAL,
	NetTotal 		REAL,
	GrossTotal 		REAL
);

CREATE TABLE Bill (
	InvoiceID	INTEGER PRIMARY KEY AUTOINCREMENT,
	InvoiceNo 		TEXT NOT NULL,
	InvoiceStatusDate DATE NOT NULL,
	SourceID	TEXT NOT NULL,
	InvoiceDate 		DATETIME NOT NULL,
	InvoiceType		TEXT NOT NULL,
	SystemEntryDate DATE NOT NULL,
	CustomerID 		INTEGER REFERENCES Customer(CustomerID) NOT NULL,
	DocumentTotalsID	INTEGER REFERENCES DocumentTotals(DocumentTotalsID) NOT NULL
);

CREATE TABLE Product (
	ProductCode 			INTEGER PRIMARY KEY AUTOINCREMENT,
	ProductType TEXT NOT NULL,
	ProductDescription 	TEXT,
	UnitPrice 			REAL NOT NULL
);

CREATE TABLE Line (
	LineID 		INTEGER PRIMARY KEY AUTOINCREMENT,
	InvoiceNo 		REFERENCES Bill(InvoiceNo) NOT NULL,
	LineNumber 	INTEGER NOT NULL,
	ProductCode	INTEGER REFERENCES Product(ProductCode) NOT NULL,
	Quantity 	REAL NOT NULL,
	UnitPrice 	REAL, 
	UnitOfMeasure 		TEXT NOT NULL,
	TaxPointDate DATE NOT NULL,
	CreditAmount REAL
);

INSERT INTO User (UserName, Password, Permission)
	VALUES ('admin', 'obviouspass', 'administrator'),
	       ('noob', '1234', 'reader');
