<?php

class Model_DbTable_Term extends Zend_Db_Table_Abstract {

    protected $_name = 'wp_terms';

    /*
      public function getCategories() {
      try {
      $db = $this->getDefaultAdapter();
      if ($db == null)
      return "NO DATABASE";

      $sql = "SELECT *
      FROM wp_term_relationships
      LEFT JOIN wp_term_taxonomy
      ON (wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
      LEFT JOIN wp_terms on wp_term_taxonomy.term_taxonomy_id = wp_terms.term_id
      WHERE wp_term_taxonomy.taxonomy = 'category' AND wp_posts.post_status= 'publish'
      GROUP BY wp_term_taxonomy.term_id
      ORDER BY name
      ";

      // echo $sql;
      $result = $db->query($sql);

      return $result;
      } catch (Exception $e) {
      return -1;
      }
      }
     */

    //category
    public function getTerms() {

        $select = $this->select()
                ->distinct()
                ->from($this->_name, array('name', 'term_id'))
                ->joinLeft('wp_term_taxonomy', 'wp_terms.term_id=wp_term_taxonomy.term_id', array())
                ->joinLeft('wp_term_relationships', 'wp_term_taxonomy.term_taxonomy_id=wp_term_relationships.term_taxonomy_id', array())
                ->joinLeft('wp_posts', 'wp_term_relationships.object_id=wp_posts.ID', array())
                ->where('wp_posts.post_status=?', 'publish')
                // ->where('wp_term_taxonomy.taxonomy=?', 'post_tag')
                ->where('wp_term_taxonomy.taxonomy=?', 'category')
                ->order('name ASC');

        $select->setIntegrityCheck(false);
        // echo "<br>$select<br>";
        $terms = $this->fetchAll($select);

        return $terms->toArray();
    }

    //post_tag
    public function getTerms2() {

        $select = $this->select()
                ->distinct()
                ->from($this->_name, array('name', 'term_id'))
                ->joinLeft('wp_term_taxonomy', 'wp_terms.term_id=wp_term_taxonomy.term_id', array())
                ->joinLeft('wp_term_relationships', 'wp_term_taxonomy.term_taxonomy_id=wp_term_relationships.term_taxonomy_id', array())
                ->joinLeft('wp_posts', 'wp_term_relationships.object_id=wp_posts.ID', array())
                ->where('wp_posts.post_status=?', 'publish')
                ->where('wp_term_taxonomy.taxonomy=?', 'post_tag')
                //->where('wp_term_taxonomy.taxonomy=?', 'category')
                ->order('name ASC');

        $select->setIntegrityCheck(false);
        // echo "<br>$select<br>";
        $terms = $this->fetchAll($select);

        return $terms->toArray();
    }

    public function getTermById($id) {

        $select = $this->select()
                ->from($this->_name, array('name'))
                ->where('term_id=?', $id);

        $category = $this->fetchRow($select);

        return $category;
    }

    public function getTermsOfPost($postid) {

        $select = $this->select()
                ->from($this->_name, array('name', 'term_id'))
                ->joinLeft('wp_term_taxonomy', 'wp_terms.term_id=wp_term_taxonomy.term_id', array())
                ->joinLeft('wp_term_relationships', 'wp_term_taxonomy.term_taxonomy_id=wp_term_relationships.term_taxonomy_id', array())
                ->joinLeft('wp_posts', 'wp_term_relationships.object_id=wp_posts.ID', array())
                ->where('wp_posts.ID=?', $postid);

        $select->setIntegrityCheck(false);
        // echo "<br>$select<br>";
        $categories = $this->fetchAll($select);

        return $categories->toArray();
    }

}

?>
