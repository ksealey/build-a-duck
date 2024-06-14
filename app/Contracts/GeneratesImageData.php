<?php 
namespace App\Contracts;

interface GeneratesImageData
{
    /**
     * Get raw
     *
     * @param  $image
     * 
     * @return string
     */
    public function getImage($image): string;
}