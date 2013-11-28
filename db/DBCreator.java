import java.sql.*;
import java.util.Random;

public class DBCreator {

	public static void main(String args[]) {
		Random r = new Random(System.currentTimeMillis());
		Connection c = null;
		Statement stmt = null;
		int max = 20;
		int max_bills = 50;

		try {
			Class.forName("org.sqlite.JDBC");
			c = DriverManager.getConnection("jdbc:sqlite:finances.db");
		} catch (Exception e) {
			System.err.println(e.getClass().getName() + ": " + e.getMessage());
			System.exit(0);
		}
		System.out.println("Opened database successfully");

		try {
			stmt = c.createStatement();
		} catch (SQLException e) {
			System.err.println("Error creating statement!");
			e.printStackTrace();
		}

		String init_db = "PRAGMA foreign_keys = ON;";

		try {
			stmt.executeUpdate(init_db);
		} catch (SQLException e1) {
			e1.printStackTrace();
		}

		String drop_tables = 
						"DROP TABLE IF EXISTS User; " +
						"DROP TABLE IF EXISTS TaxPerBillLine; " +
						"DROP TABLE IF EXISTS Tax; " +
						"DROP TABLE IF EXISTS Line; " + 
						"DROP TABLE IF EXISTS Product; " + 
						"DROP TABLE IF EXISTS Bill; " +
						"DROP TABLE IF EXISTS DocumentTotals; " + 
						"DROP TABLE IF EXISTS Customer; " + 
						"DROP TABLE IF EXISTS BillingAddress; ";
		try {
			stmt.executeUpdate(drop_tables);
		} catch (SQLException e) {
			e.printStackTrace();
		}

		String user = "CREATE TABLE User ("
				+ "UserID	INTEGER PRIMARY KEY AUTOINCREMENT,"
				+ "UserName 	TEXT NOT NULL,"
				+ "Password		TEXT NOT NULL,"
				+ "Permission	TEXT NOT NULL"
				+ ");";
		try {
			stmt.executeUpdate(user);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		String address = "CREATE TABLE BillingAddress ("
				+ "BillingAddressID	INTEGER PRIMARY KEY AUTOINCREMENT,"
				+ "AddressDetail	TEXT NOT NULL,"
				+ "City				TEXT NOT NULL,"
				+ "PostalCode		TEXT NOT NULL,"
				+ "Country			TEXT NOT NULL"
				+ ");";
		try {
			stmt.executeUpdate(address);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		String customer = "CREATE TABLE Customer ("
				+ "CustomerID		INTEGER PRIMARY KEY AUTOINCREMENT,"
				+ "CustomerTaxID	INTEGER NOT NULL,"
				+ "CompanyName		TEXT NOT NULL,"
				+ "BillingAddressID	INTEGER REFERENCES BillingAddress(BillingAddressID) NOT NULL,"
				+ "Email			TEXT NOT NULL"
				+ ");";
		try {
			stmt.executeUpdate(customer);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		String doc_totals = "CREATE TABLE DocumentTotals ("
				+ "DocumentTotalsID	INTEGER PRIMARY KEY AUTOINCREMENT,"
				+ "TaxPayable 		REAL,"
				+ "NetTotal 		REAL,"
				+ "GrossTotal 		REAL"
				+ ")";
		try {
			stmt.executeUpdate(doc_totals);
		} catch (SQLException e) {
			e.printStackTrace();
		}

		String bill = "CREATE TABLE Bill ("
				+ "InvoiceNo 		INTEGER PRIMARY KEY AUTOINCREMENT,"
				+ "InvoiceDate 		DATETIME NOT NULL,"
				+ "CustomerID 		INTEGER REFERENCES Customer(CustomerID) NOT NULL,"
				+ "DocumentTotalsID	INTEGER REFERENCES DocumentTotals(DocumentTotalsID) NOT NULL"
				+ ");";
		try {
			stmt.executeUpdate(bill);
		} catch (SQLException e) {
			e.printStackTrace();
		}

		String product = "CREATE TABLE Product ("
				+ "ProductCode 			INTEGER PRIMARY KEY AUTOINCREMENT,"
				+ "ProductDescription 	TEXT,"
				+ "UnitPrice 			REAL NOT NULL," 
				+ "UnitOfMeasure 		TEXT NOT NULL"
				+ ");";
		try {
			stmt.executeUpdate(product);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		

		String tax = "CREATE TABLE Tax (" 
				+ "TaxID 			INTEGER PRIMARY KEY,"
				+ "TaxType 			TEXT NOT NULL," 
				+ "TaxPercentage 	REAL NOT NULL"
				+ ");";
		
		try {
			stmt.executeUpdate(tax);
		} catch (SQLException e) {
			e.printStackTrace();
		}

		String bill_line = "CREATE TABLE Line ("
				+ "LineID 		INTEGER PRIMARY KEY AUTOINCREMENT,"
				+ "InvoiceNo 		REFERENCES Bill(InvoiceNo) NOT NULL,"
				+ "LineNumber 	INTEGER NOT NULL,"
				+ "ProductCode	INTEGER REFERENCES Product(ProductCode) NOT NULL,"
				+ "Quantity 	REAL NOT NULL," 
				+ "UnitPrice 	REAL," 
				+ "CreditAmount REAL" 
				+ ");";
		try {
			stmt.executeUpdate(bill_line);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		String tax_billLine = "CREATE TABLE TaxPerBillLine (" 
				+ "TaxPerBillLineID 	INTEGER PRIMARY KEY AUTOINCREMENT,"
				+ "LineID			 	INTEGER REFERENCES Line(LineID) NOT NULL,"
				+ "TaxID 				INTEGER REFERENCES Tax(TaxID) NOT NULL"
				+ ");";
		try {
			stmt.executeUpdate(tax_billLine);
		} catch (SQLException e) {
			e.printStackTrace();
		}

		String administrator = "INSERT INTO User (UserID, UserName, Password, Permission) VALUES (" 
					+ 1 + ", " + "'administrator1'" + ", " + "'administrator1Password'" + ", " + "'administrator'" + ");";
			
		String editor = "INSERT INTO User (UserID, UserName, Password, Permission) VALUES (" 
					+ 2 + ", " + "'editor1'" + ", " + "'editor1Password'" + ", " + "'editor'" + ");";
					
		String reader = "INSERT INTO User (UserID, UserName, Password, Permission) VALUES (" 
					+ 3 + ", " + "'reader1'" + ", " + "'reader1Password'" + ", " + "'reader'" + ");";
									
		try {
			stmt.executeUpdate(administrator);
			stmt.executeUpdate(editor);
			stmt.executeUpdate(reader);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		String prod_desc[] = {"'atum, compre o que e nosso'", "'iogurte de pinacolada fabricado no Hawai'", 
				"'flores em segunda mao'", "'livro tecnico coiso'", "'Carapauzinho, com espinha deste tamanho'", "'Leite ressequido'", "'Super Computador 2015'"};
		double prod_unitprice[] = { 23.3, 75, 555.33, 1005.75, 326.45};
		String prod_unmeasure[] = {"'micrometros'", "'Kilos'", "'Jaquinzinhos'", "'Umhs'"};
		
		for (int i = 1; i <= max; i++) {
			int desc =  Math.abs(r.nextInt() % prod_desc.length);
			int unitprice =  Math.abs(r.nextInt() % prod_unitprice.length);
			int unmeasure =  Math.abs(r.nextInt() % prod_unmeasure.length);
			
			String prod = "INSERT INTO Product (ProductDescription, UnitPrice, UnitOfMeasure) VALUES (" 
					+ prod_desc[desc] + ", "
					+ prod_unitprice[unitprice] + ", " + prod_unmeasure[unmeasure] + ");";
			
			try {
				stmt.executeUpdate(prod);
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		String bill_detail[] = {"'Rua da Pena'", "'n 23 Tapada'", "'Avenida Sempre-Aberta'", "'Avenida Aberta-as-vezes'", "'Rua do Ze Grande'"};
		String bill_city[] = {"'Regua'", "'Vila Nova da Bonita'", "'Souto Maior'", "'Desgosto City'"};
		String bill_postcod[] = {"'1234-568'", "'9999-123'", "'2225-566'"};
		String bill_country[] = {"'Pais dos maiores'", "'United States of Tugas'", "'Aquele ali do lado'"};
		
		for (int i = 1; i <= max; i++) {
			int detail =  Math.abs(r.nextInt() % bill_detail.length);
			int city =  Math.abs(r.nextInt() % bill_city.length);
			int postcode =  Math.abs(r.nextInt() % bill_postcod.length);
			int country =  Math.abs(r.nextInt() % bill_country.length);
			
			String bill_loc = "INSERT INTO BillingAddress (AddressDetail, City, PostalCode, Country) VALUES (" 
					+ bill_detail[detail] + ", " + bill_city[city] + ", "
					+ bill_postcod[postcode] + ", " + bill_country[country] + ");";
			
			try {
				stmt.executeUpdate(bill_loc);
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		String cust_taxid[] = {"'35646'", "'31254'", "'687645'", "'98783231'"};
		String comp_name[] = {"'Caves de absinto'", "'modalfa'", "'itCrowd'", "'Pandaria'"};
		String email[] = {"'kjndf@gmail.com'", "'putin@russia.rsrs'", "'sqlforthe@win'"};
		
		for (int i = 1; i <= max; i++) {
			int tax_id =  Math.abs(r.nextInt() % cust_taxid.length);
			int name =  Math.abs(r.nextInt() % comp_name.length);
			int addr =  Math.abs(r.nextInt() % max) + 1;
			int mail =  Math.abs(r.nextInt() % email.length);
			
			String cust = "INSERT INTO Customer (CustomerTaxID, CompanyName, BillingAddressID, Email) VALUES (" 
					+ cust_taxid[tax_id] + ", " + comp_name[name] + ", "
					+ addr + ", " + email[mail] + ");";
			
			try {
				stmt.executeUpdate(cust);
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		for (int i = 1; i <= max; i++) {
			int tax_pay =  Math.abs(r.nextInt() % 1000 / 10);
			int nettot =  Math.abs(r.nextInt() % 1000 / 10);
			int grosstot =  Math.abs(r.nextInt() % 1000 / 10);
			
			String doctot = "INSERT INTO DocumentTotals (TaxPayable, NetTotal, GrossTotal) VALUES (" 
					+ tax_pay + ", " + nettot + ", " + grosstot + ");";
			
			try {
				stmt.executeUpdate(doctot);
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		String date[] = {"'2013-01-23'", "'1970-12-24'", "'1993-08-27'", "'1993-08-09'", "'1993-04-02'", "'2001-05-31'", "'2003-02-15'"};
		for (int i = 1; i <= max_bills; i++) {
			int date_i =  Math.abs(r.nextInt() % date.length);
			int custm_id =  Math.abs(r.nextInt() % max) + 1;
			int doctotal =  Math.abs(r.nextInt() % max) + 1;
			
			String bill_elem = "INSERT INTO Bill (InvoiceDate, CustomerID, DocumentTotalsID) VALUES (" 
					+ date[date_i] + ", " + custm_id + ", " + doctotal + ");";
			
			try {
				stmt.executeUpdate(bill_elem);
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		String taxtype[] = {"'Fundo Monetario para a Corrupcao'", "'Imposto pelo St. Antonio'", "'Imposto sobre o Alcool'"};
		double taxperc[] = { 132.35, 211.32, 321.12};
		for (int i = 1; i <= max; i++) {
			int type =  Math.abs(r.nextInt() % taxperc.length);
			int perc =  Math.abs(r.nextInt() % taxtype.length);
			
			String taxc = "INSERT INTO Tax (TaxType, TaxPercentage) VALUES (" 
					+ taxtype[type] + ", " + taxperc[perc] + ");";
			
			try {
				stmt.executeUpdate(taxc);
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		for (int i = 1; i <= 100; i++) {
			int billid =  Math.abs(r.nextInt() % (max_bills - 1)) + 2;
			int linenr =  Math.abs(r.nextInt() % 100);
			int prod =  Math.abs(r.nextInt() % max) + 1;
			int quant =  Math.abs(r.nextInt() % taxperc.length);
			int unprice =  Math.abs(r.nextInt() % prod_unitprice.length);
			int credam =  Math.abs(r.nextInt() % taxperc.length);
			
			
			String line = "INSERT INTO Line (InvoiceNo, LineNumber,ProductCode, Quantity, UnitPrice, CreditAmount) VALUES (" 
					+ billid + ", " + linenr + ", " + prod + ", "+ quant + ", " + unprice + ", " + credam + ");";
			
			try {
				stmt.executeUpdate(line);
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}

			for (int i = 1; i <= 50; i++) {
			int billid =  1;
			int linenr =  Math.abs(r.nextInt() % 100);
			int prod =  Math.abs(r.nextInt() % max) + 1;
			int quant =  Math.abs(r.nextInt() % taxperc.length);
			int unprice =  Math.abs(r.nextInt() % prod_unitprice.length);
			int credam =  Math.abs(r.nextInt() % taxperc.length);
			
			
			String line = "INSERT INTO Line (InvoiceNo, LineNumber,ProductCode, Quantity, UnitPrice, CreditAmount) VALUES (" 
					+ billid + ", " + linenr + ", " + prod + ", "+ quant + ", " + unprice + ", " + credam + ");";
			
			try {
				stmt.executeUpdate(line);
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		for (int i = 1; i <= 150; i++) {
			int taxid =  Math.abs(r.nextInt() % max) + 1;
			
			
			String taxline = "INSERT INTO TaxPerBillLine (LineID, TaxID) VALUES (" 
					+ i + ", " + taxid + ");";
			
			try {
				stmt.executeUpdate(taxline);
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
		
		try {
			stmt.close();
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		try {
			c.close();
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
		System.out.println("Finished writing data");
	}

}
