<?php

namespace Intervention\Image\Modifiers;

use Intervention\Image\Geometry\Rectangle;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\SizeInterface;

class CoverModifier extends AbstractModifier
{
    public function __construct(
        public int $width,
        public int $height,
        public string $position = 'center'
    ) {
    }

    public function getCropSize(ImageInterface $image): SizeInterface
    {
        $imagesize = $image->size();

        $crop = new Rectangle($this->width, $this->height);
        $crop = $crop->contain(
            $imagesize->width(),
            $imagesize->height()
        )->alignPivotTo($imagesize, $this->position);

        return $crop;
    }

    public function getResizeSize(SizeInterface $size): SizeInterface
    {
        return $size->scale($this->width, $this->height);
    }
}
