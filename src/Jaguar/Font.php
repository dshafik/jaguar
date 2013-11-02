<?php

namespace Jaguar;

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Font implements EqualsInterface {

    private $font;
    private $size;
    private $color;

    /**
     * Creat new font object
     * 
     * @param string $font font path
     * @param integer $size font size
     * @param \Jaguar\Color $color font color
     * 
     * @throws \InvalidArgumentException
     */
    public function __construct($font, $size = 8, Color $color = null) {
        $this->setFont($font);
        $this->setSize($size);
        $this->setColor(null === $color ? new Color() : $color);
    }

    /**
     * Set font file
     * 
     * @param string $font font path
     * 
     * @return \Jaguar\Font
     * @throws \InvalidArgumentException
     */
    protected function setFont($font) {
        if (is_file($font) && is_readable($font)) {
            $this->font = (string) $font;
            return $this;
        }
        throw new \InvalidArgumentException(sprintf(
                'Font File "%s" Is Not Readable', $font
        ));
    }

    /**
     * Get the font file
     * 
     * @return string font's path
     */
    public function getFont() {
        return $this->font;
    }

    /**
     * Set font size
     * 
     * @param integer $size
     * @return \Jaguar\Font
     */
    public function setSize($size) {
        $this->size = (int) $size;
        return $this;
    }

    /**
     * Get font size
     * 
     * @return string
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Set font color
     * 
     * @param \Jaguar\Color $color
     * @return \Jaguar\Font
     */
    public function setColor(Color $color) {
        $this->color = $color;
        return $this;
    }

    /**
     * Get font color
     * 
     * @return \Jaguar\Color
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other) {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Font Object');
        }

        if ($this->getFont() !== $other->getFont()) {
            return false;
        }

        if ($this->getSize() !== $other->getSize()) {
            return false;
        }

        if (!$this->getColor()->equals($other->getColor())) {
            return false;
        }

        return true;
    }

    /**
     * Get string representation for the current font object
     * 
     * @return string
     */
    public function __toString() {
        return $this->getFont();
    }

    /**
     * Clone the font
     */
    public function __clone() {
        $this->color = clone $this->color;
    }

}

