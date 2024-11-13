<?php

namespace Tiime\CrossIndustryInvoiceUniversalBusinessLanguageConversion;

use Tiime\CrossIndustryInvoice\BasicWL\CrossIndustryInvoice as BasicWLCrossIndustryInvoice;
use Tiime\EN16931\Helper\InvoiceTypeCodeUNTDID1001Helper;

class CrossIndustryInvoiceToUniversalBusinessLanguage
{
    public static function convert(BasicWLCrossIndustryInvoice $invoice) //: UniversalBusinessLanguageInterface @todo when one interface
    {
        if (InvoiceTypeCodeUNTDID1001Helper::isInvoice($invoice->getExchangedDocument()->getTypeCode())) {
            return CIIToUBLInvoice::convert($invoice);
        }

        return CIIToUBLCreditNote::convert($invoice);
    }
}