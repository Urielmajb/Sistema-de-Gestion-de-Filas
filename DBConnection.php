<?php
//date_default_timezone_set('America/Managua');
if(!is_dir(__DIR__.'../db'))
    //mkdir(__DIR__.'../db');
if(!defined("db_file")) define('db_file',__DIR__.'../db/cashier_queuing_db.db');
if(!defined('tZone')) define('tZone',"America/Managua");
//if(!defined('tZone')) define('tZone',"Asia/Manila");
if(!defined('dZone')) define('dZone',ini_get('date.timezone'));
function my_udf_md5($string) {
    return md5($string);
}

Class DBConnection extends SQLite3{
    protected $db;
    function __construct(){
        $this->open(db_file);
        $this->createFunction('md5', 'my_udf_md5');
        $this->exec("PRAGMA foreign_keys = ON;");

        $this->exec("CREATE TABLE IF NOT EXISTS `user_list` (
            `user_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `fullname` INTEGER NOT NULL,
            `username` TEXT NOT NULL,
            `password` TEXT NOT NULL,
            `status` INTEGER NOT NULL Default 1,
            `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"); 

        $this->exec("CREATE TABLE IF NOT EXISTS `cashier_list` (
            `cashier_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `name` TEXT NOT NULL,
            `log_status` INTEGER NOT NULL DEFAULT 0,
            `status` INTEGER NOT NULL DEFAULT 1
        )");
        
        $this->exec("CREATE TABLE IF NOT EXISTS `queue_list` (
            `queue_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            `queue` TEXT NOT NULL,
            `customer_name` Text NOT NULL,
            `status` INTEGER NOT NULL DEFAULT 0,
            `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            -- `no_tram` TEXT 

        )");

        // $this->exec("CREATE TABLE IF NOT EXISTS `queue_list` (
        //     `queue_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        //     `queue` TEXT NOT NULL,
        //     `customer_name` Text NOT NULL,
        //     `status` INTEGER NOT NULL DEFAULT 0,
        //     `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        // )");


        // $this->exec("CREATE TABLE IF NOT EXISTS `ticket_list` (
        //     `ticket_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        //     `ticket_no` TEXT NOT NULL,
        //     `rp_id` INTEGER NOT NULL,
        //     `passenger_type` TEXT NOT NULL,
        //     `price` REAL NOT NULL,
        //     `date_added` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     `user_id` INTEGER NULL,
        //     FOREIGN KEY(`rp_id`) REFERENCES `route_prices`(`rp_id`) ON DELETE SET NULL,
        //     FOREIGN KEY(`user_id`) REFERENCES `user_list`(`user_id`) ON DELETE SET NULL
        // )");

        
        // $this->exec("CREATE TRIGGER IF NOT EXISTS updatedTime_prod AFTER UPDATE on `product_list`
        // BEGIN
        //     UPDATE `product_list` SET date_updated = CURRENT_TIMESTAMP where product_id = product_id;
        // END
        // ");

        $this->exec("INSERT or IGNORE INTO `user_list` VALUES (1,'Administrator','admin',md5('admin123'),1, CURRENT_TIMESTAMP)");
        $this->exec("INSERT or IGNORE INTO `user_list` VALUES (5,'Administrator','ujiron',md5('urielma123'),1, CURRENT_TIMESTAMP)");
    }
    function __destruct(){
    $this->close();
    }
}

$conn = new DBConnection();