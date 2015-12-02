<?php

namespace Ais\PimpinanProdiBundle\Tests\Fixtures\Entity;

use Ais\PimpinanProdiBundle\Entity\PimpinanProdi;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadPimpinanProdiData implements FixtureInterface
{
    static public $pimpinan_prodis = array();

    public function load(ObjectManager $manager)
    {
        $pimpinan_prodi = new PimpinanProdi();
        $pimpinan_prodi->setTitle('title');
        $pimpinan_prodi->setBody('body');

        $manager->persist($pimpinan_prodi);
        $manager->flush();

        self::$pimpinan_prodis[] = $pimpinan_prodi;
    }
}
