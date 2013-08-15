<?php

namespace Nantarena\SiteBundle\Navigation;

class Breadcrumb
{
    /**
     * @var \SplQueue
     */
    private $queue;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->queue = new \SplQueue();
    }

    /**
     * Ajoute une paire nom et path dans la queue
     *
     * @param $name
     * @param $path
     */
    public function push($name, $path)
    {
       $this->queue->push(array(
           'name' => $name,
           'path' => $path
       ));
    }

    public function getQueue()
    {
        return $this->queue;
    }
}
