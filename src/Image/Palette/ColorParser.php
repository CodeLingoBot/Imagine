<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Imagine\Image\Palette;

use Imagine\Exception\InvalidArgumentException;

class ColorParser
{
    /**
     * Parses a color to a RGB tuple.
     *
     * @param string|array|int $color
     *
     * @throws \Imagine\Exception\InvalidArgumentException
     *
     * @return array
     */
    public function parseToRGB($color)
    {
        $color = $this->parse($color);

        if (4 === count($color)) {
            $color = array(
                255 * (1 - $color[0] / 100) * (1 - $color[3] / 100),
                255 * (1 - $color[1] / 100) * (1 - $color[3] / 100),
                255 * (1 - $color[2] / 100) * (1 - $color[3] / 100),
            );
        }

        return $color;
    }

    /**
     * Parses a color to a CMYK tuple.
     *
     * @param string|array|int $color
     *
     * @throws \Imagine\Exception\InvalidArgumentException
     *
     * @return array
     */
    public function parseToCMYK($color)
    {
        $color = $this->parse($color);

        if (3 === count($color)) {
            $r = $color[0] / 255;
            $g = $color[1] / 255;
            $b = $color[2] / 255;

            $k = 1 - max($r, $g, $b);

            $color = array(
                1 === $k ? 0 : round((1 - $r - $k) / (1 - $k) * 100),
                1 === $k ? 0 : round((1 - $g - $k) / (1 - $k) * 100),
                1 === $k ? 0 : round((1 - $b - $k) / (1 - $k) * 100),
                round($k * 100),
            );
        }

        return $color;
    }

    /**
     * Parses a color to a grayscale value.
     *
     * @param string|array|int $color
     *
     * @throws \Imagine\Exception\InvalidArgumentException
     *
     * @return int[]
     */
    public function parseToGrayscale($color)
    {
        if (is_array($color) && 1 === count($color)) {
            return array((int) round(array_pop($color)));
        }

        $color = array_unique($this->parse($color));

        if (1 !== count($color)) {
            throw new InvalidArgumentException('The provided color has different values of red, green and blue components. Grayscale colors must have the same values for these.');
        }

        return $color;
    }

    /**
     * Parses a color.
     *
     * @param string|array|int $color
     *
     * @throws \Imagine\Exception\InvalidArgumentException
     *
     * @return int[]
     */
    
}
