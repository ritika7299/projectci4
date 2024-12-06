<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    // Specify the table name in the database
    protected $table = 'programme_info';            // Table name
    protected $primaryKey = 'prog_id';              // Primary key of the table

    // Specify the fields you want to insert
    protected $allowedFields = [
        'progTitle',
        'targetGroup',
        'date',
        'progDirector',
        'dealingAsstt',
        'progPdf',
        'attendancePdf',
        'materialLink',
        'paymentdone'
    ];
    protected $useTimestamps = true;

    // Method to save the data
    // public function saveDetail($data)
    // {
    //     // print_r('hello');
    //     // die;
    //     try {
    //         // Insert data into the table
    //         if ($this->insert($data)) {
    //             return [
    //                 'status' => true,
    //                 'message' => 'Data saved successfully',
    //             ];
    //         } else {
    //             return [
    //                 'status' => false,
    //                 'message' => 'Failed to save data',
    //                 'errors' => $this->errors() // Capture validation or database errors
    //             ];
    //         }
    //     } catch (\Exception $e) {
    //         // Catch and return any exception that occurs during the operation
    //         return [
    //             'status' => false,
    //             'message' => 'An error occurred while saving data',
    //             'error_detail' => $e->getMessage(),
    //         ];
    //     }
    // }

    // public function updateDetail($data)
    // {


    //     // print_r("sameer");
    //     // die;
    //     // alert($data);die;
    //     try {
    //         // Ensure 'id' is provided for updating
    //         if (!isset($data['prog_id'])) {
    //             return [
    //                 'status' => false,
    //                 'message' => 'Missing record ID for update',
    //             ];
    //         }

    //         // Update data in the table
    //         if ($this->update($data['prog_id'], $data)) {
    //             return [
    //                 'status' => true,
    //                 'message' => 'Data updated successfully',
    //             ];
    //         } else {
    //             // Log validation errors
    //             log_message('error', 'Failed to update data: ' . json_encode($this->errors()));

    //             return [
    //                 'status' => false,
    //                 'message' => 'Failed to update data',
    //                 'errors' => $this->errors(),
    //             ];
    //         }
    //     } catch (\Exception $e) {
    //         // Log exception
    //         log_message('critical', 'Database Update Error: ' . $e->getMessage());

    //         return [
    //             'status' => false,
    //             'message' => 'An error occurred while updating data',
    //             'error_detail' => $e->getMessage(),
    //         ];
    //     }
    // }


    public function get_user_details($prog_id)
    {
        $query = "select * from programme_info where prog_id='$prog_id' ";
        print_r($query);
        // die;


        $result = $this->db->query($query);
        if ($result) {
            return $result->getResultArray();
        }
        // return $this->db->table('programme_info')
        //     ->where('prog_id', $prog_id)
        //     ->update($data);
    }
}

