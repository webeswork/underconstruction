<?php
class Model_DbTable_Post extends Zend_Db_Table_Abstract
{
	protected $_name = 'wp_posts';

        public function getPosts()
	{

                $select = $this->select()
		 ->from($this->_name, array('*'))
                 ->where('post_status= ?', 'publish')
                 ->where('post_type= ?', 'post')

                 ->order('post_date DESC');
                //->limit(20,0);

		$result = $this->fetchAll($select );
               //var_dump($result->toArray());
		return $result;
	}



                public function getPost($id)
	{

                $select = $this->select()
		 ->from($this->_name, array('*'))
                 ->where('ID= ?', $id);

		$result = $this->fetchRow($select );
		return $result;
	}


/*
Term: 
SELECT *
FROM wp_posts p
LEFT JOIN wp_term_relationships rel ON rel.object_id = p.ID
LEFT JOIN wp_term_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
LEFT JOIN wp_terms t ON t.term_id = tax.term_id
WHERE post_type = 'post' AND post_status = 'publish' AND tax.term_id =62
         */

              public function getPostsByTerm($termid)
	{
        $select = $this->select()
        ->from($this->_name, array('*'))
        ->joinLeft('wp_term_relationships', 'wp_term_relationships.object_id=wp_posts.ID')
        ->joinLeft('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id=wp_term_relationships.term_taxonomy_id')
        ->joinLeft('wp_terms', 'wp_terms.term_id=wp_term_taxonomy.term_id')
        ->where('wp_posts.post_type=?', 'post')
        ->where('wp_posts.post_status=?', 'publish')
        ->where('wp_term_taxonomy.term_id=?', $termid)
        ->order('post_date DESC');

         $select->setIntegrityCheck(false);
        // echo $select."<br>";
        $rows = $this->fetchAll($select);

        return $rows;
	}

      /*
        public function getPostsByTerm($termid)
	{

            try{
              $db = $this->getDefaultAdapter(); 
               if ($db == null) return "NO DATABASE";

$sql="SELECT *
FROM wp_posts p
LEFT JOIN wp_term_relationships rel ON rel.object_id = p.ID
LEFT JOIN wp_term_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
LEFT JOIN wp_terms t ON t.term_id = tax.term_id
WHERE post_type = 'post' AND post_status = 'publish' AND tax.term_id =$termid";

echo $sql;
                $result = $db->query($sql);

                return $result;
            }catch(Exception $e){
               return -1;
            }

	}
*/



	
}