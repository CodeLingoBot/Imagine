<?php

namespace Imagine\Test\Issues;

use Imagine\Exception\RuntimeException;
use Imagine\Gmagick\Imagine as GmagickImagine;
use Imagine\Imagick\Imagine as ImagickImagine;
use Imagine\Test\ImagineTestCase;

class Issue131Test extends ImagineTestCase
{
    

    

    

    

    /**
     * @doesNotPerformAssertions
     * @group imagick
     */
    public function testShouldSaveOneFileWithImagick()
    {
        $dir = realpath($this->getTemporaryDir());
        $targetFile = $dir . '/myfile.png';

        $imagine = $this->getImagickImagine(__DIR__ . '/multi-layer.psd');

        $imagine->save($targetFile);

        if (!$this->probeOneFileAndCleanup($dir, $targetFile)) {
            $this->fail('Imagick failed to generate one file');
        }
    }

    /**
     * @group gmagick
     */
    public function testShouldSaveOneFileWithGmagick()
    {
        $dir = realpath($this->getTemporaryDir());
        $targetFile = $dir . '/myfile.png';

        $imagine = $this->getGmagickImagine(__DIR__ . '/multi-layer.psd');

        $imagine->save($targetFile);

        $this->assertTrue($this->probeOneFileAndCleanup($dir, $targetFile), 'Gmagick failed to generate one file');
    }

    
}
