<?php

declare(strict_types=1);

namespace AndMage\CheckoutSuccess\Block;

use Magento\Sales\Model\Order\Address;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Address\Config as AddressConfig;
use magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Success
 * @package AndMage\CheckoutSuccess\Block
 */
class Success extends Template
{
    public const XML_PATH_CHECKOUT_MESSAGE = 'checkout/success_info/success_message';
    public const XML_PATH_CHECKOUT_LOGIC_ENABLED = 'checkout/success_info/enabled';
    protected OrderRepositoryInterface $orderRepository;
    protected AddressConfig $addressConfig;
    protected CheckoutSession $checkoutSession;
    protected ScopeConfigInterface $scopeConfig;

    /**
     * @param Context $context
     * @param OrderRepositoryInterface $orderRepository
     * @param CheckoutSession $checkoutSession
     * @param AddressConfig $addressConfig
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Template\Context         $context,
        OrderRepositoryInterface $orderRepository,
        CheckoutSession          $checkoutSession,
        AddressConfig            $addressConfig,
        ScopeConfigInterface     $scopeConfig,
        array                    $data = []
    ) {
        $this->orderRepository = $orderRepository;
        $this->checkoutSession = $checkoutSession;
        $this->addressConfig = $addressConfig;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }


    /**
     * @return string
     */
    public function toHtml(): string
    {
        if ($this->isEnabled()) {
            $this->_template = 'AndMage_CheckoutSuccess::success.phtml';
            return parent::toHtml();
        }
        return '';
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_CHECKOUT_LOGIC_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getSuccessMessage(): string
    {
        return $this->scopeConfig->getValue(
            static::XML_PATH_CHECKOUT_MESSAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface
    {
        $orderId = $this->checkoutSession->getLastRealOrder()->getId();
        return $this->orderRepository->get($orderId);
    }

    /**
     * @param Address $address
     * @return string
     */
    public function formatAddress(Address $address): string
    {
        return $this->addressConfig->getFormatByCode('html')->getRenderer()->renderArray($address->getData());
    }

    /**
     * @param float|String $price
     * @return string
     */
    public function formatPrice(float|String $price): string
    {
        return $this->getOrder()->formatPrice($price);
    }
}
