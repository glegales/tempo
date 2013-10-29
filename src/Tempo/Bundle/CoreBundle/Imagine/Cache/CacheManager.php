<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Tempo\Bundle\CoreBundle\Imagine\Cache;

use Imagine\Image\ImagineInterface;
use Imagine\Filter\Basic\Resize;
use Imagine\Image\Box;

use Symfony\Component\Filesystem\Filesystem;

class CacheManager
{

    /**
     * @var string
     */
    private $cachePath;
    /**
     * @var
     */
    private $driver;

    /**
     * @param ImagineInterface $driver
     */
    public function __construct(ImagineInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param $cachePath
     */
    public function setBasePath($cachePath)
    {
        if (!is_dir($cachePathTemp = $cachePath. 'media/cache')) {
            $filesystem = new Filesystem();
            $filesystem->mkdir($cachePathTemp);
        }
        $this->cachePath = $cachePath;
    }

    /**
     * @param $path
     * @param $sizes
     * @return mixed
     */
    public function getBrowserPath($path,$sizes)
    {
        if(!is_array($sizes)) {
            $sizes = array($sizes, $sizes);
        }

        $path =  $this->getResolver($path);
        $newImage = $this->cachePath.'media/cache/'.md5(pathinfo($path, PATHINFO_BASENAME)).'.'.pathinfo($path, PATHINFO_EXTENSION);

        if(!is_file($newImage)) {
           $this->generateImage($path,$newImage, $sizes);
        }

        $imagePath = explode('web', $newImage);
        return $imagePath[1];
    }

    /**
     * @param $path
     * @return string
     */
    protected function getResolver($path)
    {
        $path = ltrim($path, '/');

        if (substr($path, 0, 7) == 'bundles') {
            $path = $this->cachePath .'../'.$path;
        }

        return $path;
    }

    /**
     * Generate Thumbnail
     * @param $imageOriginal
     * @param $newImage
     * @param $sizes
     */
    protected function generateImage($imageOriginal, $newImage, $sizes)
    {
        $filter = new Resize(new Box($sizes[0], $sizes[1]));
        $filter
            ->apply($this->driver->open($imageOriginal))
            ->save($newImage, array('quality' => 70));
    }
}