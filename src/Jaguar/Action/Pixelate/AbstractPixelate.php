<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Pixelate;

use Jaguar\Action\AbstractAction;

abstract class AbstractPixelate extends AbstractAction
{
    private $size;

    /**
     * Constrcut new pixelate filter
     * 
     * @param integer $size
     */
    public function __construct($size = 0)
    {
        $this->setBlockSize($size);
    }

    /**
     * Set the block size
     * 
     * @param integer $size
     * 
     * @return \Jaguar\Action\Pixelate\AbstractPixelate
     */
    public function setBlockSize($size)
    {
        $this->size = (int) abs($size);
        return $this;
    }

    /**
     * Get the block size
     * 
     * @return integer
     */
    public function getBlockSize()
    {
        return $this->size;
    }

}
