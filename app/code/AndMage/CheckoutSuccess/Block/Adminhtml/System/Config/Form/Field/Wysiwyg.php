<?php

declare(strict_types=1);

namespace AndMage\CheckoutSuccess\Block\Adminhtml\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;

/**
 * Class Wysiwyg
 * @package AndMage\CheckoutSuccess\Block\Adminhtml\System\Config\Form\Field
 */
class Wysiwyg extends Field
{
    protected WysiwygConfig $wysiwygConfig;

    /**
     * @param Context $context
     * @param WysiwygConfig $wysiwygConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        WysiwygConfig $wysiwygConfig,
        array $data = []
    ) {
        $this->wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $config = $this->wysiwygConfig->getConfig();
        $element->setData('config', $config);
        $element->setData('wysiwyg', true);
        $element->setData('class', 'textarea');
        return parent::_getElementHtml($element);
    }
}
