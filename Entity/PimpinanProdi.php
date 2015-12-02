<?php

namespace Ais\PimpinanProdiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ais\PimpinanProdiBundle\Model\PimpinanProdiInterface;

/**
 * PimpinanProdi
 */
class PimpinanProdi implements PimpinanProdiInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $user_id;

    /**
     * @var integer
     */
    private $prodi_id;

    /**
     * @var string
     */
    private $posisi;

    /**
     * @var boolean
     */
    private $is_active;

    /**
     * @var boolean
     */
    private $is_delete;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return PimpinanProdi
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set prodiId
     *
     * @param integer $prodiId
     *
     * @return PimpinanProdi
     */
    public function setProdiId($prodiId)
    {
        $this->prodi_id = $prodiId;

        return $this;
    }

    /**
     * Get prodiId
     *
     * @return integer
     */
    public function getProdiId()
    {
        return $this->prodi_id;
    }

    /**
     * Set posisi
     *
     * @param string $posisi
     *
     * @return PimpinanProdi
     */
    public function setPosisi($posisi)
    {
        $this->posisi = $posisi;

        return $this;
    }

    /**
     * Get posisi
     *
     * @return string
     */
    public function getPosisi()
    {
        return $this->posisi;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return PimpinanProdi
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return PimpinanProdi
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->is_delete;
    }
}

