<?php

namespace Intervention\Image\Interfaces;

interface DrawableInterface
{
    /**
     * Position of the drawable object
     *
     * @return PointInterface
     */
    public function position(): PointInterface;

    /**
     * Set the background color of the drawable object
     *
     * @param  mixed $color
     * @return DrawableInterface
     */
    public function setBackgroundColor(mixed $color): DrawableInterface;

    /**
     * Return background color of drawable object
     *
     * @return mixed
     */
    public function backgroundColor(): mixed;

    /**
     * Determine if a background color was set
     *
     * @return bool
     */
    public function hasBackgroundColor(): bool;

    /**
     * Set border color & size of the drawable object
     *
     * @param mixed $color
     * @param int $size
     * @return DrawableInterface
     */
    public function setBorder(mixed $color, int $size = 1): DrawableInterface;

    /**
     * Set border size of the drawable object
     *
     * @param int $size
     * @return DrawableInterface
     */
    public function setBorderSize(int $size): DrawableInterface;

    /**
     * Set border color of the drawable object
     *
     * @param mixed $color
     * @return DrawableInterface
     */
    public function setBorderColor(mixed $color): DrawableInterface;

    /**
     * Get border size
     *
     * @return int
     */
    public function borderSize(): int;

    /**
     * Get border color of drawable object
     *
     * @return mixed
     */
    public function borderColor(): mixed;

    /**
     * Determine if the drawable object has a border
     *
     * @return bool
     */
    public function hasBorder(): bool;
}
