<?php

namespace Ais\PimpinanProdiBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Ais\PimpinanProdiBundle\Model\PimpinanProdiInterface;
use Ais\PimpinanProdiBundle\Form\PimpinanProdiType;
use Ais\PimpinanProdiBundle\Exception\InvalidFormException;

class PimpinanProdiHandler implements PimpinanProdiHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get a PimpinanProdi.
     *
     * @param mixed $id
     *
     * @return PimpinanProdiInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get a list of PimpinanProdis.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }

    /**
     * Create a new PimpinanProdi.
     *
     * @param array $parameters
     *
     * @return PimpinanProdiInterface
     */
    public function post(array $parameters)
    {
        $pimpinan_prodi = $this->createPimpinanProdi();

        return $this->processForm($pimpinan_prodi, $parameters, 'POST');
    }

    /**
     * Edit a PimpinanProdi.
     *
     * @param PimpinanProdiInterface $pimpinan_prodi
     * @param array         $parameters
     *
     * @return PimpinanProdiInterface
     */
    public function put(PimpinanProdiInterface $pimpinan_prodi, array $parameters)
    {
        return $this->processForm($pimpinan_prodi, $parameters, 'PUT');
    }

    /**
     * Partially update a PimpinanProdi.
     *
     * @param PimpinanProdiInterface $pimpinan_prodi
     * @param array         $parameters
     *
     * @return PimpinanProdiInterface
     */
    public function patch(PimpinanProdiInterface $pimpinan_prodi, array $parameters)
    {
        return $this->processForm($pimpinan_prodi, $parameters, 'PATCH');
    }

    /**
     * Processes the form.
     *
     * @param PimpinanProdiInterface $pimpinan_prodi
     * @param array         $parameters
     * @param String        $method
     *
     * @return PimpinanProdiInterface
     *
     * @throws \Ais\PimpinanProdiBundle\Exception\InvalidFormException
     */
    private function processForm(PimpinanProdiInterface $pimpinan_prodi, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new PimpinanProdiType(), $pimpinan_prodi, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {

            $pimpinan_prodi = $form->getData();
            $this->om->persist($pimpinan_prodi);
            $this->om->flush($pimpinan_prodi);

            return $pimpinan_prodi;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createPimpinanProdi()
    {
        return new $this->entityClass();
    }

}
