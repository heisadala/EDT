<?php
namespace App\Service;


class Database
{
    function prepare_and_execute($conn, $sql_cmd)
    {
        $stmt = $conn->prepare($sql_cmd);
        return($stmt->executeQuery());

    }
    function prepare_execute_and_fetch($conn, $sql_cmd)
    {
        $stmt = $conn->prepare($sql_cmd);
        $resultSet = $stmt->executeQuery();
        return($resultSet->fetchAllAssociative());

    }
    
    function prepare_execute_statement($conn, $sql_cmd)
    {
        $stmt = $conn->prepare($sql_cmd);
        $resultSet = $stmt->executeStatement();
        // return $resultSet;

    }
    public function send_sql_cmd($conn, $sql_cmd): array
    {
        return($this->prepare_execute_and_fetch($conn, $sql_cmd));
    }
    public function send_sql_update_cmd($conn, $sql_cmd)
    {
        $this->prepare_execute_statement($conn, $sql_cmd);
    }
    public function fetch_header_fields_from_table($conn, $table_name): array
    {
        $sql_cmd = "DESCRIBE $table_name";
        return($this->prepare_execute_and_fetch($conn, $sql_cmd));
    }
    public function show_indexes($conn, $table_name): array
    {
        $sql_cmd = "SHOW INDEXES FROM $table_name";
        return($this->prepare_execute_and_fetch($conn, $sql_cmd));
    }

    public function get_pk_name($conn, $table_name): string
    {
        $result = $this->show_indexes($conn, $table_name);
        $pk_name = $result[0]['Column_name'];
        return $pk_name;
    }

    function fetch_class_from_table_ordered($conn, $table_name, $ordered_by, $sort_order)
    {
        // Get contents
        $sql_cmd = "SELECT * FROM $table_name ORDER by $ordered_by $sort_order;";
        return($this->prepare_execute_and_fetch($conn, $sql_cmd));

    }
    function fetch_class_from_table_filter_and_ordered($conn, $table_name, $user, $ordered_by, $sort_order)
    {
        // Get contents
        $sql_cmd = "SELECT * FROM $table_name WHERE name='$user' ORDER by $ordered_by $sort_order;";
        return($this->prepare_execute_and_fetch($conn, $sql_cmd));

    }

    function fetch_class_from_table_all_ordered($conn, $table_name, $archive, $userlist, $ordered_by, $sort_order)
    {
        // Get contents
        $sql_cmd = "SELECT * FROM $table_name WHERE archive='$archive' AND userlist='$userlist' ORDER by $ordered_by $sort_order;";
        return($this->prepare_execute_and_fetch($conn, $sql_cmd));

    }
    function fetch_class_from_table_user_ordered($conn, $table_name, $user, $archive, $ordered_by, $sort_order)
    {
        // Get contents
        $sql_cmd = "SELECT * FROM $table_name WHERE name='$user' AND archive='$archive'  ORDER by $ordered_by $sort_order;";
        return($this->prepare_execute_and_fetch($conn, $sql_cmd));
    }
    function fetch_column_unique_value($conn, $table_name, $column_name)
    {
        $sql_cmd = "SELECT $column_name FROM $table_name GROUP BY $column_name ORDER by $column_name ASC;";
        return($this->prepare_execute_and_fetch($conn, $sql_cmd));
    }


    function join_project_and_prestataire($conn, $t1, 
                                            $t1_id,
                                            $t2,
                                            $t2_key, $ordered_by, $sort_order)
    {

        $sql_cmd = "SELECT * FROM " . $t1 
                    . " JOIN " . $t2 . " ON " . $t1 . "." . $t1_id . " = " . $t2 . "." . $t2_key . ";";
        return $this->prepare_execute_and_fetch($conn, $sql_cmd);
}       

    function join_compte_project_and_prestataire($conn, $t1, $t1_short, $selectlist,
                                                    $t1_id,
                                                    $t2,
                                                    $t2_id, $t2_key,
                                                    $t3, 
                                                    $t3_key, $ordered_by, $sort_order)
    {        
        $sql_cmd = "SELECT " . $selectlist . 
                   " FROM " . $t1 . " " . $t1_short
                    . " JOIN " . $t2 . " ON " . $t1 . "." . $t1_id . " = " . $t2 . "." . $t2_key
                    . " JOIN " . $t3 . " ON " . $t2 . "." . $t2_id . " = " . $t3 . "." . $t3_key
                    . " ORDER BY " . $t1 . "." . $ordered_by . ";";
        return $this->prepare_execute_and_fetch($conn, $sql_cmd);
    }

    function join_three_tables_with_filter($conn,
                                                    $t1,
                                                    $t1_id,
                                                    $t2,
                                                    $t2_id, $t2_key, 
                                                    $t3, 
                                                    $t3_key, $column, $filter)
    {        
        $sql_cmd = "SELECT * FROM " . $t1 
                    . " JOIN " . $t2 . " ON " . $t1 . "." . $t1_id . " = " . $t2 . "." . $t2_key
                    . " JOIN " . $t3 . " ON " . $t2 . "." . $t2_id . " = " . $t3 . "." . $t3_key
                    . " WHERE " . $t1 . "." . $column . " = " . $filter . ";";
        return $this->prepare_execute_and_fetch($conn, $sql_cmd);
    }

    function join_n_tables_with_filter($conn, $number, $t1, $join_table,
                                        $column, $filter)
    {   
        for($i=0; $i<$number; $i++)
        {
            $join_cmd = '';
            $join_cmd = $join_cmd . " JOIN " . $join_table[$i]['join_table']
                 . " ON " . $join_table[$i]['on_table'] . "." . $join_table[$i]['on_table_id']
                 . " = " . $join_table[$i]['join_table'] . "." . $join_table[$i]['join_table_id'];
        }
        $sql_cmd = "SELECT * FROM " . $t1 
                    . $join_cmd
                    . " WHERE " . $t1 . "." . $column . " = " . $filter . ";";



                    // dd($sql_cmd);
        return $this->prepare_execute_and_fetch($conn, $sql_cmd);
    }

    public function update_proj_montant($conn, $table_name, $column_name, $value, $id) {
        $sql_cmd = "UPDATE " . $table_name . " SET " . $column_name . " = " . $value 
                    . " WHERE projet_id" . "=" . $id .";";
        $this->prepare_execute_statement($conn, $sql_cmd);              
    }    
    
    public function update_edt_montant($conn, $table_name, $column_name, $value, $id) {
        $sql_cmd = "UPDATE " . $table_name . " SET " . $column_name . "='" . $value 
                    . "' WHERE edt_id" . "=" . $id . ";";
        $this->prepare_execute_statement($conn, $sql_cmd); 
        // if ($table_name == '2025_edt_table') dd($res, $column_name, $value, $id);             
    }    
    public function update_bilan_montant($conn, $table_name, $column_name, $value) {
        $sql_cmd = "UPDATE " . $table_name . " SET " . $column_name . "='" . $value 
                    . "' WHERE bilan_id=1;";
        $this->prepare_execute_statement($conn, $sql_cmd);              
    }    
    
    public function update_c_montant($conn, $table_name, $column_name, $value, $id) {
        $sql_cmd = "UPDATE " . $table_name . " SET " . $column_name . " = " . $value 
                    . " WHERE projet_id" . "=" . $id .";";
        $res = $this->prepare_execute_statement($conn, $sql_cmd);              
    }
    public function update_montant($conn, $table_name, $column_name, $value, $id) {
        $sql_cmd = "UPDATE " . $table_name . " SET " . $column_name . " = " . $value 
                    . " WHERE donateur_id" . "=" . $id .";";
        $res = $this->prepare_execute_statement($conn, $sql_cmd);              
    }
    public function get_max_id($conn, $table_name, $id) {
        $sql_cmd = "SELECT MAX(" . $id . ") FROM " . $table_name  .";";
        // dd($this->prepare_execute_and_fetch($conn, $sql_cmd));              
        return $this->prepare_execute_and_fetch($conn, $sql_cmd);              
    }
    public function select_all_from_where($conn, $table_name, $table_name_id, $id) {
        $sql_cmd = "SELECT * FROM " . $table_name
                . " WHERE " . $table_name . "." . $table_name_id . " = " . $id . ";";
        // dd($this->prepare_execute_and_fetch($conn, $sql_cmd));              
        return $this->prepare_execute_and_fetch($conn, $sql_cmd);              
    }
    public function select_all($conn, $table_name) {
        $sql_cmd = "SELECT * FROM " . $table_name . ";";
        // dd($this->prepare_execute_and_fetch($conn, $sql_cmd));              
        return $this->prepare_execute_and_fetch($conn, $sql_cmd);              
    }
    public function update($conn, $table_name, $column_name, $value, $id_column, $id) {
        $sql_cmd = "UPDATE " . $table_name . " SET " . $column_name . " = " . $value 
                    . " WHERE " . $id_column . "=" . $id .";";
        $res = $this->prepare_execute_and_fetch($conn, $sql_cmd);              
    }

}
