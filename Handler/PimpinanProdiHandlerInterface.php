<?php

namespace Ais\PimpinanProdiBundle\Handler;

use Ais\PimpinanProdiBundle\Model\PimpinanProdiInterface;

interface PimpinanProdiHandlerInterface
{
    /**
     * Get a PimpinanProdi given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return PimpinanProdiInterface
     */
    public function get($id);

    /**
     * Get a list of PimpinanProdis.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post PimpinanProdi, creates a new PimpinanProdi.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return PimpinanProdiInterface
     */
    public function post(array $parameters);

    /**
     * Edit a PimpinanProdi.
     *
     * @api
     *
     * @param PimpinanProdiInterface   $pimpinan_prodi
     * @param array           $parameters
     *
     * @return PimpinanProdiInterface
     */
    public function put(PimpinanProdiInterface $pimpinan_prodi, array $parameters);

    /**
     * Partially update a PimpinanProdi.
     *
     * @api
     *
     * @param PimpinanProdiInterface   $pimpinan_prodi
     * @param array           $parameters
     *
     * @return PimpinanProdiInterface
     */
    public function patch(PimpinanProdiInterface $pimpinan_prodi, array $parameters);
}
