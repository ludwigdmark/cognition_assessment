<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Complexquery extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

    }

    public function index()
    {

        $all = "
        USE `cognition`;

        DROP TABLE IF EXISTS `cognition`.`people`;

        CREATE TABLE `cognition`.`people` (
            `id` int(11) AUTO_INCREMENT,
            `fullname` varchar(100),
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY `id` (`id`)
        );
        
        DROP TABLE IF EXISTS `cognition`.`interests`;

        CREATE TABLE `cognition`.`interests` (
            `id` int(11) AUTO_INCREMENT,
            `interest_name` varchar(100),
            `multiple_docs_allowed` bit(1),
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY `id` (`id`)
        );
        
        DROP TABLE IF EXISTS `cognition`.`interests_rel`;

        CREATE TABLE `cognition`.`interests_rel` (
            `id` int(11) AUTO_INCREMENT,
            `person_pk` int(11),
            `interest_pk` int(11),
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY `id` (`id`)
        );
        
        DROP TABLE IF EXISTS `cognition`.`documents`;

        CREATE TABLE `cognition`.`documents` (
            `id` int(11) AUTO_INCREMENT,
            `filename` varchar(100),
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY `id` (`id`)
        );
        
        DROP TABLE IF EXISTS `cognition`.`documents_rel`;

        CREATE TABLE `cognition`.`documents_rel` (
            `id` int(11) AUTO_INCREMENT,
            `person_pk` int(11),
            `interest_pk` int(11),
            `document_pk` int(11),
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY `id` (`id`)
        );
        ";

        if (empty($_GET)) {

            $this->db->query("DROP TABLE IF EXISTS `cognition`.`people`;");

            $this->db->query("CREATE TABLE `cognition`.`people` (
                `id` int(11) AUTO_INCREMENT,
                `fullname` varchar(100),
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY `id` (`id`)
            );");
    
            $this->db->query("DROP TABLE IF EXISTS `cognition`.`interests`;");
    
            $this->db->query("CREATE TABLE `cognition`.`interests` (
                `id` int(11) AUTO_INCREMENT,
                `interest_name` varchar(100),
                `multiple_docs_allowed` bit(1),
                `docs_allowed` bit(1),
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY `id` (`id`)
            );");
    
            $this->db->query("DROP TABLE IF EXISTS `cognition`.`interests_rel`;");
    
            $this->db->query("CREATE TABLE `cognition`.`interests_rel` (
                `id` int(11) AUTO_INCREMENT,
                `person_pk` int(11),
                `interest_pk` int(11),
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY `id` (`id`)
            );");
    
            $this->db->query("DROP TABLE IF EXISTS `cognition`.`documents`;");
    
            $this->db->query("CREATE TABLE `cognition`.`documents` (
                `id` int(11) AUTO_INCREMENT,
                `filename` varchar(100),
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY `id` (`id`)
            );");
            
            $this->db->query("DROP TABLE IF EXISTS `cognition`.`documents_rel`;");
            
            $this->db->query("CREATE TABLE `cognition`.`documents_rel` (
                `id` int(11) AUTO_INCREMENT,
                `person_pk` int(11),
                `interest_pk` int(11),
                `document_pk` int(11),
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY `id` (`id`)
            );");
    
            //https://raw.githubusercontent.com/zauberware/personal-interests-json/master/data/interests.json
            $interests = [
                "Agile methods","Activism","Authenticity","GNI","Blockchain","Blogging","Coaching","Corporate Social Responsibility","Creative thinking","Democracy","Digital Media",
                "Digital Marketing","Digitization","Diversity","Eco-Design"
            ];
    
            foreach($interests as $interest) {
                $this->db->query("INSERT INTO `cognition`.`interests` (`interest_name`, `multiple_docs_allowed`, `docs_allowed`) VALUES ('$interest', 0, 1);");
            }
    
            $this->db->query("INSERT INTO `cognition`.`interests` (`interest_name`, `multiple_docs_allowed`, `docs_allowed`) VALUES ('Gardening', 1, 1);");        
            $this->db->query("INSERT INTO `cognition`.`interests` (`interest_name`, `multiple_docs_allowed`, `docs_allowed`) VALUES ('Animals', 1, 1);");
            $this->db->query("INSERT INTO `cognition`.`interests` (`interest_name`, `multiple_docs_allowed`, `docs_allowed`) VALUES ('Children', 1, 1);");
                  
            $this->db->query("INSERT INTO `cognition`.`interests` (`interest_name`, `multiple_docs_allowed`, `docs_allowed`) VALUES ('Sport', 0, 0);");
            $this->db->query("INSERT INTO `cognition`.`interests` (`interest_name`, `multiple_docs_allowed`, `docs_allowed`) VALUES ('Fishing', 0, 0);");
    
            $people_data = (object)json_decode(file_get_contents("https://randomuser.me/api/?results=50&inc=name&nat=gb,us&noinfo"), true);
    
            foreach($people_data->results as $person) {
    
                $person_name = join(" ", [$person["name"]["title"], $person["name"]["first"], $person["name"]["last"]]);
                $this->db->query("INSERT INTO `cognition`.`people` (`fullname`) VALUES ('$person_name');");
            
                $query = $this->db->query("SELECT `id` FROM `cognition`.`people` WHERE `fullname` = '$person_name';");
        
                $person_id = $query->row(0)->id;
    
                $no_of_interests = mt_rand(3, 12);
    
                $query = $this->db->query("SELECT `id`, `interest_name`, `multiple_docs_allowed` FROM `cognition`.`interests` ORDER BY RAND() LIMIT $no_of_interests;");
    
                $persons_interests = $query->result_array();
    
                foreach($persons_interests as $interest) {
    
                    $interest = (object)$interest;
    
                    $this->db->query("INSERT INTO `cognition`.`interests_rel` (`person_pk`, `interest_pk`) VALUES ('$person_id', '$interest->id');");
    
                }
    
            }
    
            $query = $this->db->query("
                SELECT pe.id AS 'person_pk', it.id AS 'interest_pk', pe.fullname, it.interest_name, it.multiple_docs_allowed, it.docs_allowed FROM `cognition`.`people` AS pe
                LEFT JOIN `cognition`.`interests_rel` AS ir ON pe.id = ir.person_pk
                LEFT JOIN `cognition`.`interests` AS it ON it.id = ir.interest_pk;
            ");
    
            $persons_interests = $query->result_array();
    
            foreach($persons_interests as $interest) {
    
                $interest = (object)$interest;
    
                if ($interest->docs_allowed == 1) {
    
                    if ($interest->multiple_docs_allowed == 0) {
    
                        $dice_roll = mt_rand(1, 100);
        
                        if ($dice_roll <= 60) {
        
                            $filename = uniqid(rand(), true) . '.pdf';
        
                            $this->db->query("INSERT INTO `cognition`.`documents` (`filename`) VALUES ('$filename');");
        
                            $query = $this->db->query("SELECT `id` FROM `cognition`.`documents` WHERE `filename` = '$filename';");
            
                            $doc_id = $query->row(0)->id;
        
                            $this->db->query("INSERT INTO `cognition`.`documents_rel` (`person_pk`, `interest_pk`, `document_pk`) VALUES ('$interest->person_pk', '$interest->interest_pk', '$doc_id');");
                        
                        }
        
                    } else {
        
                        $doc_count = mt_rand(1, 4);
        
                        while ($doc_count > 0) {
        
                            $doc_count--;
                            
                            if ($dice_roll <= 60) {
        
                                $filename = uniqid(rand(), true) . '.pdf';
        
                                $this->db->query("INSERT INTO `cognition`.`documents` (`filename`) VALUES ('$filename');");
        
                                $query = $this->db->query("SELECT `id` FROM `cognition`.`documents` WHERE `filename` = '$filename';");
                
                                $doc_id = $query->row(0)->id;
        
                                $this->db->query("INSERT INTO `cognition`.`documents_rel` (`person_pk`, `interest_pk`, `document_pk`) VALUES ('$interest->person_pk', '$interest->interest_pk', '$doc_id');");
                        
                            }
        
                        }
        
                    }
    
                }
    
            }

            $sql = "SELECT pe.fullname, it.interest_name, dc.filename FROM `cognition`.`people` AS pe
                LEFT JOIN `cognition`.`interests_rel` AS ir ON pe.id = ir.person_pk
                LEFT JOIN `cognition`.`interests` AS it ON it.id = ir.interest_pk
                LEFT JOIN `cognition`.`documents_rel` AS dr ON pe.id = dr.person_pk AND it.id = dr.interest_pk
                LEFT JOIN `cognition`.`documents` AS dc ON dc.id = dr.document_pk
                GROUP BY pe.fullname, it.interest_name, dc.filename
            ;";

            $query = $this->db->query($sql);

            $data = array();

            $data["results"] = $query->result_array();
            $data["query"] = $sql;
            $data["name"] = "All";
            $data["all"] = $all;

            $this->load->view("query_view.php", $data);

        } else if (isset($_GET["animallovers"])) {

            $sql = "SELECT DISTINCT pe.fullname FROM `cognition`.`people` AS pe
                LEFT JOIN `cognition`.`interests_rel` AS ir ON pe.id = ir.person_pk
                LEFT JOIN `cognition`.`interests` AS it ON it.id = ir.interest_pk
                LEFT JOIN `cognition`.`documents_rel` AS dr ON pe.id = dr.person_pk AND it.id = dr.interest_pk
                LEFT JOIN `cognition`.`documents` AS dc ON dc.id = dr.document_pk
                WHERE it.interest_name = 'Animals'
                GROUP BY pe.fullname
                HAVING COUNT(dr.document_pk) = 1
            ;";

            $query = $this->db->query($sql);

            $data = array();

            $data["results"] = $query->result_array();
            $data["query"] = $sql;
            $data["name"] = "Animal Lovers";
            $data["all"] = $all;

            $this->load->view("query_view.php", $data);


        } else if (isset($_GET["childrensports"])) {

            $sql = "SELECT DISTINCT pe.fullname FROM `cognition`.`people` AS pe
                LEFT JOIN `cognition`.`interests_rel` AS ir ON pe.id = ir.person_pk
                LEFT JOIN `cognition`.`interests` AS it ON it.id = ir.interest_pk
                LEFT JOIN `cognition`.`documents_rel` AS dr ON pe.id = dr.person_pk AND it.id = dr.interest_pk
                LEFT JOIN `cognition`.`documents` AS dc ON dc.id = dr.document_pk
                WHERE it.interest_name in ('Sports', 'Children');
            ;";

            $query = $this->db->query($sql);

            $data = array();

            $data["results"] = $query->result_array();
            $data["query"] = $sql;
            $data["name"] = "Children Sports";
            $data["all"] = $all;

            $this->load->view("query_view.php", $data);


        } else if (isset($_GET["nodocs"])) {

            $sql = "SELECT it.interest_name, COUNT(pe.fullname) no_of_people FROM `cognition`.`people` AS pe
                LEFT JOIN `cognition`.`interests_rel` AS ir ON pe.id = ir.person_pk
                LEFT JOIN `cognition`.`interests` AS it ON it.id = ir.interest_pk
                LEFT JOIN `cognition`.`documents_rel` AS dr ON pe.id = dr.person_pk AND it.id = dr.interest_pk
                LEFT JOIN `cognition`.`documents` AS dc ON dc.id = dr.document_pk
                WHERE dr.id IS NULL
                GROUP BY it.interest_name;
            ;";

            $query = $this->db->query($sql);

            $data = array();

            $data["results"] = $query->result_array();
            $data["query"] = $sql;
            $data["name"] = "No Docs";
            $data["all"] = $all;

            $this->load->view("query_view.php", $data);


        } else if (isset($_GET["manydocs"])) {

            $sql = "SELECT pe.id, pe.fullname FROM `cognition`.`people` AS pe
                LEFT JOIN `cognition`.`interests_rel` AS ir ON pe.id = ir.person_pk
                LEFT JOIN `cognition`.`interests` AS it ON it.id = ir.interest_pk
                LEFT JOIN `cognition`.`documents_rel` AS dr ON pe.id = dr.person_pk AND it.id = dr.interest_pk
                LEFT JOIN `cognition`.`documents` AS dc ON dc.id = dr.document_pk
                WHERE pe.id IN (
                    SELECT dr.person_pk FROM `cognition`.`documents_rel` AS dr
                    GROUP BY dr.person_pk, dr.interest_pk
                    HAVING COUNT(*) > 1
                )
                GROUP BY pe.id, pe.fullname
                HAVING COUNT(*) IN (5, 6);                
            ;";

            $query = $this->db->query($sql);

            $data = array();

            $data["results"] = $query->result_array();
            $data["query"] = $sql;
            $data["name"] = "Many Docs";
            $data["all"] = $all;

            $this->load->view("query_view.php", $data);


        }

    }
}
