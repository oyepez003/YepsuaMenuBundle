<?php

/*
 * This file is part of the YepsuaMenuBundle.
 *
 * (c) Omar Yepez <omar.yepez@yepsua.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yepsua\MenuBundle\Menu\Manager;



/**
 *
 * @author oyepez
 */
interface MenuManagerInterface {
    
    public function getItem($name, array $options = array());
    
}
