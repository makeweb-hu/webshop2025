<?php

// File generated from our OpenAPI spec

namespace app\components\Stripe;

/**
 * Client used to send requests to Stripe's API.
 *
 * @property \app\components\Stripe\Service\AccountLinkService $accountLinks
 * @property \app\components\Stripe\Service\AccountService $accounts
 * @property \app\components\Stripe\Service\ApplePayDomainService $applePayDomains
 * @property \app\components\Stripe\Service\ApplicationFeeService $applicationFees
 * @property \app\components\Stripe\Service\BalanceService $balance
 * @property \app\components\Stripe\Service\BalanceTransactionService $balanceTransactions
 * @property \app\components\Stripe\Service\BillingPortal\BillingPortalServiceFactory $billingPortal
 * @property \app\components\Stripe\Service\ChargeService $charges
 * @property \app\components\Stripe\Service\Checkout\CheckoutServiceFactory $checkout
 * @property \app\components\Stripe\Service\CountrySpecService $countrySpecs
 * @property \app\components\Stripe\Service\CouponService $coupons
 * @property \app\components\Stripe\Service\CreditNoteService $creditNotes
 * @property \app\components\Stripe\Service\CustomerService $customers
 * @property \app\components\Stripe\Service\DisputeService $disputes
 * @property \app\components\Stripe\Service\EphemeralKeyService $ephemeralKeys
 * @property \app\components\Stripe\Service\EventService $events
 * @property \app\components\Stripe\Service\ExchangeRateService $exchangeRates
 * @property \app\components\Stripe\Service\FileLinkService $fileLinks
 * @property \app\components\Stripe\Service\FileService $files
 * @property \app\components\Stripe\Service\Identity\IdentityServiceFactory $identity
 * @property \app\components\Stripe\Service\InvoiceItemService $invoiceItems
 * @property \app\components\Stripe\Service\InvoiceService $invoices
 * @property \app\components\Stripe\Service\Issuing\IssuingServiceFactory $issuing
 * @property \app\components\Stripe\Service\MandateService $mandates
 * @property \app\components\Stripe\Service\OAuthService $oauth
 * @property \app\components\Stripe\Service\OrderReturnService $orderReturns
 * @property \app\components\Stripe\Service\OrderService $orders
 * @property \app\components\Stripe\Service\PaymentIntentService $paymentIntents
 * @property \app\components\Stripe\Service\PaymentLinkService $paymentLinks
 * @property \app\components\Stripe\Service\PaymentMethodService $paymentMethods
 * @property \app\components\Stripe\Service\PayoutService $payouts
 * @property \app\components\Stripe\Service\PlanService $plans
 * @property \app\components\Stripe\Service\PriceService $prices
 * @property \app\components\Stripe\Service\ProductService $products
 * @property \app\components\Stripe\Service\PromotionCodeService $promotionCodes
 * @property \app\components\Stripe\Service\QuoteService $quotes
 * @property \app\components\Stripe\Service\Radar\RadarServiceFactory $radar
 * @property \app\components\Stripe\Service\RefundService $refunds
 * @property \app\components\Stripe\Service\Reporting\ReportingServiceFactory $reporting
 * @property \app\components\Stripe\Service\ReviewService $reviews
 * @property \app\components\Stripe\Service\SetupAttemptService $setupAttempts
 * @property \app\components\Stripe\Service\SetupIntentService $setupIntents
 * @property \app\components\Stripe\Service\ShippingRateService $shippingRates
 * @property \app\components\Stripe\Service\Sigma\SigmaServiceFactory $sigma
 * @property \app\components\Stripe\Service\SkuService $skus
 * @property \app\components\Stripe\Service\SourceService $sources
 * @property \app\components\Stripe\Service\SubscriptionItemService $subscriptionItems
 * @property \app\components\Stripe\Service\SubscriptionScheduleService $subscriptionSchedules
 * @property \app\components\Stripe\Service\SubscriptionService $subscriptions
 * @property \app\components\Stripe\Service\TaxCodeService $taxCodes
 * @property \app\components\Stripe\Service\TaxRateService $taxRates
 * @property \app\components\Stripe\Service\Terminal\TerminalServiceFactory $terminal
 * @property \app\components\Stripe\Service\TestHelpers\TestHelpersServiceFactory $testHelpers
 * @property \app\components\Stripe\Service\TokenService $tokens
 * @property \app\components\Stripe\Service\TopupService $topups
 * @property \app\components\Stripe\Service\TransferService $transfers
 * @property \app\components\Stripe\Service\WebhookEndpointService $webhookEndpoints
 */
class StripeClient extends BaseStripeClient
{
    /**
     * @var \app\components\Stripe\Service\CoreServiceFactory
     */
    private $coreServiceFactory;

    public function __get($name)
    {
        if (null === $this->coreServiceFactory) {
            $this->coreServiceFactory = new \app\components\Stripe\Service\CoreServiceFactory($this);
        }

        return $this->coreServiceFactory->__get($name);
    }
}
