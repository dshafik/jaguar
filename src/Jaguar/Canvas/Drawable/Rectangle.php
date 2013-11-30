<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Canvas\Drawable;

use Jaguar\Exception\Canvas\Drawable\DrawableException;
use Jaguar\Canvas\CanvasInterface;
use Jaguar\Color\ColorInterface;
use Jaguar\Dimension;
use Jaguar\Coordinate;

class Rectangle extends FilledDrawable
{
    private $dimension;
    private $coordinate;

    /**
     * Constrcut new rectangle
     * 
     * @param \Jaguar\Dimension $size
     * @param \Jaguar\Coordinate $start
     * @param \Jaguar\Canvas\Drawable\ColorInterface $color
     */
    public function __construct(Dimension $size = null, Coordinate $start = null, ColorInterface $color = null)
    {
        parent::__construct($color);
        $this->setStart($start === null ? new Coordinate() : $start);
        $this->setDimension($size === null ? new Dimension() : $size);
    }

    /**
     * Set dimension
     * 
     * @param \Jaguar\Dimension $dimension
     * 
     * @return \Jaguar\Canvas\Drawable\Rectangle
     */
    public function setDimension(Dimension $dimension)
    {
        $this->dimension = $dimension;
        return $this;
    }

    /**
     * Get dimension
     * 
     * @return \Jaguar\Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set Start Coordinate 
     * 
     * @param \Jaguar\Coordinate $coordinate
     * 
     * @return \Jaguar\Canvas\Drawable\Rectangle 
     */
    public function setStart(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;
        return $this;
    }

    /**
     * Get Start Coordinate
     * 
     * @return \Jaguar\Coordinate
     */
    public function getStart()
    {
        return $this->coordinate;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {

        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Rectangle Object');
        }

        if (!parent::equals($other)) {
            return false;
        }

        if (!$this->getDimension()->equals($other->getDimension())) {
            return false;
        }

        if (!$this->getStart()->equals($other->getStart())) {
            return false;
        }

        return true;
    }

    /**
     * Returns a string representation for the current rectangle object
     * 
     * @return string
     */
    public function __toString()
    {
        return get_called_class()
                . "["
                . "dimension={$this->getDimension()},"
                . "StartCoordinate={$this->getStart()}"
                . "]";
    }

    /**
     * Clone Rectangle
     */
    public function __clone()
    {
        parent::__clone();
        $this->coordinate = clone $this->coordinate;
        $this->dimension = clone $this->dimension;
    }

    /**
     * {@inheritdoc}
     */
    protected function drawFilled(CanvasInterface $canvas, StyleInterface $style = null)
    {
        $this->drawRectangle($canvas, $style, true);
    }

    /**
     * {@inheritdoc}
     */
    protected function drawNonFilled(CanvasInterface $canvas, StyleInterface $style = null)
    {
        $this->drawRectangle($canvas, $style, false);
    }

    /**
     * Draw rectangle
     * 
     * @param \Jaguar\Canvas\CanvasInterface $canvas
     * @param \Jaguar\Canvas\Drawable\StyleInterface $style
     * @param boolean $filled
     * 
     * @throws \Jaguar\Exception\Canvas\Drawable\DrawableException
     */
    private function drawRectangle(
    CanvasInterface $canvas, StyleInterface $style = null, $filled = false)
    {

        $x = $this->getStart()->getX();
        $y = $this->getStart()->getY();
        $color = (!is_null($style)) ?
                $style->apply($canvas, $this)->getValue() :
                $this->getColor()->getValue();

        $result = false;

        if (true === $filled) {
            $result = @imagefilledrectangle(
                            $canvas->getHandler()
                            , $x
                            , $y
                            , $this->getDimension()->getWidth() + $x
                            , $this->getDimension()->getHeight() + $y
                            , $color
            );
        } else {
            $result = @imagerectangle(
                            $canvas->getHandler()
                            , $x
                            , $y
                            , $this->getDimension()->getWidth() + $x
                            , $this->getDimension()->getHeight() + $y
                            , $color
            );
        }


        if (false == $result) {
            throw new DrawableException(sprintf(
                    'Faild To Draw The Rectangle "%s"', (string) $this
            ));
        }
    }

}
