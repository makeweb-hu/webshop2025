<?php

namespace app\components\SzamlazzHU\header;

/**
 * Szállítólevél fejléc
 *
 * @package SzamlaAgent\Header
 */
class DeliveryNoteHeader extends InvoiceHeader {

    /**
     * @throws \SzamlaAgent\SzamlaAgentException
     */
    function __construct() {
        parent::__construct();
        $this->setDeliveryNote(true);
        $this->setPaid(false);
    }
}