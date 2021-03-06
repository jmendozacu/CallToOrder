<?php
/**
 * @copyright Copyright (c) 2016 www.magebuzz.com
 */

namespace Magenest\CallToOrder\Block\Adminhtml\Template;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * Edit constructor.
     * 
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize staff grid edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Magenest_CallToOrder';
        $this->_controller = 'adminhtml_template';

        parent::_construct();

        if ($this->_isAllowedAction('Magenest_CallToOrder::save')) {
            $this->buttonList->update('save', 'label', __('Save Staff'));
//            $this->buttonList->add(
//                'saveandcontinue',
//                [
//                    'label' => __('Save and Continue Edit'),
//                    'class' => 'save',
//                    'data_attribute' => [
//                        'mage-init' => [
//                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
//                        ],
//                    ]
//                ],
//                -100
//            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('Magenest_CallToOrder::grid_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Staff'));
        } else {
            $this->buttonList->remove('delete');
        }

        if ($this->_coreRegistry->registry('template')->getId()) {
            $this->buttonList->remove('reset');
        }
    }

    /**
     * Retrieve text for header element depending on loaded blocklist
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('id')->getId()) {
            return __("Edit Template Call Back '%1'", $this->escapeHtml($this->_coreRegistry->registry('template')->getTitle()));
        } else {
            return __('New Template');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('calltoorder/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }
}