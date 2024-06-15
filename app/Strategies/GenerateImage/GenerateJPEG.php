<?php 

namespace App\Strategies\GenerateImage;

use App\Strategies\GeneratesImageData;
use App\Models\Duck;

class GenerateJPEG extends GeneratesImageData
{
    /**
     * Create and return a jpeg image resource from a Duck
     *
     * @param \App\Models\Duck $duck
     *  
     * @return resource
     */
    public function createImage(Duck $duck)
    {
        $layeredImage = $this->getLayeredImage($duck);
        
        $layeredImage->setImageFormat('jpeg');
        $layeredImage->setImageCompressionQuality(100);

        return $layeredImage->getImageBlob();
    }
}