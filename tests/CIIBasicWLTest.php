<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoiceUniversalBusinessLanguageConversion\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tiime\CrossIndustryInvoice\BasicWL\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoiceUniversalBusinessLanguageConversion\CrossIndustryInvoiceToUniversalBusinessLanguage;
use Tiime\UniversalBusinessLanguage\Ubl21\CreditNote\UniversalBusinessLanguage as UniversalBusinessLanguageCreditNote;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\UniversalBusinessLanguage as UniversalBusinessLanguageInvoice;

class CIIBasicWLTest extends TestCase
{
    #[TestDox('Create BasicWL Invoices UBL from CII')]
    #[DataProvider('provideCIIBasicWLInvoiceXml')]
    public function testCreateUBLInvoiceFromXMLBasicWL(string $filename): void
    {
        $document = new \DOMDocument();
        $content  = file_get_contents(__DIR__ . '/Fixtures/BasicWL/' . $filename . '.xml');
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
    public static function provideCIIBasicWLInvoiceXml(): iterable
    {
        yield '#1' => ['CIIBasicWLInvoice'];
        yield '#2' => ['CIIBasicWLInvoice_V7_01'];
        yield '#3' => ['CIIBasicWLInvoice_V7_02'];
        yield '#4' => ['CIIBasicWLInvoice_V7_03'];
        yield '#5' => ['CIIBasicWLInvoice_V7_04'];
        yield '#6' => ['CIIBasicWLInvoice_V7_05'];
        yield '#7' => ['CIIBasicWLInvoice_V7_07'];
        yield '#8' => ['CIIBasicWLInvoice_V7_08'];
        yield '#9' => ['CIIBasicWLInvoice_V7_09'];
        yield '#10' => ['CIIBasicWLInvoice_V7_10'];
        yield '#11' => ['CIIBasicWLInvoice_V7_11'];
    }

    #[TestDox('Create BasicWL Credit Notes UBL from CII')]
    #[DataProvider('provideBasicWLCreditNoteXml')]
    public function testCreateUBLCreditNoteFromXMLEN16931(string $filename): void
    {
        $document = new \DOMDocument();
        $content  = file_get_contents(__DIR__ . '/Fixtures/BasicWL/' . $filename . '.xml');
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
    public static function provideBasicWLCreditNoteXml(): iterable
    {
        yield '#7' => ['CIIBasicWLInvoice_V7_06'];
    }
}
