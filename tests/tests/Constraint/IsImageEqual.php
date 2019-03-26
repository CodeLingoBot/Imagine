<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Imagine\Test\Constraint;

use Imagine\Image\Histogram\Bucket;
use Imagine\Image\Histogram\Range;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Palette\PaletteInterface;
use Imagine\Image\Palette\RGB;
use PHPUnit\Util\InvalidArgumentHelper;

class IsImageEqual extends Constraint
{
    /**
     * @var \Imagine\Image\ImagineInterface|null
     */
    private $imagine;

    /**
     * @var \Imagine\Image\ImageInterface
     */
    private $value;

    /**
     * @var float
     */
    private $delta;

    /**
     * @var int
     */
    private $buckets;

    /**
     * @param \Imagine\Image\ImageInterface|string $value
     * @param float $delta
     * @param \Imagine\Image\ImagineInterface|null $imagine
     * @param int $buckets
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value, $delta = 0.1, ImagineInterface $imagine = null, $buckets = 4)
    {
        parent::__construct();
        $this->imagine = $imagine;
        if ($this->imagine !== null && is_string($value)) {
            $value = $this->imagine->open($value);
        }
        if (!$value instanceof ImageInterface) {
            throw InvalidArgumentHelper::factory(1, 'Imagine\Image\ImageInterface');
        }

        if (!is_numeric($delta)) {
            throw InvalidArgumentHelper::factory(2, 'numeric');
        }

        if (!is_int($buckets) || $buckets <= 0) {
            throw InvalidArgumentHelper::factory(4, 'integer');
        }

        $this->value = $value;
        $this->delta = $delta;
        $this->buckets = $buckets;
    }

    /**
     * {@inheritdoc}
     */
    protected function _matches($other)
    {
        if ($this->imagine !== null && is_string($other)) {
            $other = $this->imagine->open($other);
        }
        if (!$other instanceof ImageInterface) {
            throw InvalidArgumentHelper::factory(1, 'Imagine\Image\ImageInterface');
        }

        $total = $this->getDelta($other);

        return $total <= $this->delta;
    }

    /**
     * {@inheritdoc}
     */
    protected function _toString()
    {
        return sprintf('contains color histogram identical to expected %s', $this->exporter->export($this->value));
    }

    /**
     * {@inheritdoc}
     */
    protected function _failureDescription($other)
    {
        if ($this->imagine !== null && is_string($other)) {
            $other = $this->imagine->open($other);
        }

        return sprintf('contains color histogram identical to the expected one (max delta: %s, actual delta: %s)', $this->delta, $this->getDelta($other));
    }

    /**
     * @param \Imagine\Image\ImageInterface $image
     *
     * @return array
     */
    

    
}
