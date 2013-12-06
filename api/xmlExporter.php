<?php
function is_assoc($array) {
	return is_array ( $array ) ? ( bool ) count ( array_filter ( array_keys ( $array ), 'is_string' ) ) : false;
}
class XMLExporter {
	private $writer;
	private function writeHeader() {
		if (! isset ( $this->writer )) {
			$this->writer = new XMLWriter ();
			$this->writer->openMemory ();
		}
		
		$this->writer->startElement ( "AuditFile" );
		$this->writer->writeAttribute ( "xmlns", "urn:OECD:StandardAuditFile-Tax:PT_1.03_01" );
		$this->writer->writeAttribute ( "xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance" );
		$this->writer->writeAttribute ( "xmlns:spi", "http://Company.org/invoice" );
		$this->writer->writeAttribute ( "xmlns:saf", "urn:OECD:StandardAuditFile-Tax:PT_1.03_01" );
		$this->writer->startElement ( "Header" );
		$this->writer->writeElement ( "CompanyID", "My Incredibely Green Company" );
		$this->writer->writeElement ( "TaxRegistrationNumber", "999999999" );
		$this->writer->writeElement ( "TaxAccountingBasis", "F" );
		$this->writer->writeElement ( "CompanyName", "Abstergo SA" );
		$this->writer->startElement ( "CompanyAddress" );
		$this->writer->writeElement ( "AddressDetail", "Rua do Anão Maior, nº1.73" );
		$this->writer->writeElement ( "City", "Curral de Moinas" );
		$this->writer->writeElement ( "PostalCode", "0000-999" );
		$this->writer->writeElement ( "Country", "ES" );
		$this->writer->endElement ();
		$this->writer->writeElement ( "FiscalYear", "2013" );
		$this->writer->writeElement ( "StartDate", "2013-12-24" );
		$this->writer->writeElement ( "EndDate", "2013-12-31" );
		$this->writer->writeElement ( "CurrencyCode", "EUR" );
		$this->writer->writeElement ( "DateCreated", "2013-12-01" );
		$this->writer->writeElement ( "TaxEntity", "Global" );
		$this->writer->writeElement ( "ProductCompanyTaxID", "999999999" );
		$this->writer->writeElement ( "SoftwareCertificateNumber", "0" );
		$this->writer->writeElement ( "ProductID", "Boring/SW" );
		$this->writer->writeElement ( "ProductVersion", "3.75" );
		$this->writer->endElement ();
	}
	public function exportCustomers($customers) {
		$existing_xml = true;
		if (! isset ( $this->writer )) {
			$this->writer = new XMLWriter ();
			$this->writer->openMemory ();
			$this->writeHeader ();
			$this->writer->startElement ( "MasterFiles" );
			$existing_xml = false;
		}
		if (! is_assoc ( $customers )) {
			foreach ( $customers as $cust ) {
				writeCustomer ( $cust );
			}
		} else {
			writeCustomer ( $customers );
		}
		
		if (! $existing_xml) {
			$this->writer->endElement ();
		}
		$closeExport ();
	}
	private function writeCustomer($customer) {
		foreach ( $customer as $key => $value ) {
			$this->writer->startElement ( "Customer" );
			if ($key == "BillingAddress") {
				$this->writer->startElement ( "BillingAddress" );
				foreach ( $value as $addr_key => $addr_val ) {
					$this->writer->writeElement ( $addr_key, $addr_val );
				}
				$this->writer->endElement ();
			} else {
				$this->writer->writeElement ( $key, $value );
			}
		}
		$this->writer->writeElement ( "SelfBillingIndicator", 0 );
		$this->writer->endElement ();
	}
	public function exportProducts($products) {
		$existing_xml = true;
		if (! isset ( $this->writer )) {
			$this->writer = new XMLWriter ();
			$this->writer->openMemory ();
			$this->writer->setIndent ( true );
			$this->writeHeader ();
			$this->writer->startElement ( "MasterFiles" );
			$existing_xml = false;
		}
		
		if (! is_assoc ( $products )) {
			foreach ( $products as $prod ) {
				writeProduct ( $prod );
			}
		} else {
			writeProduct ( $products );
		}
		if (! $existing_xml) {
			$this->writer->endElement ();
		}
		$closeExport ();
	}
	private function writeProduct($product) {
		$this->writer->startElement ( "Product" );
		foreach ( $product as $key => $value ) {
			$this->writer->writeElement ( "ProductType", "P" );
			$this->writer->writeElement ( "ProductCode", $product ['ProductCode'] );
			$this->writer->writeElement ( "ProductDescription", $product ['ProductDescription'] );
			$this->writer->writeElement ( "ProductNumberCode", $product ['ProductCode'] );
		}
		$this->writer->endElement ();
	}
	public function exportInvoices($invoices) {
		$this->writer = new XMLWriter ();
		$this->writer->openMemory ();
		$this->writer->setIndent ( true );
		$this->writeHeader ();
		$this->writer->startElement ( "MasterFiles" );
		if (! is_assoc ( $invoices )) {
			foreach ( $invoices as $invoice ) {
				$this->writeCustomer ( $invoice ['Customer'] );
				foreach ( $invoice ['Line'] as $line ) {
					$this->writeProduct ( $line ['Product'] );
				}
			}
		} else {
			$this->writeCustomer ( $invoices ['Customer'] );
			foreach ( $invoices ['Line'] as $line ) {
				$this->writeProduct ( $line ['Product'] );
			}
		}
		
		$this->writer->startElement ( "TaxTable" );
		$this->writer->startElement ( "TaxTableEntry" );
		$this->writer->writeElement ( "TaxType", "IVA" );
		$this->writer->writeElement ( "TaxCountryRegion", "PT" );
		$this->writer->writeElement ( "TaxCode", "NOR" );
		$this->writer->writeElement ( "Description", "Taxa Normal (23%)" );
		$this->writer->writeElement ( "TaxPercentage", "23.00" );
		$this->writer->endElement ();
		$this->writer->endElement ();
		
		$this->writer->endElement (); // MasterFiles
		
		$this->writer->startElement ( "SourceDocuments" );
		$this->writer->startElement ( "SalesInvoices" );
		$this->writer->writeElement ( "NumberOfEntries", sizeof ( $invoices ) );
		$total_credit = 0.0;
		if (! is_assoc ( $invoices )) {
			foreach ( $invoices as $invoice ) {
				$total_credit += $invoice ['DocumentTotals'] ['GrossTotal'];
			}
		} else {
			$total_credit += $invoices ['DocumentTotals'] ['GrossTotal'];
		}
		$this->writer->writeElement ( "TotalDebit", "0.00" );
		$this->writer->writeElement ( "TotalCredit", $total_credit );
		if (! is_assoc ( $invoices )) {
			foreach ( $invoices as $invoice ) {
				writeInvoice ( $invoice );
			}
		} else {
			$this->writeInvoice ( $invoices );
		}
		$this->writer->endElement ();
		$this->writer->endElement ();
		
		$this->closeExport ();
	}
	private function writeInvoice($invoice) {
		$this->writer->startElement ( "Invoice" );
		$this->writer->startElement ( "DocumentStatus" );
		$this->writer->writeElement ( "InvoiceStatus", "N" );
		$this->writer->writeElement ( "InvoiceStatusDate", $invoice ['InvoiceStatusDate'] );
		$this->writer->writeElement ( "SourceID", $invoice ['SourceID'] );
		$this->writer->writeElement ( "SourceBilling", "P" );
		$this->writer->endElement ();
		$this->writer->writeElement ( "Hash", "0" );
		$this->writer->writeElement ( "InvoiceDate", $invoice ['InvoiceDate'] );
		$this->writer->writeElement ( "InvoiceType", "FT" );
		$this->writer->startElement ( "SpecialRegimes" );
		$this->writer->writeElement ( "SelfBillingIndicator", "0" );
		$this->writer->writeElement ( "CashVATSchemeIndicator", "0" );
		$this->writer->writeElement ( "ThirdPartiesBillingIndicator", "0" );
		$this->writer->endElement ();
		$this->writer->writeElement ( "SourceID", $invoice ['SourceID'] );
		$this->writer->writeElement ( "SystemEntryDate", $invoice ['SystemEntryDate'] );
		$this->writer->writeElement ( "CustomerID", $invoice ['CustomerID'] );
		
		foreach ( $invoice ['Line'] as $line ) {
			$this->writer->startElement ( "Line" );
			$this->writer->writeElement ( "LineNumber", $line ['LineNumber'] );
			$this->writer->writeElement ( "ProductCode", $line ['ProductCode'] );
			$this->writer->writeElement ( "ProductDescription", $line ['Product'] ['ProductDescription'] );
			$this->writer->writeElement ( "Quantity", $line ['Quantity'] );
			$this->writer->writeElement ( "UnitOfMeasure", $line ['Product'] ['UnitOfMeasure'] );
			$this->writer->writeElement ( "UnitPrice", $line ['UnitPrice'] );
			$this->writer->writeElement ( "TaxPointDate", $line ['TaxPointDate'] );
			$this->writer->writeElement ( "Description", $line ['Product'] ['ProductDescription'] );
			$this->writer->writeElement ( "CreditAmount", $line ['CreditAmount'] );
			$this->writer->startElement ( "Tax" );
			$this->writer->writeElement ( "TaxType", $line ['TaxType'] );
			$this->writer->writeElement ( "TaxCountryRegion", "PT" );
			$this->writer->writeElement ( "TaxCode", "NOR" );
			$this->writer->writeElement ( "TaxPercentage", "TaxPercentage" );
			$this->writer->endElement ();
			$this->writer->writeElement ( "SettlementAmount", "0" );
			$this->writer->endElement ();
		}
		
		$this->writer->endElement ();
	}
	public function closeExport() {
		if (isset ( $this->writer )) {
			$this->writer->endElement ();
			echo $this->writer->outputMemory ();
			unset ( $this->writer );
		}
	}
}

$invoice = json_decode ( '{"InvoiceNo":1,"SystemEntryDate":"2013-06-06T23:23:23.20","SourceID":"ldkdk","InvoiceStatusDate":"2012-10-15","InvoiceDate":"2012-11-10","CustomerID":1,"Customer":{"CustomerID":1,"AccountID":8888,"CustomerTaxID":2424,"CompanyName":"Darpa","Email":"dart.for@the.win","BillingAddress":{"AddressDetail":"Awesomeness street","City":"Matrix","PostalCode":"2223-544","Country":"GB"}},"DocumentTotals":{"TaxPayable":5.32,"NetTotal":3.21,"GrossTotal":4.21},"Line":[{"LineNumber":1,"TaxPointDate":"2013-06-06","TaxType":"IVA","ProductCode":1,"Product":{"ProductCode":"1","ProductDescription":"produto generico","UnitOfMeasure":"km^3","UnitPrice":"75.0"},"Quantity":2,"UnitPrice":10,"CreditAmount":20,"Tax":{"TaxType":"IVA","TaxPercentage":23.00}}]}', true );
$exporter = new XMLExporter ();
$exporter->exportInvoices ( $invoice );
?>

