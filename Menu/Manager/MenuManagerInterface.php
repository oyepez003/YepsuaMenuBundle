<?php

namespace Yepsua\MenuBundle\Menu\Manager;

/*
 * This file is part of the YepsuaMenu Bundle.
 *
 * (c) Omar Yepez <omar.yepez@yepsua.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @author oyepez
 */
interface MenuManagerInterface {
    
    public function getItem($name, array $options = array());
    
}
