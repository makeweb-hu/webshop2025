<?php

namespace app\components\SzamlazzHU\header;

use \app\components\SzamlazzHU\document\invoice\Invoice;

/**
 * Végszámla fejléc
 *
 * @package SzamlaAgent\Header
 */
class FinalInvoiceHeader extends InvoiceHeader {

    /**
     * @param int $type
     *
     * @throws \SzamlaAgent\SzamlaAgentException
     */
    function __construct($type = Invoice::INVOICE_TYPE_P_INVOICE) {
        parent::__construct($type);
        $this->setFinal(true);
    }
}