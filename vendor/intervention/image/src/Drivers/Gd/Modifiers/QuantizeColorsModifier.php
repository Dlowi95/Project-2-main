<?php

namespace Intervention\Image\Drivers\Gd\Modifiers;

use Intervention\Image\Drivers\Gd\SpecializedModifier;
use Intervention\Image\Exceptions\InputException;
use Intervention\Image\Interfaces\ImageInterface;

/**
 * @property int $limit
 * @property mixed $background
 */
class QuantizeColorsModifier extends SpecializedModifier
{
    public function apply(ImageInterface $image): ImageInterface
    {
        if ($this->limit <= 0) {
            throw new InputException('Quantization limit must be greater than 0.');
        }

        // no color reduction if the limit is higher than the colors in the img
        $colorCount = imagecolorstotal($image->core()->native());
        if ($colorCount > 0 && $this->limit > $colorCount) {
            return $image;
        }

        $width = $image->width();
        $height = $image->height();

        $background = $this->driver()->colorProcessor($image->colorspace())->colorToNative(
            $this->driver()->handleInput($this->background)
        );

        foreach ($image as $frame) {
            // create new image for color quantization
            $reduced = imagecreatetruecolor($width, $height);

            // retain resolution
            $this->copyResolution($frame->native(), $reduced);

            // fill with background
            imagefill($reduced, 0, 0, $background);

            // set transparency
            imagecolortransparent($reduced, $background);

            // copy original image (colors are limited automatically in the copy process)
            imagecopy($reduced, $frame->native(), 0, 0, 0, 0, $width, $height);

            // gd library does not support color quantization directly therefore the
            // colors are decrease by transforming the image to a palette version
            imagetruecolortopalette($reduced, true, $this->limit);

            $frame->setNative($reduced);
        }

        return $image;
    }
}
