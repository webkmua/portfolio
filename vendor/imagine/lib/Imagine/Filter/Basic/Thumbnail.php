<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Imagine\Filter\Basic;

use Imagine\Color;
use Imagine\BoxInterface;
use Imagine\ImageInterface;
use Imagine\Filter\FilterInterface;

class Thumbnail implements FilterInterface
{
    /**
     * @var BoxInterface
     */
    private $size;

    /**
     * @var string
     */
    private $mode;

    /**
     * Constructs the Thumbnail filter with given width, height, mode and
     * background color
     *
     * @param BoxInterface $size
     * @param string        $mode
     */
    public function __construct(BoxInterface $size, $mode = ImageInterface::THUMBNAIL_INSET)
    {
        $this->size = $size;
        $this->mode = $mode;
    }

    /**
     * (non-PHPdoc)
     * @see Imagine\Filter\FilterInterface::apply()
     */
    public function apply(ImageInterface $image)
    {
        return $image->thumbnail($this->size, $this->mode);
    }
}