<?php

namespace app\components\SzamlazzHU\header;

use \app\components\SzamlazzHU\document\invoice\Invoice;

/**
 * Helyesbítő számla fejléc
 *
 * @package SzamlaAgent\Header
 */
class CorrectiveInvoiceHeader extends InvoiceHeader {

    /**
     * @param int $type
     *
     * @throws \SzamlaAgent\SzamlaAgentException
     */
    function __construct($type = Invoice::INVOICE_TYPE_P_INVOICE) {
        parent::__construct($type);
        $this->setCorrective(true);
    }
}