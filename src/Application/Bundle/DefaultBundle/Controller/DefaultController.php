<?php

namespace Application\Bundle\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Default controller. For single actions for project
 *
 * @author Stepan Tanasiychuk <ceo@stfalcon.com>
 */
class DefaultController extends Controller
{

    /**
     * Categories/projects lilowerst
     *
     * @return array()
     * @Cache(expires="tomorrow")
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $categories = $this->get('doctrine')->getEntityManager()
                ->getRepository("StfalconPortfolioBundle:Category")->getAllCategories();

        //\Zend\Feed\Reader\Reader::setCache($this->get('knp_zend_cache.manager')->getCache('slow_cache'));

        try {
            $feed = \Zend\Feed\Reader\Reader::import('http://www.google.com/reader/public/atom/user%2F14849984795491019190%2Fstate%2Fcom.google%2Fbroadcast');
        } catch (\Zend\Http\Client\Adapter\Exception\RuntimeException $e) {
            $feed = array();
        }

        return array('categories' => $categories, 'feed' => $feed);
    }

    /**
     * Show last twitter messages
     *
     * @param int $count count of twitter messages
     *
     * @return array()
     * @Template()
     */
    public function twitterAction($count = 1)
    {
        try {
            $twitter = new \Zend\Service\Twitter\Search();
            $response = $twitter->execute('from:stfalcon', array('rpp' => $count));
        } catch (\Zend\Http\Client\Adapter\Exception\RuntimeException $e) {
            $response['results'][] = array(
                'text' => 'Unable to Connect to tcp://api.twitter.com:80',
                'created_at' => (string) \time()
            );
        }

        return array('results' => $response['results']);
    }

    /**
     * Contacts page
     *
     * @return array()
     * @Template()
     * @Route("/contacts", name="contacts")
     */
    public function contactsAction()
    {
        // @todo: refact
        if ($this->has('application_default.menu.breadcrumbs')) {
            $breadcrumbs = $this->get('application_default.menu.breadcrumbs');
            $breadcrumbs->addChild('Контакты')->setCurrent(true);
        }

        return array();
    }

}