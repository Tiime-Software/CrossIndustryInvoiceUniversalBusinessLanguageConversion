<?php

declare(strict_types=1);

namespace Tiime\CrossIndustryInvoiceUniversalBusinessLanguageConversion\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tiime\CrossIndustryInvoice\Basic\CrossIndustryInvoice;
use Tiime\CrossIndustryInvoiceUniversalBusinessLanguageConversion\CrossIndustryInvoiceToUniversalBusinessLanguage;
use Tiime\UniversalBusinessLanguage\Ubl21\CreditNote\UniversalBusinessLanguage as UniversalBusinessLanguageCreditNote;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\UniversalBusinessLanguage as UniversalBusinessLanguageInvoice;

class CIIBasicTest extends TestCase
{
    #[TestDox('Create Basic Invoices UBL from CII')]
    #[DataProvider('provideCIIBasicInvoiceXml')]
    public function testCreateUBLInvoiceFromXMLBasic(string $filename): void
    {
        $document = new \DOMDocument();
        $content  = file_get_contents(__DIR__ . '/Fixtures/Basic/' . $filename . '.xml');
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
    public static function provideCIIBasicInvoiceXml(): iterable
    {
        yield '#1' => ['CIIBasicInvoice'];
        yield '#2' => ['CIIBasicInvoice_V7_01'];
        yield '#3' => ['CIIBasicInvoice_V7_02'];
        yield '#4' => ['CIIBasicInvoice_V7_03'];
        yield '#5' => ['CIIBasicInvoice_V7_04'];
        yield '#6' => ['CIIBasicInvoice_V7_05'];
        yield '#7' => ['CIIBasicInvoice_V7_07'];
        yield '#8' => ['CIIBasicInvoice_V7_08'];
        yield '#9' => ['CIIBasicInvoice_V7_09'];
        yield '#10' => ['CIIBasicInvoice_V7_10'];
        yield '#11' => ['CIIBasicInvoice_V7_11'];
    }

    #[TestDox('Create Basic Credit Notes UBL from CII')]
    #[DataProvider('provideBasicCreditNoteXml')]
    public function testCreateUBLCreditNoteFromXMLBasic(string $filename): void
    {
        $document = new \DOMDocument();
        $content  = file_get_contents(__DIR__ . '/Fixtures/Basic/' . $filename . '.xml');
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
    public static function provideBasicCreditNoteXml(): iterable
    {
        yield '#1' => ['CIIBasicInvoice_V7_06'];
    }
}
