<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoiceUniversalBusinessLanguageConversion\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tiime\CrossIndustryInvoice\EN16931\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoiceUniversalBusinessLanguageConversion\CrossIndustryInvoiceToUniversalBusinessLanguage;
use Tiime\UniversalBusinessLanguage\Ubl21\CreditNote\UniversalBusinessLanguage as UniversalBusinessLanguageCreditNote;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\UniversalBusinessLanguage as UniversalBusinessLanguageInvoice;

class CIIEN16931Test extends TestCase
{
    #[TestDox('Create EN16931 Invoices UBL from CII')]
    #[DataProvider('provideCIIEN16931InvoiceXml')]
    public function testCreateUBLInvoiceFromXMLEN16931(string $filename): void
    {
        $document = new \DOMDocument();
        $content  = file_get_contents(__DIR__ . '/Fixtures/EN16931/' . $filename . '.xml');
        $this->assertIsString($content);

        $document->loadXML($content);

        $invoice = CrossIndustryInvoice::fromXML($document);
        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $ubl = CrossIndustryInvoiceToUniversalBusinessLanguage::convert($invoice);

        $this->assertInstanceOf(UniversalBusinessLanguageInvoice::class, $ubl);
    }

    /**
     * @return iterable<array<int, string>>
     */
    public static function provideCIIEN16931InvoiceXml(): iterable
    {
        yield '#1' => ['CIIEN16931Invoice'];
        yield '#2' => ['CIIEN16931Invoice_V7_01'];
        yield '#3' => ['CIIEN16931Invoice_V7_02'];
        yield '#4' => ['CIIEN16931Invoice_V7_03'];
        yield '#5' => ['CIIEN16931Invoice_V7_04'];
        yield '#6' => ['CIIEN16931Invoice_V7_05'];
        yield '#7' => ['CIIEN16931Invoice_V7_07'];
        yield '#8' => ['CIIEN16931Invoice_V7_08'];
        yield '#9' => ['CIIEN16931Invoice_V7_09'];
        yield '#10' => ['CIIEN16931Invoice_V7_10'];
        yield '#11' => ['CIIEN16931Invoice_V7_11'];
    }

    #[TestDox('Create EN16931 Credit Notes UBL from CII')]
    #[DataProvider('provideEN16931CreditNoteXml')]
    public function testCreateUBLCreditNoteFromXMLEN16931(string $filename): void
    {
        $document = new \DOMDocument();
        $content  = file_get_contents(__DIR__ . '/Fixtures/EN16931/' . $filename . '.xml');
        $this->assertIsString($content);

        $document->loadXML($content);

        $invoice = CrossIndustryInvoice::fromXML($document);
        $this->assertInstanceOf(CrossIndustryInvoice::class, $invoice);

        $ubl = CrossIndustryInvoiceToUniversalBusinessLanguage::convert($invoice);

        $this->assertInstanceOf(UniversalBusinessLanguageCreditNote::class, $ubl);
    }

    /**
     * @return iterable<array<int, string>>
     */
    public static function provideEN16931CreditNoteXml(): iterable
    {
        yield '#1' => ['CIIEN16931Invoice_V7_06'];
    }
}
