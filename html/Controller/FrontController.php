<?php

namespace Html\Controller;

use Exception;
use Html\Model\PostManager;

class FrontController extends BaseController
{



    /**
     * @throws Exception
     */
    public function executeIndex(int $number = 5)
    {
        $manager = new PostManager();
        $index = $manager->getPosts($number);

        return $this->render('Page de posts', $index, 'posts');
    }

    /**
     * @throws Exception
     */
    public function executeShow()
    {
        $manager = new PostManager();
        $post = $manager->getPostById($this->params['id']);

        return $this->render($post->getTitle(), [$post], 'posts');
    }
}