<?php

class IndexController extends Zend_Controller_Action {

    protected $_modelTerm;

    public function init() {
        /* Initialize action controller here */

        $this->_modelTerm = new Model_DbTable_Term();

        //category
        $terms = $this->_modelTerm->getTerms();
        //var_dump($terms);
        $this->view->terms = $terms;
        
        //post_tag
        $terms2 = $this->_modelTerm->getTerms2();
        //var_dump($terms);
        $this->view->terms2 = $terms2;
    }

    public function indexAction() {



        $model = new Model_DbTable_Post();

        $termid = 0;
        if (!empty($this->getRequest()->termid)) {
            $termid = $this->getRequest()->termid;
            $posts = $model->getPostsByTerm($termid);

            $category = $this->_modelTerm->getTermById($termid);
           $this->view->partheadtitle = $category->name. " | ";
        } else {
            $posts = $model->getPosts();
             $this->view->partheadtitle = " ";
        }

        // echo "termid:". $termid ."<br>"; //die;
        // var_dump($posts->getRow(0)->ID); //die;



        $page = $this->_getParam('page', 1);
        $paginator = Zend_Paginator::factory($posts);
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;

        //var_dump($paginator);


        $termsArr = array();
        foreach ($paginator as $key => $item) {
            $termsArr[] = $this->_modelTerm->getTermsOfPost($item->ID);   //var_dump($foo);
        }
        $this->view->termsArr = $termsArr;
    }



    public function viewAction() {

        // var_dump($this->getRequest()->getParams());


        $id = $this->getRequest()->id;

        $model = new Model_DbTable_Post();
        $post = $model->getPost($id);

        // var_dump($post ->toArray());

        $this->view->post = $post;


     $this->view->partheadtitle = $post ->post_title. " | ";

        $termsArr = $this->_modelTerm->getTermsOfPost($post->ID);

        //var_dump($termsArr);
        $this->view->termsArr = $termsArr;
    }

    /*
      public function wpviewAction() {

      //var_dump($this->getRequest());
      $id = $this->getRequest()->p;

      $model = new Model_DbTable_Post();
      $post = $model->getPost(substr($id, 2));


      $this->view->post = $post;

      $termsArr = $this->_modelTerm->getCategoriesOfPost($post->ID);

      $this->view->termsArr = $termsArr;

      $this->render('view');
      }
     */

    public function notallowedAction() {
        
    }

    



}

