<?php
namespace App\Service;


class Database
{
    function prepare_execute_and_fetch($conn, $sql_cmd)
    {
        $stmt = $conn->prepare($sql_cmd);
        $resultSet = $stmt->executeQuery();
        return($resultSet->fetchAllAssociative());

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

}
