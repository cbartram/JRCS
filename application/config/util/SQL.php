<?php
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/19/16
 * Time: 3:00 PM
 */

class SQL {

    private $db;

    function __construct($DB_con) {
        $this->db = $DB_con;
    }

    /**
     * Returns the DB object
     * @return mixed
     */
    function getDB() {
        return $this->db;
    }

    /**
     * Select All Columns from a given table name
     * @param $table_name table to select from
     * @return returns enumerated array that corresponds to the fetched row(s)
     */
    function selectAll($table_name) {
       $stmt = $this->db->prepare("SELECT * FROM " . $table_name);
       $stmt->execute();

       return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Selects a single specific column from a given table
     * @param $table_name the tables name
     * @param $column_name the columns name
     * @return returns an enumerated array that corresponds to the fetched row(s)
     */
    function selectColumn($table_name, $column_name) {
        $stmt = $this->db->prepare("SELECT " .  $column_name . " FROM " . $table_name);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Selects all columns from a given table where the value_one is equal to value_two
     * @param $table_name
     * @param $value_one
     * @param $value_two
     * @return returns an enumerated array that corresponds to the fetched row(s)
     */
    function selectAllWhere($table_name, $value_one, $value_two) {
        $stmt = $this->db->prepare("SELECT * FROM " . $table_name .  " WHERE " . $value_one . " = " . $value_two);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Selects a single specific column from a given table where the value_one is equal to value_two
     * @param $table_name
     * @param $value_one
     * @param $value_two
     * @return returns an enumerated array that corresponds to the fetched row(s)
     */
    function selectColumnWhere($table_name, $column_name, $value_one, $value_two) {
        $stmt = $this->db->prepare("SELECT " . $column_name . " FROM " . $table_name .  " WHERE " . $value_one . " = " . $value_two);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Selects a user defined number of columns from a given table where the value_one is equal to value_two
     * Pass the column arguments after $table_name i.e. selectColumns(table_visitors, check_in, check_out, is_late)
     * @param $table_name
     * @return returns an enumerated array that corresponds to the fetched row(s)
     */
    function selectColumns($table_name) {
        //todo this hasnt been tested yet
        $columns = "";

        for($i = 1; $i < func_num_args(); $i++) {
             $columns .= func_get_arg($i) . ",";
        }

        //Removes any extraneous commas from the end of the string
        $columns = rtrim($columns, ",");

        $stmt = $this->db->prepare("SELECT " . $columns . " FROM " . $table_name);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



}