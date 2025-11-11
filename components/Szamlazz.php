<?php
namespace app\components;

use app\components\SzamlazzHU\Currency;
use app\components\SzamlazzHU\document\invoice\Invoice;
use app\components\SzamlazzHU\item\InvoiceItem;
use app\components\SzamlazzHU\item\ReceiptItem;
use app\components\SzamlazzHU\Language;
use app\components\SzamlazzHU\response\SzamlaAgentResponse;
use app\components\SzamlazzHU\SzamlaAgentAPI;
use app\components\SzamlazzHU\SzamlaAgentException;
use app\models\Beallitasok;

class Szamlazz {
    //const API_KEY = '97039xbwy2gws4iv7yn4xk8cniuird56tyamat6gy3';
    //const PREFIX = 'TST';

    public static function generateReceipt($email, $items, $lang = 'hu') {
        try {
            $agent = SzamlaAgentAPI::create(Beallitasok::get('szamlazzhu_api_kulcs'));

            $agent->setLogLevel(\app\components\SzamlazzHU\Log::LOG_LEVEL_OFF);
            $agent->setResponseType(SzamlaAgentResponse::RESULT_AS_XML);
            //$agent->setAggregator('ACV');
            $agent->setXmlFileSave(false);
            $agent->setDownloadPdf(true);

            $invoice = new SzamlazzHU\document\receipt\Receipt(SzamlazzHU\document\receipt\Receipt::DOCUMENT_TYPE_RECEIPT);

            $header = $invoice->getHeader();
            // Számla fizetési módja (bankkártya)
            $header->setPaymentMethod(Invoice::PAYMENT_METHOD_BANKCARD);
            $header->setBuyerLedgerId($email);
            $header->setPrefix(Beallitasok::get('szamlazzhu_nyugta_elotag'));

            foreach ($items as $item) {
                $gross_unit_price = intval($item['price']);
                $net_unit_price = round($gross_unit_price / (1 + (intval($item['vat']) / 100)) * 100) / 100;

                $invoiceItem = new ReceiptItem(
                    $item['name'],
                    $net_unit_price,
                    $item['amount'],
                    'db',
                    strval($item['vat']) // '5', '18', '27'
                );

                $gross = $gross_unit_price * intval($item['amount']);
                $vat = $gross - ($net_unit_price * intval($item['amount']));
                $net = $net_unit_price * intval($item['amount']);

                $invoiceItem->setVatAmount($vat); // Az x db termék áfája
                $invoiceItem->setNetPrice($net); // Az x db termék nettó ára
                $invoiceItem->setGrossAmount($gross); // Az x db termék bruttó ára

                $invoice->addItem($invoiceItem);
            }

            $result = $agent->generateReceipt($invoice);

            if ($result->isSuccess()) {
                return $result->getDocumentNumber();
            } else {
                return null;
            }

        } catch (SzamlaAgentException $e) {
            var_dump($e);
            return null;
        }
    }

    public static function generateCancelInvoice($invoiceNumber) {
        try {
            $agent = SzamlaAgentAPI::create(Beallitasok::get('szamlazzhu_api_kulcs'));

            $agent->setLogLevel(\app\components\SzamlazzHU\Log::LOG_LEVEL_OFF);
            $agent->setResponseType(SzamlaAgentResponse::RESULT_AS_XML);
            //$agent->setAggregator('AV');
            $agent->setXmlFileSave(false);
            $agent->setDownloadPdf(true);

            $invoice = new SzamlazzHU\document\invoice\ReverseInvoice(Beallitasok::get('szamlazzhu_szamla_tipus') == 'elektronikus' ? Invoice::INVOICE_TYPE_E_INVOICE : Invoice::INVOICE_TYPE_P_INVOICE);

            $header = $invoice->getHeader();
            // Papír vagy e-számla
            $header->setInvoiceType(Beallitasok::get('szamlazzhu_szamla_tipus') == 'elektronikus' ? Invoice::INVOICE_TYPE_E_INVOICE : Invoice::INVOICE_TYPE_P_INVOICE);
            // Számla fizetési módja (bankkártya)
            $header->setReserveInvoice(true);
            $header->setInvoiceNumber($invoiceNumber);

            $result = $agent->generateReverseInvoice($invoice);

            if ($result->isSuccess()) {
                return $result->getDocumentNumber();
            } else {
                return null;
            }
        } catch (\Throwable $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public static function generateInvoice($buyer, $items, $paymentMethod = '', $date = null) {
        try {
            $agent = SzamlaAgentAPI::create(Beallitasok::get('szamlazzhu_api_kulcs'));

            $agent->setLogLevel(\app\components\SzamlazzHU\Log::LOG_LEVEL_OFF);
            $agent->setResponseType(SzamlaAgentResponse::RESULT_AS_XML);
            //$agent->setAggregator('AV');
            $agent->setXmlFileSave(false);
            $agent->setDownloadPdf(true);

            $invoice = new SzamlazzHU\document\invoice\Invoice(Beallitasok::get('szamlazzhu_szamla_tipus') == 'elektronikus' ? Invoice::INVOICE_TYPE_E_INVOICE : Invoice::INVOICE_TYPE_P_INVOICE);

            $buyerObj = new \app\components\SzamlazzHU\Buyer(
                $buyer['name'],
                $buyer['zip'],
                $buyer['city'],
                $buyer['street']
            );
            $buyerObj->setCountry($buyer['country'] ?? '');
            $buyerObj->setTaxNumber($buyer['tax_number'] ?? '');
            $invoice->setBuyer($buyerObj);

            // Számla fejléce
            $header = $invoice->getHeader();
            // Papír vagy e-számla
            $header->setInvoiceType(Beallitasok::get('szamlazzhu_szamla_tipus') == 'elektronikus' ? Invoice::INVOICE_TYPE_E_INVOICE : Invoice::INVOICE_TYPE_P_INVOICE);
            // Számla fizetési módja (bankkártya)
            $header->setPaymentMethod($paymentMethod);
            // Számla pénzneme
            $header->setCurrency(Currency::CURRENCY_HUF);
            // Számla nyelve
            $header->setLanguage(Language::LANGUAGE_HU);
            // Számla kifizetettség (fizetve)
            $header->setPaid(true);
            // Számla teljesítés dátuma
            $header->setFulfillment($date ?: date('Y-m-d'));
            // Számla fizetési határideje
            $header->setPaymentDue($date ?: date('Y-m-d'));
            // Egyedi számlaelőtag használata
            $header->setPrefix(Beallitasok::get('szamlazzhu_elotag'));
            // Egyedi számlasablon használata
            $header->setInvoiceTemplate(Invoice::INVOICE_TEMPLATE_DEFAULT);
            // Előnézeti PDF beállítása
            $header->setPreviewPdf(false);

            foreach ($items as $item) {
                $gross_unit_price = intval($item['unit_price_gross']);
                $net_unit_price = $gross_unit_price / (1 + (intval($item['vat']) / 100));

                $invoiceItem = new InvoiceItem(
                    $item['name'],
                    $net_unit_price,
                    $item['amount'],
                    $item['unit'],
                    strval($item['vat']) // '5', '18', '27'
                );

                $gross = $gross_unit_price * intval($item['amount']);
                $vat = $gross - ($net_unit_price * intval($item['amount']));
                $net = $net_unit_price * intval($item['amount']);

                $invoiceItem->setVatAmount($vat); // Az x db termék áfája
                $invoiceItem->setNetPrice($net); // Az x db termék nettó ára
                $invoiceItem->setGrossAmount($gross); // Az x db termék bruttó ára
                $invoiceItem->setComment(trim($item['comment']) ?: '');

                $invoice->addItem($invoiceItem);
            }

            // Számla elkészítése
            $result = $agent->generateInvoice($invoice);

            if ($result->isSuccess()) {
                return $result->getDocumentNumber();
            } else {
                return null;
            }

        } catch (SzamlaAgentException $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}