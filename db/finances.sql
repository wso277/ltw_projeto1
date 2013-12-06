PRAGMA foreign_keys = ON;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Line;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Bill;
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
	CustomerKey		INTEGER PRIMARY KEY AUTOINCREMENT
	CustomerID		INTEGER NOT NULL UNIQUE,
	AccountID	INTEGER NOT NULL,
	CustomerTaxID	INTEGER NOT NULL,
	CompanyName		TEXT NOT NULL,
	BillingAddressID	INTEGER REFERENCES BillingAddress(BillingAddressID) NOT NULL,
	Email			TEXT NOT NULL
);

CREATE TABLE Bill (
	InvoiceID	INTEGER PRIMARY KEY AUTOINCREMENT,
	InvoiceNo 		TEXT UNIQUE NOT NULL,
	InvoiceStatusDate DATE NOT NULL,
	SourceID	TEXT NOT NULL,
	InvoiceDate 		DATETIME NOT NULL,
	SystemEntryDate DATE NOT NULL,
	CustomerID 		INTEGER REFERENCES Customer(CustomerID) NOT NULL,
	TaxPayable 		REAL,
	NetTotal 		REAL,
	GrossTotal 		REAL
);

CREATE TABLE Product (
	ProductCode 			INTEGER PRIMARY KEY AUTOINCREMENT,
	ProductDescription 	TEXT,
	UnitOfMeasure 		TEXT NOT NULL,
	UnitPrice 			REAL NOT NULL
);

CREATE TABLE Line (
	LineID 		INTEGER PRIMARY KEY AUTOINCREMENT,
	InvoiceNo 		REFERENCES Bill(InvoiceNo) NOT NULL,
	LineNumber 	INTEGER NOT NULL,
	ProductCode	INTEGER REFERENCES Product(ProductCode) NOT NULL,
	Quantity 	REAL NOT NULL,
	UnitPrice 	REAL, 
	TaxPointDate DATE NOT NULL,
	TaxType TEXT DEFAULT 'IVA',
	TaxPercentage REAL DEFAULT 23.00,
	CreditAmount REAL
);

INSERT INTO User (UserName, Password, Permission)
	VALUES ('admin', 'obviouspass', 'administrator');