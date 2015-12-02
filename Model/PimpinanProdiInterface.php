<?php

namespace Ais\PimpinanProdiBundle\Model;

Interface PimpinanProdiInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return PimpinanProdi
     */
    public function setUserId($userId);

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId();

    /**
     * Set prodiId
     *
     * @param integer $prodiId
     *
     * @return PimpinanProdi
     */
    public function setProdiId($prodiId);

    /**
     * Get prodiId
     *
     * @return integer
     */
    public function getProdiId();

    /**
     * Set posisi
     *
     * @param string $posisi
     *
     * @return PimpinanProdi
     */
    public function setPosisi($posisi);

    /**
     * Get posisi
     *
     * @return string
     */
    public function getPosisi();

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return PimpinanProdi
     */
    public function setIsActive($isActive);

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive();

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return PimpinanProdi
     */
    public function setIsDelete($isDelete);

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete();
}
