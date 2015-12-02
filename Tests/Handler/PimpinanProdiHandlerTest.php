<?php

namespace Ais\PimpinanProdiBundle\Tests\Handler;

use Ais\PimpinanProdiBundle\Handler\PimpinanProdiHandler;
use Ais\PimpinanProdiBundle\Model\PimpinanProdiInterface;
use Ais\PimpinanProdiBundle\Entity\PimpinanProdi;

class PimpinanProdiHandlerTest extends \PHPUnit_Framework_TestCase
{
    const DOSEN_CLASS = 'Ais\PimpinanProdiBundle\Tests\Handler\DummyPimpinanProdi';

    /** @var PimpinanProdiHandler */
    protected $pimpinan_prodiHandler;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $om;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }
        
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');

        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($this->repository));
        $this->om->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($class));
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::DOSEN_CLASS));
    }


    public function testGet()
    {
        $id = 1;
        $pimpinan_prodi = $this->getPimpinanProdi();
        $this->repository->expects($this->once())->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue($pimpinan_prodi));

        $this->pimpinan_prodiHandler = $this->createPimpinanProdiHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $this->pimpinan_prodiHandler->get($id);
    }

    public function testAll()
    {
        $offset = 1;
        $limit = 2;

        $pimpinan_prodis = $this->getPimpinanProdis(2);
        $this->repository->expects($this->once())->method('findBy')
            ->with(array(), null, $limit, $offset)
            ->will($this->returnValue($pimpinan_prodis));

        $this->pimpinan_prodiHandler = $this->createPimpinanProdiHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $all = $this->pimpinan_prodiHandler->all($limit, $offset);

        $this->assertEquals($pimpinan_prodis, $all);
    }

    public function testPost()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $pimpinan_prodi = $this->getPimpinanProdi();
        $pimpinan_prodi->setTitle($title);
        $pimpinan_prodi->setBody($body);

        $form = $this->getMock('Ais\PimpinanProdiBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($pimpinan_prodi));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pimpinan_prodiHandler = $this->createPimpinanProdiHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $pimpinan_prodiObject = $this->pimpinan_prodiHandler->post($parameters);

        $this->assertEquals($pimpinan_prodiObject, $pimpinan_prodi);
    }

    /**
     * @expectedException Ais\PimpinanProdiBundle\Exception\InvalidFormException
     */
    public function testPostShouldRaiseException()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $pimpinan_prodi = $this->getPimpinanProdi();
        $pimpinan_prodi->setTitle($title);
        $pimpinan_prodi->setBody($body);

        $form = $this->getMock('Ais\PimpinanProdiBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pimpinan_prodiHandler = $this->createPimpinanProdiHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $this->pimpinan_prodiHandler->post($parameters);
    }

    public function testPut()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $pimpinan_prodi = $this->getPimpinanProdi();
        $pimpinan_prodi->setTitle($title);
        $pimpinan_prodi->setBody($body);

        $form = $this->getMock('Ais\PimpinanProdiBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($pimpinan_prodi));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pimpinan_prodiHandler = $this->createPimpinanProdiHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $pimpinan_prodiObject = $this->pimpinan_prodiHandler->put($pimpinan_prodi, $parameters);

        $this->assertEquals($pimpinan_prodiObject, $pimpinan_prodi);
    }

    public function testPatch()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('body' => $body);

        $pimpinan_prodi = $this->getPimpinanProdi();
        $pimpinan_prodi->setTitle($title);
        $pimpinan_prodi->setBody($body);

        $form = $this->getMock('Ais\PimpinanProdiBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($pimpinan_prodi));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pimpinan_prodiHandler = $this->createPimpinanProdiHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $pimpinan_prodiObject = $this->pimpinan_prodiHandler->patch($pimpinan_prodi, $parameters);

        $this->assertEquals($pimpinan_prodiObject, $pimpinan_prodi);
    }


    protected function createPimpinanProdiHandler($objectManager, $pimpinan_prodiClass, $formFactory)
    {
        return new PimpinanProdiHandler($objectManager, $pimpinan_prodiClass, $formFactory);
    }

    protected function getPimpinanProdi()
    {
        $pimpinan_prodiClass = static::DOSEN_CLASS;

        return new $pimpinan_prodiClass();
    }

    protected function getPimpinanProdis($maxPimpinanProdis = 5)
    {
        $pimpinan_prodis = array();
        for($i = 0; $i < $maxPimpinanProdis; $i++) {
            $pimpinan_prodis[] = $this->getPimpinanProdi();
        }

        return $pimpinan_prodis;
    }
}

class DummyPimpinanProdi extends PimpinanProdi
{
}
