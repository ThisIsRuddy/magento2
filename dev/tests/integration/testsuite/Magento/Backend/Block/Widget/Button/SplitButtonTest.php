<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\Backend\Block\Widget\Button;

use Magento\Framework\View\LayoutInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

/**
 * Testing SplitButton widget
 *
 * @magentoAppArea adminhtml
 */
class SplitButtonTest extends TestCase
{

    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->layout = $objectManager->get(LayoutInterface::class);
    }

    /**
     * Create the block.
     *
     * @return SplitButton
     */
    private function createBlock(): SplitButton
    {
        /** @var SplitButton $block */
        $block = $this->layout->createBlock(SplitButton::class, 'button_block');
        $block->setLayout($this->layout);

        return $block;
    }

    /**
     * Test resulting button HTML.
     *
     * @return void
     */
    public function testToHtml(): void
    {
        $block = $this->createBlock();
        $block->addData(
            [
                'title' => 'A button',
                'label' => 'A button',
                'has_split' => true,
                'button_class' => 'aclass',
                'id' => 'split-button',
                'disabled' => false,
                'class' => 'aclass',
                'data_attribute' => ['bind' => ['var' => 'val']],
                'options' => [
                    [
                        'disabled' => false,
                        'title' => 'An option',
                        'label' => 'An option',
                        'onclick' => $onclick = 'console.log("option")',
                        'style' => 'width: 100px'
                    ]
                ]
            ]
        );

        $html = $block->toHtml();
        $this->assertContains('<button ', $html);
        $this->assertContains('<span>A button</span>', $html);
        $this->assertNotContains('onclick=', $html);
        $this->assertNotContains('style=', $html);
        $this->assertRegExp('/\<script.*?\>.*?' . preg_quote($onclick) . '.*?\<\/script\>/ims', $html);
        $this->assertContains('width', $html);
        $this->assertContains('100px', $html);
    }
}
