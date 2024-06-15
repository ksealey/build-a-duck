<?php 

namespace App\Strategies\GenerateImage;

use App\Strategies\GeneratesImageData;
use App\Models\Duck;
use Imagick;

class GeneratePNG extends GeneratesImageData
{
     /**
     * Create and return a png image resource from a Duck
     *
     * @param \App\Models\Duck $duck
     * @param int $width
     * @param int height 
     *  
     * @return resource
     */
    public function createImage(Duck $duck)
    {
        $layeredImage = $this->getLayeredImage($duck);

        $layeredImage->setImageFormat('png');
        $layeredImage->setImageAlphaChannel(Imagick::ALPHACHANNEL_SET); // Enable alpha channel
        $layeredImage->setImageCompressionQuality(100);

        return $layeredImage->getImageBlob();
    }
}