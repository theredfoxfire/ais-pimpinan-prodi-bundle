<?php

namespace Ais\PimpinanProdiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Ais\PimpinanProdiBundle\Exception\InvalidFormException;
use Ais\PimpinanProdiBundle\Form\PimpinanProdiType;
use Ais\PimpinanProdiBundle\Model\PimpinanProdiInterface;


class PimpinanProdiController extends FOSRestController
{
    /**
     * List all pimpinan_prodis.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing pimpinan_prodis.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many pimpinan_prodis to return.")
     *
     * @Annotations\View(
     *  templateVar="pimpinan_prodis"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getPimpinanProdisAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('ais_pimpinan_prodi.pimpinan_prodi.handler')->all($limit, $offset);
    }

    /**
     * Get single PimpinanProdi.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a PimpinanProdi for a given id",
     *   output = "Ais\PimpinanProdiBundle\Entity\PimpinanProdi",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the pimpinan_prodi is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="pimpinan_prodi")
     *
     * @param int     $id      the pimpinan_prodi id
     *
     * @return array
     *
     * @throws NotFoundHttpException when pimpinan_prodi not exist
     */
    public function getPimpinanProdiAction($id)
    {
        $pimpinan_prodi = $this->getOr404($id);

        return $pimpinan_prodi;
    }

    /**
     * Presents the form to use to create a new pimpinan_prodi.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @return FormTypeInterface
     */
    public function newPimpinanProdiAction()
    {
        return $this->createForm(new PimpinanProdiType());
    }
    
    /**
     * Presents the form to use to edit pimpinan_prodi.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPimpinanProdiBundle:PimpinanProdi:editPimpinanProdi.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the pimpinan_prodi id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when pimpinan_prodi not exist
     */
    public function editPimpinanProdiAction($id)
    {
		$pimpinan_prodi = $this->getPimpinanProdiAction($id);
		
        return array('form' => $this->createForm(new PimpinanProdiType(), $pimpinan_prodi), 'pimpinan_prodi' => $pimpinan_prodi);
    }

    /**
     * Create a PimpinanProdi from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new pimpinan_prodi from the submitted data.",
     *   input = "Ais\PimpinanProdiBundle\Form\PimpinanProdiType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPimpinanProdiBundle:PimpinanProdi:newPimpinanProdi.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postPimpinanProdiAction(Request $request)
    {
        try {
            $newPimpinanProdi = $this->container->get('ais_pimpinan_prodi.pimpinan_prodi.handler')->post(
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $newPimpinanProdi->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pimpinan_prodi', $routeOptions, Codes::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing pimpinan_prodi from the submitted data or create a new pimpinan_prodi at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\PimpinanProdiBundle\Form\PimpinanProdiType",
     *   statusCodes = {
     *     201 = "Returned when the PimpinanProdi is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPimpinanProdiBundle:PimpinanProdi:editPimpinanProdi.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the pimpinan_prodi id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when pimpinan_prodi not exist
     */
    public function putPimpinanProdiAction(Request $request, $id)
    {
        try {
            if (!($pimpinan_prodi = $this->container->get('ais_pimpinan_prodi.pimpinan_prodi.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $pimpinan_prodi = $this->container->get('ais_pimpinan_prodi.pimpinan_prodi.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $pimpinan_prodi = $this->container->get('ais_pimpinan_prodi.pimpinan_prodi.handler')->put(
                    $pimpinan_prodi,
                    $request->request->all()
                );
            }

            $routeOptions = array(
                'id' => $pimpinan_prodi->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pimpinan_prodi', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing pimpinan_prodi from the submitted data or create a new pimpinan_prodi at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\PimpinanProdiBundle\Form\PimpinanProdiType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisPimpinanProdiBundle:PimpinanProdi:editPimpinanProdi.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the pimpinan_prodi id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when pimpinan_prodi not exist
     */
    public function patchPimpinanProdiAction(Request $request, $id)
    {
        try {
            $pimpinan_prodi = $this->container->get('ais_pimpinan_prodi.pimpinan_prodi.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $pimpinan_prodi->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pimpinan_prodi', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Fetch a PimpinanProdi or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return PimpinanProdiInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($pimpinan_prodi = $this->container->get('ais_pimpinan_prodi.pimpinan_prodi.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $pimpinan_prodi;
    }
    
    public function postUpdatePimpinanProdiAction(Request $request, $id)
    {
		try {
            $pimpinan_prodi = $this->container->get('ais_pimpinan_prodi.pimpinan_prodi.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $pimpinan_prodi->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_pimpinan_prodi', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
	}
}
