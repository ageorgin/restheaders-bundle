<?php
/**
 * Created by PhpStorm.
 * User: ageorgin
 * Date: 21/10/14
 * Time: 14:49
 */

namespace Ageorgin\RestHeadersBundle\Helper;


use Ageorgin\RestHeadersBundle\Exception\RestHeadersException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class Pagination
{
    /**
     * @var Router
     */
    private $router = null;

    /**
     * @var array
     */
    private $paginationData = null;

    /**
     * @var array
     */
    private $authorizedLinks = ['next', 'last', 'first', 'previous'];

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getHeaders()
    {
        return array(
            'X-Total-Count' => $this->getTotalCount(),
            'Link' => $this->getLink()
        );
    }

    protected function getLink()
    {
        if (null === $this->paginationData) {
            throw new RestHeadersException('paginationData must not be null');
        }

        $linksHeader = '';
        foreach ($this->authorizedLinks as $rel) {
            if (array_key_exists($rel, $this->paginationData['data'])) {

                $routeParams = $this->paginationData['routeParams'];
                $routeParams['page'] = $this->paginationData['data'][$rel];
                $linksHeader .= '<' . $this->router->generate($this->paginationData['route'],
                        $routeParams,
                        UrlGeneratorInterface::ABSOLUTE_URL) . '>; rel="' . ('previous' === $rel ? 'prev' : $rel)  . '",';
            }
        }

        return $linksHeader;
    }

    protected function getTotalCount()
    {
        if (null === $this->paginationData) {
            throw new RestHeadersException('paginationData must not be null');
        }

        return $this->paginationData['data']['totalCount'];
    }

    /**
     * @param array $paginationData
     */
    public function setPaginationData($paginationData)
    {
        $this->paginationData = $paginationData;
    }

    /**
     * @return array
     */
    public function getPaginationData()
    {
        return $this->paginationData;
    }
} 