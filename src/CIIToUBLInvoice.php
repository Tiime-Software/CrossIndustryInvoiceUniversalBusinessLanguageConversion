<?php

namespace Tiime\CrossIndustryInvoiceUniversalBusinessLanguageConversion;

use Tiime\CrossIndustryInvoice\Basic\CrossIndustryInvoice as BasicCrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\BasicWL\CrossIndustryInvoice as BasicWLCrossIndustryInvoice;
use Tiime\CrossIndustryInvoice\DataType\AdditionalReferencedDocumentAdditionalSupportingDocument;
use Tiime\CrossIndustryInvoice\DataType\ApplicableProductCharacteristic;
use Tiime\CrossIndustryInvoice\DataType\Basic\IncludedSupplyChainTradeLineItem as BasicIncludedSupplyChainTradeLineItem;
use Tiime\CrossIndustryInvoice\DataType\Basic\LineSpecifiedTradeAllowance as BasicLineSpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\HeaderApplicableTradeTax;
use Tiime\CrossIndustryInvoice\DataType\BasicWL\SpecifiedTradeSettlementPaymentMeans;
use Tiime\CrossIndustryInvoice\DataType\DesignatedProductClassification;
use Tiime\CrossIndustryInvoice\DataType\DocumentIncludedNote;
use Tiime\CrossIndustryInvoice\DataType\EN16931\IncludedSupplyChainTradeLineItem as EN16931IncludedSupplyChainTradeLineItem;
use Tiime\CrossIndustryInvoice\DataType\EN16931\LineSpecifiedTradeAllowance as EN16931LineSpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\InvoiceReferencedDocument;
use Tiime\CrossIndustryInvoice\DataType\SellerGlobalIdentifier;
use Tiime\CrossIndustryInvoice\DataType\SellerTaxRepresentativeTradeParty;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeAllowance;
use Tiime\CrossIndustryInvoice\DataType\SpecifiedTradeCharge;
use Tiime\CrossIndustryInvoice\DataType\TaxTotalAmount;
use Tiime\CrossIndustryInvoice\EN16931\CrossIndustryInvoice as EN16931CrossIndustryInvoice;
use Tiime\EN16931\Converter\TimeReferencingCodeUNTDID2005ToTimeReferencingCodeUNTDID2475;
use Tiime\EN16931\DataType\Identifier\BuyerIdentifier;
use Tiime\EN16931\DataType\Identifier\LocationIdentifier;
use Tiime\EN16931\DataType\Identifier\ObjectIdentifier;
use Tiime\EN16931\DataType\Identifier\PayeeIdentifier;
use Tiime\EN16931\DataType\Identifier\SellerIdentifier;
use Tiime\CrossIndustryInvoice\DataType\EN16931\SpecifiedTradeSettlementPaymentMeans as EN16931SpecifiedTradeSettlementPaymentMeans;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\AccountingCustomerParty;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\AccountingSupplierParty;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\AdditionalDocumentReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\AdditionalItemProperty;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\AddressLine;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\Allowance;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\Attachment;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\BillingReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\BuyerParty;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\BuyerPartyIdentification;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\BuyerPartyLegalEntity;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\BuyerPartyTaxScheme;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\BuyersItemIdentification;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\CardAccount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\Charge;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\ClassifiedTaxCategory;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\CommodityClassification;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\Contact;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\ContractDocumentReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\Country;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\Delivery;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\DeliveryAddress;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\DeliveryLocation;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\DeliveryParty;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\DeliveryPartyName;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\DespatchDocumentReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\DocumentReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\ExternalReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\FinancialInstitutionBranch;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\InvoiceDocumentReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\InvoiceLine;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\InvoiceLineAllowance;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\InvoiceLineCharge;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\InvoiceLineInvoicePeriod;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\InvoicePeriod;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\Item;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\LegalMonetaryTotal;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\OrderLineReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\OrderReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\OriginatorDocumentReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\OriginCountry;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PartyName;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PayeeFinancialAccount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PayeeParty;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PayeePartyBACIdentification;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PayeePartyIdentification;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PayeePartyLegalEntity;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PayeePartyName;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PayerFinancialAccount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PaymentMandate;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PaymentMeans;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PaymentTerms;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PostalAddress;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\Price;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\PriceAllowanceCharge;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\ProjectReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\ReceiptDocumentReference;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\SellerParty;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\SellerPartyIdentification;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\SellerPartyLegalEntity;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\SellerPartyTaxScheme;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\SellersItemIdentification;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\StandardItemIdentification;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\SubtotalTaxCategory;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\TaxCategory;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\TaxRepresentativeParty;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\TaxRepresentativePartyName;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\TaxRepresentativePartyTaxScheme;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\TaxScheme;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\TaxSubtotal;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Aggregate\TaxTotal;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\ActualDeliveryDate;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\AllowanceChargeAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\AllowanceTotalAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\BaseAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\BaseQuantity;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\ChargeTotalAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\DueDate;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\EndDate;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\EndpointIdentifier;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\InvoiceDocumentReferenceIssueDate;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\InvoicedQuantity;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\IssueDate;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\LineExtensionAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\Note;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\PayableAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\PayableRoundingAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\PaymentMeansNamedCode;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\PrepaidAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\PriceAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\StartDate;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\TaxableAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\TaxAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\TaxExclusiveAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\Basic\TaxInclusiveAmount;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\DataType\InvoiceTypeCode;
use Tiime\UniversalBusinessLanguage\Ubl21\Invoice\UniversalBusinessLanguage;

/**
 * @internal
 */
class CIIToUBLInvoice
{
    /**
     * BG-25
     */
    private static function getLines(BasicCrossIndustryInvoice $invoice): array
    {
        return array_map(
            static fn(BasicIncludedSupplyChainTradeLineItem $invoiceLine) => (new InvoiceLine(
                invoiceLineIdentifier: $invoiceLine->getAssociatedDocumentLineDocument()->getLineIdentifier(), // BT-126
                invoicedQuantity: new InvoicedQuantity(
                    value: $invoiceLine->getSpecifiedLineTradeDelivery()->getBilledQuantity()->getQuantity()->getValue(), // BT-129
                    unitCode: $invoiceLine->getSpecifiedLineTradeDelivery()->getBilledQuantity()->getUnitCode() // BT-130
                ),
                lineExtensionAmount: new LineExtensionAmount( // BT-131
                    value: $invoiceLine->getSpecifiedLineTradeSettlement()->getSpecifiedTradeSettlementLineMonetarySummation()->getLineTotalAmount()->getValue(),
                    currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                ),
                item: (new Item(
                    name: $invoiceLine->getSpecifiedTradeProduct()->getName(), // BT-153
                    classifiedTaxCategory: (new ClassifiedTaxCategory($invoiceLine->getSpecifiedLineTradeSettlement()->getApplicableTradeTax()->getCategoryCode())) // BT-151
                        ->setPercent($invoiceLine->getSpecifiedLineTradeSettlement()->getApplicableTradeTax()->getRateApplicablePercent()?->getValue()) // BT-152
                    ,
                ))
                    ->setDescription($invoiceLine instanceof EN16931IncludedSupplyChainTradeLineItem ? $invoiceLine->getSpecifiedTradeProduct()->getDescription() : null) // BT-154
                    ->setSellersItemIdentification( // BT-155
                        $invoiceLine instanceof EN16931IncludedSupplyChainTradeLineItem && $invoiceLine->getSpecifiedTradeProduct()->getSellerAssignedIdentifier() !== null ?
                            new SellersItemIdentification($invoiceLine->getSpecifiedTradeProduct()->getSellerAssignedIdentifier()->value) : null
                    )
                    ->setBuyersItemIdentification( // BT-156
                        $invoiceLine instanceof EN16931IncludedSupplyChainTradeLineItem && $invoiceLine->getSpecifiedTradeProduct()->getSellerAssignedIdentifier() !== null ?
                            new BuyersItemIdentification($invoiceLine->getSpecifiedTradeProduct()->getBuyerAssignedIdentifier()->value) : null
                    )
                    ->setStandardItemIdentification( // BT-157
                        $invoiceLine->getSpecifiedTradeProduct()->getGlobalIdentifier() !== null ?
                            new StandardItemIdentification($invoiceLine->getSpecifiedTradeProduct()->getGlobalIdentifier()) : null
                    )
                    ->setCommodityClassifications(
                        $invoiceLine instanceof EN16931IncludedSupplyChainTradeLineItem ?
                        array_map(
                            static fn(DesignatedProductClassification $classification) => (new CommodityClassification(
                                itemClassificationCode: $classification->getClassCode()->getValue(), // BT-158
                                listIdentifier: $classification->getClassCode()->getListIdentifier() // BT-158-1
                            ))
                                ->setListVersionIdentifier($classification->getClassCode()->getListVersionIdentifier())
                            ,
                            $invoiceLine->getSpecifiedTradeProduct()->getDesignatedProductClassifications()
                        ) : []
                    )
                    ->setOriginCountry( // BT-159
                        $invoiceLine instanceof EN16931IncludedSupplyChainTradeLineItem && $invoiceLine->getSpecifiedTradeProduct()->getOriginTradeCountry() !== null ?
                        new OriginCountry($invoiceLine->getSpecifiedTradeProduct()->getOriginTradeCountry()->getIdentifier()) : null
                    )
                    ->setAdditionalProperties( // BG-32
                        $invoiceLine instanceof EN16931IncludedSupplyChainTradeLineItem ?
                        array_map(
                            static fn(ApplicableProductCharacteristic $characteristic) => new AdditionalItemProperty(
                                name: $characteristic->getValue(),
                                value: $characteristic->getDescription(),
                            ),
                            $invoiceLine->getSpecifiedTradeProduct()->getApplicableProductCharacteristics()
                        ) : []
                    )
                ,
                price: (new Price( // BT-146
                    new PriceAmount(
                        value: $invoiceLine->getSpecifiedLineTradeAgreement()->getNetPriceProductTradePrice()->getChargeAmount()->getValue(),
                        currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                    )
                ))
                    ->setAllowance(
                        $invoiceLine->getSpecifiedLineTradeAgreement()->getGrossPriceProductTradePrice()?->getAppliedTradeAllowanceCharge() !== null ?
                            (new PriceAllowanceCharge( // BT-147 - todo 0..1 donc revoir condition
                                new AllowanceChargeAmount(
                                    value: $invoiceLine->getSpecifiedLineTradeAgreement()->getGrossPriceProductTradePrice()->getAppliedTradeAllowanceCharge()?->getActualAmount()->getValue(),
                                    currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                                )
                            ))
                                ->setBaseAmount(  // BT-148
                                    $invoiceLine->getSpecifiedLineTradeAgreement()->getGrossPriceProductTradePrice() !== null ?
                                        new BaseAmount(
                                            value: $invoiceLine->getSpecifiedLineTradeAgreement()->getGrossPriceProductTradePrice()->getChargeAmount()->getValue(),
                                            currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                                        ) : null
                                )
                            : null
                    )
                    ->setBaseQuantity( // BT-149
                        $invoiceLine->getSpecifiedLineTradeAgreement()->getNetPriceProductTradePrice()->getBasisQuantity() !== null ?
                            (new BaseQuantity($invoiceLine->getSpecifiedLineTradeAgreement()->getNetPriceProductTradePrice()->getBasisQuantity()->getValue()->getValue()))
                                ->setUnitCode( // BT-150
                                    $invoiceLine->getSpecifiedLineTradeAgreement()->getNetPriceProductTradePrice()->getBasisQuantity()->getUnitCode() !== null ?
                                        $invoiceLine->getSpecifiedLineTradeAgreement()->getNetPriceProductTradePrice()->getBasisQuantity()->getUnitCode() : null
                                )
                            : null
                    )
            ))
                ->setDocumentReference( // BT-128
                    $invoiceLine instanceof EN16931IncludedSupplyChainTradeLineItem && $invoiceLine->getSpecifiedLineTradeSettlement()->getAdditionalReferencedDocument() !== null ?
                        new DocumentReference($invoiceLine->getSpecifiedLineTradeSettlement()->getAdditionalReferencedDocument()->getIssuerAssignedIdentifier())
                        : null
                )
                ->setOrderLineReference( // BT-132
                    $invoiceLine instanceof EN16931IncludedSupplyChainTradeLineItem && $invoiceLine->getSpecifiedLineTradeAgreement()->getBuyerOrderReferencedDocument()?->getLineIdentifier() !== null ?
                        new OrderLineReference($invoiceLine->getSpecifiedLineTradeAgreement()->getBuyerOrderReferencedDocument()->getLineIdentifier()) : null
                )
                ->setAccountingCost( // BT-133
                    $invoiceLine instanceof EN16931IncludedSupplyChainTradeLineItem && $invoiceLine->getSpecifiedLineTradeSettlement()->getReceivableSpecifiedTradeAccountingAccount() !== null ?
                        $invoiceLine->getSpecifiedLineTradeSettlement()->getReceivableSpecifiedTradeAccountingAccount()->getIdentifier() : null
                )
                ->setInvoicePeriod(
                    $invoiceLine->getSpecifiedLineTradeSettlement()->getBillingSpecifiedPeriod() !== null ?
                        (new InvoiceLineInvoicePeriod())
                            ->setStartDate( // BT-134
                                $invoiceLine->getSpecifiedLineTradeSettlement()->getBillingSpecifiedPeriod()->getStartDateTime() !== null ?
                                    new StartDate($invoiceLine->getSpecifiedLineTradeSettlement()->getBillingSpecifiedPeriod()->getStartDateTime()->getDateTimeString())
                                    : null
                            )
                            ->setEndDate( // BT-135
                                $invoiceLine->getSpecifiedLineTradeSettlement()->getBillingSpecifiedPeriod()->getEndDateTime() !== null ?
                                    new EndDate($invoiceLine->getSpecifiedLineTradeSettlement()->getBillingSpecifiedPeriod()->getEndDateTime()->getDateTimeString())
                                    : null
                            )
                        : null
                )
                ->setAllowances( // BG-27
                    array_map(
                        static fn(BasicLineSpecifiedTradeAllowance $allowance) => (new InvoiceLineAllowance(
                            amount: new AllowanceChargeAmount(
                                value: $allowance->getActualAmount()->getValue(),
                                currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                            ) // BT-136
                        ))
                            ->setBaseAmount( // BT-137
                                $allowance instanceof EN16931LineSpecifiedTradeAllowance && $allowance->getBasisAmount() !== null ?
                                    new BaseAmount(
                                        value: $allowance->getBasisAmount()->getValue(),
                                        currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                                    ) : null
                            )
                            ->setMultiplierFactorNumeric( // BT-138
                                $allowance instanceof EN16931LineSpecifiedTradeAllowance && $allowance->getCalculationPercent() !== null ?
                                    $allowance->getCalculationPercent()?->getValue() : null
                            )
                            ->setAllowanceReason($allowance->getReason()) // BT-139
                            ->setAllowanceReasonCode($allowance->getReasonCode()) // BT-140
                        ,
                        $invoiceLine->getSpecifiedLineTradeSettlement()->getSpecifiedTradeAllowances()
                    )
                )
                ->setCharges( // BG-28
                    array_map(
                        static fn(BasicLineSpecifiedTradeAllowance $charge) => (new InvoiceLineCharge(
                            amount: new AllowanceChargeAmount(
                                value: $charge->getActualAmount()->getValue(),
                                currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                            ) // BT-141
                        ))
                            ->setBaseAmount( // BT-142
                                $charge instanceof EN16931LineSpecifiedTradeAllowance && $charge->getBasisAmount() !== null ?
                                    new BaseAmount(
                                        value: $charge->getBasisAmount()->getValue(),
                                        currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                                    ) : null
                            )
                            ->setMultiplierFactorNumeric( // BT-143
                                $charge instanceof EN16931LineSpecifiedTradeAllowance && $charge->getCalculationPercent() !== null ?
                                    $charge->getCalculationPercent()->getValue() : null
                            )
                            ->setChargeReason($charge->getReason()) // BT-144
                            ->setChargeReasonCode($charge->getReasonCode()) // BT-145
                        ,
                        $invoiceLine->getSpecifiedLineTradeSettlement()->getSpecifiedTradeCharges()
                    )
                )
            ,
            $invoice->getSupplyChainTradeTransaction()->getIncludedSupplyChainTradeLineItems()
        );
    }

    private static function getAccountingSupplierParty(BasicWLCrossIndustryInvoice $invoice): AccountingSupplierParty
    {
        return new AccountingSupplierParty( // BG-4
            party: (new SellerParty(
            // endpointIdentifier - 1..1 dans la lib UBL - doit être changé en 0..1
                endpointIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getURIUniversalCommunication() !== null ? // BT-34
                    new EndpointIdentifier(
                        value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getURIUniversalCommunication()->getElectronicAddress()->value,
                        scheme: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getURIUniversalCommunication()->getElectronicAddress()->scheme
                    ) : null,
                postalAddress: (new PostalAddress(new Country($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getPostalTradeAddress()->getCountryIdentifier()))) // BT-40
                    ->setStreetName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getPostalTradeAddress()->getLineOne()) // BT-35
                    ->setAdditionalStreetName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getPostalTradeAddress()->getLineTwo()) //BT-36
                    ->setAddressLine( // BT-162
                        $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getPostalTradeAddress()->getLineThree() !== null ?
                            new AddressLine($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getPostalTradeAddress()->getLineThree()) : null
                    )
                    ->setCityName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getPostalTradeAddress()->getCityName()) // BT-37
                    ->setPostalZone($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getPostalTradeAddress()->getPostcodeCode()) // BT-38
                    ->setCountrySubentity($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getPostalTradeAddress()->getCountrySubDivisionName()), // BT-39,
                partyLegalEntity: (new SellerPartyLegalEntity($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getName())) // BT-27
                    ->setIdentifier($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getSpecifiedLegalOrganization()?->getIdentifier()) // BT-30
                    ->setCompanyLegalForm($invoice instanceof EN16931CrossIndustryInvoice ? $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getDescription() : null) // BT-33
            ))
                ->setPartyName( // BT-28
                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getSpecifiedLegalOrganization()?->getTradingBusinessName() !== null ?
                        new PartyName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getSpecifiedLegalOrganization()->getTradingBusinessName()) : null
                )
                ->setPartyTaxSchemes(
                    array_merge(
                        $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getSpecifiedTaxRegistrationVA() !== null ?
                            [new SellerPartyTaxScheme(
                                companyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getSpecifiedTaxRegistrationVA()->getIdentifier(),
                                taxScheme: new TaxScheme('VAT')
                            )] : [], // BT-31
                        $invoice instanceof EN16931CrossIndustryInvoice && $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getSpecifiedTaxRegistrationFC() !== null ?
                            [new SellerPartyTaxScheme(
                                companyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getSpecifiedTaxRegistrationFC()->getIdentifier(),
                                taxScheme: new TaxScheme('LOC')
                            )] : [], // BT-32
                    )
                )
                ->setContact( // BG-6
                    $invoice instanceof EN16931CrossIndustryInvoice && $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getDefinedTradeContact() !== null ?
                        (new Contact())
                            ->setName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getDefinedTradeContact()->getPersonName()) // BT-41
                            ->setTelephone($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getDefinedTradeContact()->getTelephoneUniversalCommunication()?->getCompleteNumber()) // BT-42
                            ->setElectronicMail($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getDefinedTradeContact()->getEmailURIUniversalCommunication()?->getUriIdentifier()) // BT-43
                        : null
                )
                ->setPartyIdentifications( // BT-90 + BT-29
                    array_merge(
                        $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getCreditorReferenceIdentifier() !== null ?
                            [
                                new SellerPartyIdentification(new SellerIdentifier(
                                    value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getCreditorReferenceIdentifier()->value
                                    // scheme: '' : no scheme needed here but for others yes ?
                                ))
                            ] : [],
                        array_map(
                            static fn (SellerIdentifier $identifier) => new SellerPartyIdentification(new SellerIdentifier(
                                value: $identifier->value,
                                // scheme: '' : todo 1..1 in FR spec but not mentionned in CII
                            )),
                            $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getIdentifiers()
                        ),
                        array_map(
                            static fn (SellerGlobalIdentifier $identifier) => new SellerPartyIdentification(new SellerIdentifier(
                                value: $identifier->value,
                                scheme: $identifier->scheme
                            )),
                            $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTradeParty()->getGlobalIdentifiers()
                        ),
                    )
                )
        );
    }

    private static function getAccountingCustomerParty(BasicWLCrossIndustryInvoice $invoice): AccountingCustomerParty
    {
        return new AccountingCustomerParty( // BG-7
            party: (new BuyerParty(
                endpointIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getURIUniversalCommunication() !== null ?
                    new EndpointIdentifier(
                        value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getURIUniversalCommunication()->getElectronicAddress()->value,
                        scheme: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getURIUniversalCommunication()->getElectronicAddress()->scheme
                    ) : null, // BT-49
                postalAddress: (new PostalAddress(country: new Country($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getPostalTradeAddress()->getCountryIdentifier()))) // BT-55
                    ->setStreetName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getPostalTradeAddress()->getLineOne()) // BT-50
                    ->setAdditionalStreetName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getPostalTradeAddress()->getLineTwo()) // BT-51
                    ->setAddressLine( // BT-163
                        $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getPostalTradeAddress()->getLineThree() !== null ?
                            new AddressLine($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getPostalTradeAddress()->getLineThree()) : null
                    )
                    ->setCityName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getPostalTradeAddress()->getCityName()) // BT-52
                    ->setPostalZone($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getPostalTradeAddress()->getPostcodeCode()) // BT-53
                    ->setCountrySubentity($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getPostalTradeAddress()->getCountrySubDivisionName()), // BT-54
                partyLegalEntity: (new BuyerPartyLegalEntity($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getName())) // BT-44
                    ->setIdentifier($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getSpecifiedLegalOrganization()?->getIdentifier()) // BT-47
            ))
                ->setPartyName( // BT-45
                    $invoice instanceof EN16931CrossIndustryInvoice && $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getSpecifiedLegalOrganization()?->getTradingBusinessName() !== null ?
                        new PartyName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getSpecifiedLegalOrganization()->getTradingBusinessName()) : null
                )
                ->setPartyIdentification( // BT-46 : 0..n spec fr + scheme 1..1 in FR spec but scheme not mandatory in CII
                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getGlobalIdentifier() !== null ?
                        new BuyerPartyIdentification(new BuyerIdentifier(
                            value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getGlobalIdentifier()->value,
                            scheme: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getGlobalIdentifier()->scheme,
                        )) : ($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getIdentifier() !== null ?
                            new BuyerPartyIdentification($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getIdentifier()) : null)
                )
                ->setPartyTaxScheme( // BT-48
                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getSpecifiedTaxRegistrationVA() !== null ?
                        new BuyerPartyTaxScheme(
                            companyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getSpecifiedTaxRegistrationVA()->getIdentifier(),
                            taxScheme: new TaxScheme($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getSpecifiedTaxRegistrationVA()->getSchemeIdentifier())
                        ) : null
                )
                ->setContact( // BG-9
                    $invoice instanceof EN16931CrossIndustryInvoice && $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getDefinedTradeContact() !== null ?
                        (new Contact())
                            ->setName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getDefinedTradeContact()->getPersonName()) // BT-56
                            ->setTelephone($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getDefinedTradeContact()->getTelephoneUniversalCommunication()?->getCompleteNumber()) // BT-57
                            ->setElectronicMail($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerTradeParty()->getDefinedTradeContact()->getEmailURIUniversalCommunication()?->getUriIdentifier()) // BT-58
                        : null
                )
        );
    }

    private static function getLegalMonetaryTotal(BasicWLCrossIndustryInvoice $invoice): LegalMonetaryTotal
    {
        return (new LegalMonetaryTotal( // BG-22
            lineExtensionAmount: new LineExtensionAmount(
                value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getLineTotalAmount()->getValue(),
                currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
            ), // BT-106
            taxExclusiveAmount: new TaxExclusiveAmount(
                value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getTaxBasisTotalAmount()->getValue(),
                currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
            ), // BT-109
            taxInclusiveAmount: new TaxInclusiveAmount(
                value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getGrandTotalAmount()->getValue(),
                currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
            ), // BT-112
            payableAmount: new PayableAmount(
                value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getDuePayableAmount()->getValue(),
                currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
            ) // BT-115
        ))
            ->setPayableRoundingAmount( // BT-114 (EN)
                $invoice instanceof EN16931CrossIndustryInvoice ?
                    new PayableRoundingAmount(
                        value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getRoundingAmount()?->getValue(),
                        currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                    ) : null
            )
            ->setAllowanceTotalAmount( // BT-107
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getAllowanceTotalAmount() !== null ?
                    new AllowanceTotalAmount(
                        value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getAllowanceTotalAmount()->getValue(),
                        currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                    ) : null
            )
            ->setChargeTotalAmount( // BT-108
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getChargeTotalAmount() !== null ?
                    new ChargeTotalAmount(
                        value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getChargeTotalAmount()->getValue(),
                        currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                    ) : null
            )
            ->setPrepaidAmount( // BT-113
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getTotalPrepaidAmount() !== null ?
                    new PrepaidAmount(
                        value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getTotalPrepaidAmount()->getValue(),
                        currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                    ) : null
            )
        ;
    }

    private static function getInvoiceAllowances(BasicWLCrossIndustryInvoice $invoice): array
    {
        return array_map(
            static fn (SpecifiedTradeAllowance $allowance) => (new Allowance(
                amount: new AllowanceChargeAmount(
                    value: $allowance->getActualAmount()->getValue(), // BT-92
                    currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                ),
                taxCategory: (new TaxCategory($allowance->getAllowanceCategoryTradeTax()->getCategoryCode())) // BT-95
                ->setPercent($allowance->getAllowanceCategoryTradeTax()->getRateApplicablePercent()?->getValue()) // BT-96
            ))
                ->setBaseAmount(
                    $allowance->getBasisAmount() !== null ?
                        new BaseAmount(
                            value: $allowance->getBasisAmount()->getValue(),
                            currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                        ) : null
                ) // BT-93
                ->setMultiplierFactorNumeric($allowance->getCalculationPercent()?->getValue()) // BT-94
                ->setAllowanceReason($allowance->getReason()) // BT-97
                ->setAllowanceReasonCode($allowance->getReasonCode()) // BT-98
            ,
            $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeAllowances()
        );
    }

    private static function getInvoiceCharges(BasicWLCrossIndustryInvoice $invoice): array
    {
        return array_map(
            static fn (SpecifiedTradeCharge $charge) => (new Charge(
                amount: new AllowanceChargeAmount(
                    value: $charge->getActualAmount()->getValue(), // BT-99
                    currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                ),
                taxCategory: (new TaxCategory($charge->getCategoryTradeTax()->getCategoryCode())) // BT-102
                    ->setPercent($charge->getCategoryTradeTax()->getRateApplicablePercent()?->getValue()) // BT-103
            ))
                ->setBaseAmount(
                    $charge->getBasisAmount() !== null ?
                        new BaseAmount(
                            value: $charge->getBasisAmount()->getValue(),
                            currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                        ) : null
                ) // BT-100
                ->setMultiplierFactorNumeric($charge->getCalculationPercent()?->getValue()) // BT-101
                ->setChargeReason($charge->getReason()) // BT-104
                ->setChargeReasonCode($charge->getReasonCode()) // BT-105)
            ,
            $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeCharges()
        );
    }

    private static function getTaxRepresentativeParty(SellerTaxRepresentativeTradeParty $sellerTaxRepresentativeTradeParty): TaxRepresentativeParty
    {
        return new TaxRepresentativeParty(
            partyName: new TaxRepresentativePartyName($sellerTaxRepresentativeTradeParty->getName()), // BT-62
            postalAddress: (new PostalAddress(new Country($sellerTaxRepresentativeTradeParty->getPostalTradeAddress()->getCountryIdentifier()))) // BT-69
                ->setStreetName($sellerTaxRepresentativeTradeParty->getPostalTradeAddress()->getLineOne()) // BT-64
                ->setAdditionalStreetName($sellerTaxRepresentativeTradeParty->getPostalTradeAddress()->getLineTwo()) // BT-65
                ->setAddressLine( // BT-164
                    $sellerTaxRepresentativeTradeParty->getPostalTradeAddress()->getLineThree() !== null ?
                        new AddressLine($sellerTaxRepresentativeTradeParty->getPostalTradeAddress()->getLineThree()) : null
                )
                ->setCityName($sellerTaxRepresentativeTradeParty->getPostalTradeAddress()->getCityName()) // BT-66
                ->setPostalZone($sellerTaxRepresentativeTradeParty->getPostalTradeAddress()->getPostcodeCode()) // BT-67
                ->setCountrySubentity($sellerTaxRepresentativeTradeParty->getPostalTradeAddress()->getCountrySubDivisionName()), // BT-68
            partyTaxScheme: new TaxRepresentativePartyTaxScheme(
                companyIdentifier: $sellerTaxRepresentativeTradeParty->getSpecifiedTaxRegistrationVA()->getIdentifier(), // BT-63
                taxScheme: new TaxScheme($sellerTaxRepresentativeTradeParty->getSpecifiedTaxRegistrationVA()->getSchemeIdentifier()) // BT-63-1
            )
        );
    }

    /**
     * @param array<int, InvoiceReferencedDocument> $invoiceReferencedDocuments
     * @return array<int, BillingReference>
     */
    private static function getBillingReferences(array $invoiceReferencedDocuments): array
    {
        return array_map(
            static fn (InvoiceReferencedDocument $document) => new BillingReference(
                (new InvoiceDocumentReference($document->getIssuerAssignedIdentifier())) // BT-25
                    ->setIssueDate( // BT-26
                        $document->getFormattedIssueDateTime() !== null ?
                            new InvoiceDocumentReferenceIssueDate($document->getFormattedIssueDateTime()->getDateTimeString()) : null
                    )
            ),
            $invoiceReferencedDocuments
        );
    }

    private static function getAdditionalDocumentReferences(EN16931CrossIndustryInvoice $invoice): array
    {
        return array_merge(
            array_map(
                static fn (AdditionalReferencedDocumentAdditionalSupportingDocument $document) => (new AdditionalDocumentReference(
                    identifier: new ObjectIdentifier($document->getIssuerAssignedIdentifier()->value) // BT-122
                ))
                    ->setDocumentDescription($document->getName()) // BT-123
                    ->setAttachment(
                        (new Attachment())
                            ->setExternalReference( // BT-124
                                $document->getUriIdentifier() !== null ? new ExternalReference($document->getUriIdentifier()) : null
                            )
                            ->setEmbeddedDocumentBinaryObject($document->getAttachmentBinaryObject()) // BT-125
                    )
                ,
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocuments()
            ),
            $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentTenderOrLotReference() !== null ?
                [
                    (new AdditionalDocumentReference(
                        identifier: new ObjectIdentifier($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentTenderOrLotReference()->getIssuerAssignedIdentifier()->value) // BT-122
                    ))
                        ->setDocumentDescription($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentTenderOrLotReference()->getName()) // BT-123
                        ->setAttachment(
                            (new Attachment())
                                ->setExternalReference( // BT-124
                                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentTenderOrLotReference()->getUriIdentifier() !== null ?
                                        new ExternalReference($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentTenderOrLotReference()->getUriIdentifier())
                                        : null
                                )
                                ->setEmbeddedDocumentBinaryObject($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentTenderOrLotReference()->getAttachmentBinaryObject())
                        )
                ] : [],
            $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentInvoicedObjectIdentifier() !== null ?
                [
                    (new AdditionalDocumentReference(
                        identifier: new ObjectIdentifier($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentInvoicedObjectIdentifier()->getIssuerAssignedIdentifier()->value) // BT-122
                    ))
                        ->setDocumentDescription($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentInvoicedObjectIdentifier()->getName()) // BT-123
                        ->setAttachment(
                            (new Attachment())
                                ->setExternalReference( // BT-124
                                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentInvoicedObjectIdentifier()->getUriIdentifier() !== null ?
                                        new ExternalReference($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentInvoicedObjectIdentifier()->getUriIdentifier())
                                        : null
                                )
                                ->setEmbeddedDocumentBinaryObject($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentInvoicedObjectIdentifier()->getAttachmentBinaryObject())
                        )
                        ->setDocumentTypeCode($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentInvoicedObjectIdentifier()->getReferenceTypeCode()) // BT-18-1
                        // Only specified for this one because only present for this type of document
                ] : [],
        );
    }

    private static function getDelivery(BasicWLCrossIndustryInvoice $invoice): ?Delivery
    {
        return $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty() !== null ?
            (new Delivery())
                ->setDeliveryParty( // BT-70
                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getName() !== null ?
                        new DeliveryParty(new DeliveryPartyName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getName()))
                        : null
                )
                ->setDeliveryLocation(
                    (new DeliveryLocation())
                        ->setIdentifier( // BT-71
                            $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getGlobalIdentifier() !== null || $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getIdentifier() !== null ?
                                new LocationIdentifier(
                                    value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getGlobalIdentifier()?->value ?? $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getIdentifier()?->value ?? null,
                                    scheme: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getGlobalIdentifier()?->scheme ?? null,
                                ) : null
                        )
                        ->setAddress( // BG-15
                            $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getPostalTradeAddress() !== null ?
                                (new DeliveryAddress(new Country($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getPostalTradeAddress()->getCountryIdentifier()))) // BT-80
                                ->setStreetName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getPostalTradeAddress()->getLineOne()) // BT-75
                                ->setAdditionalStreetName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getPostalTradeAddress()->getLineTwo()) // BT-76
                                ->setAddressLine( // BT-165
                                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getPostalTradeAddress()->getLineThree() !== null ?
                                        new AddressLine($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getPostalTradeAddress()->getLineThree()) : null
                                )
                                    ->setCityName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getPostalTradeAddress()->getCityName()) // BT-77
                                    ->setPostalZone($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getPostalTradeAddress()->getPostcodeCode()) // BT-78
                                    ->setCountrySubentity($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getShipToTradeParty()->getPostalTradeAddress()->getCountrySubDivisionName()) // BT-79
                                : null
                        )
                )
                ->setActualDeliveryDate( // BT-72
                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getActualDeliverySupplyChainEvent() !== null ?
                        new ActualDeliveryDate($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getActualDeliverySupplyChainEvent()->getOccurrenceDateTime()->getDateTimeString())
                        : null
                )
            : null;
    }

    private static function getPaymentMeans(BasicWLCrossIndustryInvoice $invoice): array
    {
        return array_map(
            static fn (SpecifiedTradeSettlementPaymentMeans $payment) => (new PaymentMeans(
                (new PaymentMeansNamedCode($payment->getTypeCode())) // BT-81
                ->setName($payment instanceof EN16931SpecifiedTradeSettlementPaymentMeans ? $payment->getInformation() : null) // BT-82
            ))
                ->setPaymentIdentifier($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getPaymentReference()) // BT-83
                ->setPayeeFinancialAccount( // BG-17
                    $payment->getPayeePartyCreditorFinancialAccount() !== null && ($payment->getPayeePartyCreditorFinancialAccount()->getIbanIdentifier() !== null || $payment->getPayeePartyCreditorFinancialAccount()->getProprietaryIdentifier() !== null) ?
                        (new PayeeFinancialAccount($payment->getPayeePartyCreditorFinancialAccount()->getIbanIdentifier() ?? $payment->getPayeePartyCreditorFinancialAccount()->getProprietaryIdentifier())) // BT-84
                        ->setPaymentAccountName($payment instanceof EN16931SpecifiedTradeSettlementPaymentMeans ? $payment->getPayeePartyCreditorFinancialAccount()->getAccountName() : null) // BT-85
                        ->setFinancialInstitutionBranch( // BT-86
                            $payment instanceof EN16931SpecifiedTradeSettlementPaymentMeans && $payment->getPayeeSpecifiedCreditorFinancialInstitution() !== null ?
                                new FinancialInstitutionBranch($payment->getPayeeSpecifiedCreditorFinancialInstitution()->getBicIdentifier()) : null
                        )
                        : null
                )
                ->setCardAccount( // BG-18
                    $payment instanceof EN16931SpecifiedTradeSettlementPaymentMeans && $payment->getApplicableTradeSettlementFinancialCard() !== null ?
                        (new CardAccount(
                            primaryAccountNumberIdentifier: $payment->getApplicableTradeSettlementFinancialCard()->getIdentifier(), // BT-87
                            networkIdentifier: '', // todo existe pas ?
                        ))
                            ->setHolderName($payment->getApplicableTradeSettlementFinancialCard()->getCardholderName()) // BT-88
                        : null
                )
                ->setPaymentMandate( // BG-19
                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradePaymentTerms()?->getDirectDebitMandateIdentifier() !== null || $payment->getPayerPartyDebtorFinancialAccount() !== null ?
                        (new PaymentMandate())
                            ->setIdentifier($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradePaymentTerms()?->getDirectDebitMandateIdentifier()) // BT-89
                            ->setPayerFinancialAccount( // BT-91
                                $payment->getPayerPartyDebtorFinancialAccount() !== null ?
                                    new PayerFinancialAccount($payment->getPayerPartyDebtorFinancialAccount()->getIbanIdentifier()) : null
                            )
                        : null
                )
            ,
            $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementPaymentMeans()
        );
    }

    public static function convert(BasicWLCrossIndustryInvoice $invoice) //: UniversalBusinessLanguageInterface @todo when one interface
    {
        // BG-1
        // CII : 0..n - UBL 2.1 notre lib : 0..1
        // BT-21 : 0..1
        // BT-22 : 1..1



        return (new UniversalBusinessLanguage(
            identifier: $invoice->getExchangedDocument()->getIdentifier(), // BT-1
            issueDate: new IssueDate($invoice->getExchangedDocument()->getIssueDateTime()->getDateTimeString()), // BT-2-00
            invoiceTypeCode: InvoiceTypeCode::from($invoice->getExchangedDocument()->getTypeCode()->value), // BT-3
            documentCurrencyCode: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode(), // BT-5
            customizationIdentifier: $invoice->getExchangedDocumentContext()->getGuidelineSpecifiedDocumentContextParameter()->getIdentifier(), // BT-24
            accountingSupplierParty: self::getAccountingSupplierParty($invoice),
            accountingCustomerParty: self::getAccountingCustomerParty($invoice),
            taxTotals: array_merge(
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getTaxTotalAmount() instanceof TaxTotalAmount ?
                    [(new TaxTotal(
                        new TaxAmount(
                            value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getTaxTotalAmount()->getValue()->getValue(),
                            currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getTaxTotalAmount()->getCurrencyIdentifier()
                        )
                    ))
                        ->setTaxSubtotals( // BG-23
                            array_map(
                                static fn (HeaderApplicableTradeTax $tax) => new TaxSubtotal(
                                    taxableAmount: new TaxableAmount(
                                        value: $tax->getBasisAmount()->getValue(),
                                        currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                                    ), // BT-116
                                    taxAmount: new TaxAmount(
                                        value: $tax->getCalculatedAmount()->getValue(),
                                        currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceCurrencyCode()
                                    ), // BT-117
                                    taxCategory: (new SubtotalTaxCategory(
                                        identifier: $tax->getCategoryCode()  // BT-118,
                                    ))
                                        ->setPercent($tax->getRateApplicablePercent()?->getValue()) // BT-119
                                        ->setTaxExemptionReason($tax->getExemptionReason()) // BT-120
                                        ->setTaxExemptionReasonCode($tax->getExemptionReasonCode()) // BT-121
                                ),
                                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getApplicableTradeTaxes()
                            )
                        )
                    ]: [],
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getTaxTotalAmountCurrency() instanceof TaxTotalAmount ?
                    [new TaxTotal(
                        new TaxAmount(
                            value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getTaxTotalAmountCurrency()->getValue()->getValue(),
                            currencyIdentifier: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradeSettlementHeaderMonetarySummation()->getTaxTotalAmountCurrency()->getCurrencyIdentifier()
                        )
                    )] : []
            ),
            legalMonetaryTotal: self::getLegalMonetaryTotal($invoice),
            invoiceLines: $invoice instanceof BasicCrossIndustryInvoice ? self::getLines($invoice) : [] // todo 1..n but what happen when BasicWL ?
        ))
            ->setTaxCurrencyCode($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getTaxCurrencyCode()) // BT-6
            ->setTaxPointDate( // BT-7
                $invoice instanceof EN16931CrossIndustryInvoice && $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getApplicableTradeTaxes()[0]->getTaxPointDate() !== null ?
                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getApplicableTradeTaxes()[0]->getTaxPointDate()->getDateString() : null
            )
            ->setInvoicePeriod( // BT-8-00
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getApplicableTradeTaxes()[0]->getDueDateTypeCode() !== null ?
                    (new InvoicePeriod())
                        ->setDescriptionCode(
                            TimeReferencingCodeUNTDID2005ToTimeReferencingCodeUNTDID2475::convertToUNTDID2005($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getApplicableTradeTaxes()[0]->getDueDateTypeCode())
                        )
                    : null
            )
            ->setDueDate(
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradePaymentTerms()?->getDueDateDateTime() !== null ?
                    new DueDate($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradePaymentTerms()?->getDueDateDateTime()->getDateTimeString()) : null
            ) // BT-9-00
            ->setBuyerReference($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerReference()) // BT-10
            ->setProjectReference( // BT-11 (EN)
                $invoice instanceof EN16931CrossIndustryInvoice && $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSpecifiedProcuringProject() !== null ?
                    new ProjectReference($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSpecifiedProcuringProject()->getIdentifier()->value): null
            )
            ->setContractDocumentReference( // BT-12-00
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getContractReferencedDocument() !== null ?
                    new ContractDocumentReference($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getContractReferencedDocument()->getIssuerAssignedIdentifier()->value) : null
            )
            ->setOrderReference( // BT-13 + BT-14 (EN)
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerOrderReferencedDocument() !== null ?
                    (new OrderReference($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getBuyerOrderReferencedDocument()->getIssuerAssignedIdentifier()))
                        ->setSalesOrderIdentifier( // BT-14 (EN)
                            $invoice instanceof EN16931CrossIndustryInvoice && $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerOrderReferencedDocument() !== null ?
                                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerOrderReferencedDocument()->getIssuerAssignedIdentifier() : null
                        )
                    : null
            )
            ->setReceiptDocumentReference( // BT-15 (EN)
                $invoice instanceof EN16931CrossIndustryInvoice && $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getReceivingAdviceReferencedDocument() !== null ?
                    new ReceiptDocumentReference($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getReceivingAdviceReferencedDocument()->getIssuerAssignedIdentifier()->value) : null
            )
            ->setDespatchDocumentReference( // BT-16-00
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getDespatchAdviceReferencedDocument() !== null ?
                    new DespatchDocumentReference($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeDelivery()->getDespatchAdviceReferencedDocument()->getIssuerAssignedIdentifier()->value) : null
            )
            ->setOriginatorDocumentReference( // BT-17
                $invoice instanceof EN16931CrossIndustryInvoice && $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentTenderOrLotReference() !== null ?
                    new OriginatorDocumentReference($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getAdditionalReferencedDocumentTenderOrLotReference()->getIssuerAssignedIdentifier()->value) : null
            )
            ->setAccountingCost( // BT-19
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getReceivableSpecifiedTradeAccountingAccount() != null ?
                    $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getReceivableSpecifiedTradeAccountingAccount()->getIdentifier() : null
            )
            ->setPaymentTerms( // BT-20
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradePaymentTerms() !== null ?
                    new PaymentTerms($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getSpecifiedTradePaymentTerms()->getDescription()) : null
            )
            ->setNotes( // BG-1-00
                array_map(
                    static fn(DocumentIncludedNote $note) => new Note(
                        subjectCode: $note->getSubjectCode(), content: $note->getContent(),
                    ),
                    $invoice->getExchangedDocument()->getIncludedNotes()
                )
            )
            ->setProfileIdentifier($invoice->getExchangedDocumentContext()->getBusinessProcessSpecifiedDocumentContextParameter()->getIdentifier()) // BT-23
            ->setBillingReferences(self::getBillingReferences($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getInvoiceReferencedDocuments())) // BG-3
            ->setTaxRepresentativeParty( // BG-11
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTaxRepresentativeTradeParty() !== null ?
                    self::getTaxRepresentativeParty($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeAgreement()->getSellerTaxRepresentativeTradeParty()) : null
            )
            ->setPaymentMeans(self::getPaymentMeans($invoice))
            ->setPayeeParty( // BG-10
                $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getPayeeTradeParty() !== null ?
                    (new PayeeParty(
                        partyName: new PayeePartyName($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getPayeeTradeParty()->getName()), // BT-59
                        partyIdentification: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getPayeeTradeParty()->getGlobalIdentifier() !== null ?
                            new PayeePartyIdentification(new PayeeIdentifier(
                                value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getPayeeTradeParty()->getGlobalIdentifier()->value,
                                scheme: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getPayeeTradeParty()->getGlobalIdentifier()->scheme,
                            )) : ($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getPayeeTradeParty()->getIdentifier() !== null ?
                                new PayeePartyIdentification(new PayeeIdentifier( // todo BT-60 CII scheme does not exist but 1..1 in UBL
                                    value: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getPayeeTradeParty()->getIdentifier()->value,
                                )) : null),
                        partyBACIdentification: $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getCreditorReferenceIdentifier() !== null ? // BT-90
                            new PayeePartyBACIdentification($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getCreditorReferenceIdentifier()->value) : null
                    ))
                        ->setPartyLegalEntity( // BT-61
                            $invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getPayeeTradeParty()->getSpecifiedLegalOrganization()?->getIdentifier() !== null ?
                                new PayeePartyLegalEntity($invoice->getSupplyChainTradeTransaction()->getApplicableHeaderTradeSettlement()->getPayeeTradeParty()->getSpecifiedLegalOrganization()->getIdentifier()) : null
                        )
                    : null
            )
            ->setAllowances(self::getInvoiceAllowances($invoice)) // BG-20
            ->setCharges(self::getInvoiceCharges($invoice)) // BG-21
            ->setDelivery(self::getDelivery($invoice)) // BG-13
            ->setAdditionalDocumentReferences($invoice instanceof EN16931CrossIndustryInvoice ? self::getAdditionalDocumentReferences($invoice) : []) // BG-24
        ;
    }

    // BT-18 : EN - todo que mettre ?
    // BT-32 : EN
}