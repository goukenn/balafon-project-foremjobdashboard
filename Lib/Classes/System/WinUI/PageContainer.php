<?php
// @author: C.A.D. BONDJE DOUE
// @file: PageContainer.php
// @date: 20260908 15:18:43
namespace com\igkdev\projects\ForemJobDashboard\System\WinUI;

use IGK\System\Html\Dom\HtmlItemBase;
use IGK\System\Html\Dom\HtmlNode;

/**
* 
* @package com\igkdev\projects\ForemJobDashboard\System\WinUI
* @author C.A.D. BONDJE DOUE
*/
class PageContainer extends HtmlNode
{
    /**
     * 
     * @var HtmlItemBase
     */
    private $container;
    public function __construct()
    {
        parent::__construct();
        $this->container = igk_create_node('container');
        parent::_add($this->container);
    }
    public function _add($n, bool $force = false): bool
    {
        return $this->container->_add(...func_get_args());
    }
    // public function __invoke($p)
    // {
    //     $p->add($this);
    // }
}