<?php 
namespace App\Strategies;

use App\Models\Duck;
use Imagick;
use ImagickPixel;

abstract class GeneratesImageData
{
    /**
     * Create and return image resource from a Duck
     *
     * @param \App\Models\Duck $duck
     *  
     * @return resource
     */
    abstract public function createImage(Duck $duck);

    /**
     * Get raw svg content using a key
     *
     * @param string $key
     *  
     * @return string
     */
    protected function getImageContent(string $key)
    {
        return file_get_contents(__DIR__ . '/../../images/' . $key . '.svg');
    }

    /**
     * Create and return a layered image
     *
     * @param \App\Models\Duck $duck
     *  
     * @return Imagick;
     */
    protected function getLayeredImage(Duck $duck)
    {
        //  Get the base image content and change the color
        $targetColor = 'rgb(225,211,184)';
        $baseImageLayer = str_replace($targetColor, $duck->color, $this->getImageContent('duck'));
        $additionalLayers = [];
        if($duck->hair){
            $additionalLayers[] = $this->getImageContent($duck->hair);
        }
        if($duck->accessory){
            $additionalLayers[] = $this->getImageContent($duck->accessory);
        }
        if($duck->shoes){
            $additionalLayers[] = $this->getImageContent($duck->shoes);
        }

        //  Now that we have all the layers, use imagick to combine them
        $baseImage = new Imagick();
        $baseImage->readImageBlob($baseImageLayer);
        $baseImage->setBackgroundColor(new ImagickPixel('transparent')); // Make background transparent
        foreach($additionalLayers as $layer){
            $additionalImage = new Imagick();
            $additionalImage->setBackgroundColor(new ImagickPixel('transparent')); // Make background transparent
            $additionalImage->readImageBlob($layer);

            $baseImage->compositeImage($additionalImage, Imagick::COMPOSITE_OVER, 0, 0); // Lay image over base image
        }

        return $baseImage;
    }
}