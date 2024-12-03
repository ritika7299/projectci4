<?php
namespace App\Controllers;
use App\Models\AdminModel;
use App\Models\ProgrammeModel;
class Admin extends BaseController
{
    protected $programmeModel;
    // controller construct
    public function __construct()
    {
        $this->programmeModel = new ProgrammeModel();
    }
    // login view page 
    public function index()
    {
        return view('admin/login');
    }
    // admin login function
    public function login()
    {
        $session = session();
        $email = $this->request->getPost('name');
        $password = $this->request->getPost('password');
        $model = new AdminModel();
        $admin = $model->where('name', $email)->first();

        if ($admin && $admin['password'] === $password) {
            // Store user info in session (you may want to store more than just 'name')
            $session->set('logged_in', true);
            $session->set('name', $admin['name']);  // Store the logged-in user's name
            //  echo"hello";die;
            return redirect()->to('admin/dashboard');
        } else {
            $session->setFlashdata('error', '<i class="fa fa-warning"></i> Invalid username or password.');
            return redirect()->to('/');
        }
    }

    public function dashboard()
    {
        $model = new ProgrammeModel();
        $programmeInfo = $model->orderBy('created_at', 'DESC')->findAll(); // Fetch all rooms records

        // Format the created_at date to dd/mm/yyyy
        foreach ($programmeInfo as &$programme) {
            // Check if the date is empty or null
            if (empty($programme['date'])) {
                $programme['date'] = '00/00/0000'; // Default date if not set
            } else {
                $programme['date'] = date('d/m/Y', strtotime($programme['date'])); // Format date if available
            }
        }

        $data['prog_data'] = $programmeInfo;
        return view('admin/dashboard', $data); // Pass formatted data to the view
    }
    // save details function
    /* this is correct code user after all testing*/
    public function saveDetails()
    {
        $request = service('request');
        // Collect form data
        $data = [
            'progTitle' => $request->getPost('progTitle'),
            'targetGroup' => $request->getPost('targetGroup'),
            'date' => $request->getPost('date'),
            'progDirector' => $request->getPost('progDirector'),
            'dealingAsstt' => $request->getPost('dealingAsstt'),
            'progPdf' => $request->getPost('progPdf'),
            'attandancePdf' => $request->getPost('attandancePdf'),
            'materialLink' => $request->getPost('materialLink'),
            'paymentdone' => $request->getPost('paymentdone'),
        ];
        // print_r($data);
        // die;

        // Get the username from the session or request
        $userName = session()->get('name'); // Assuming username is stored in the session
        if (!$userName) {
            // Handle the case if the username is not available
            session()->setFlashdata('error', 'User not logged in');
            return redirect()->to('/dashboard');
        }

        // File Upload Configuration
        $fileFields = ['progPdf', 'attandancePdf'];
        $uploadPathProgramsPdf = WRITEPATH . 'uploads/programs_pdf/';
        $uploadPathAttendance = WRITEPATH . 'uploads/attendance_pdf/';
        helper(['form', 'filesystem']);

        foreach ($fileFields as $field) {
            $file = $this->request->getFile($field);

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $originalFileName = $file->getClientName();  // Get the original file name
                $fileExtension = $file->getExtension();  // Get the file extension

                // Create the new file name by appending the logged-in user's name (i.e., 'by john')
                // We use pathinfo to get the original file name without the extension
                $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . ' by ' . $userName . '.' . $fileExtension;

                // Determine the correct path based on the field and move the file
                if ($field == 'progPdf') {
                    // Move the program PDF file to the specified directory and save the relative path
                    $file->move($uploadPathProgramsPdf, $newFileName);
                    $data[$field] = 'uploads/programs_pdf/' . $newFileName; // Save relative file path
                } elseif ($field == 'attandancePdf') {
                    // Move the attendance PDF file to the specified directory and save the relative path
                    $file->move($uploadPathAttendance, $newFileName);
                    $data[$field] = 'uploads/attendance_pdf/' . $newFileName; // Save relative file path
                }
            }
        }
        // print_r($file);
        // print_r("htt");
        // die;

        // Save data to the database using the model
        $programmeModel = new ProgrammeModel();
        try {
            // Attempt to save the details in the database
            $result = $programmeModel->saveDetail($data);
            session()->setFlashdata('success', 'Details Added successfully!');
        } catch (\Exception $e) {
            // Handle exceptions
            session()->setFlashdata('error', $e->getMessage());
        }

        // Redirect to the dashboard after saving
        return redirect()->to('admin/dashboard');
    }





    // delete details function
    public function delete($prog_id = null)
    {
        // Check if the prog_id is valid
        if ($prog_id === null) {
            // Redirect with error message if prog_id is not provided
            session()->setFlashdata('error', 'No program ID provided.');
            return redirect()->to(base_url('admin/dashboard'));
        }

        // Initialize the model
        $model = new ProgrammeModel();

        // Attempt to delete the record
        $result = $model->where('prog_id', $prog_id)->delete();

        // Check if deletion was successful
        if ($result) {
            // Set success message if deletion was successful
            session()->setFlashdata('success', 'Details deleted successfully.');
        } else {
            // Set error message if deletion failed
            session()->setFlashdata('error', 'Error deleting program.');
        }

        // Redirect back to the dashboard
        return redirect()->to(base_url('admin/dashboard'));
    }

    public function getDetails($prog_id)
    {
        $programmeModel = new ProgrammeModel();
        $data = $programmeModel->find($prog_id);

        if ($data) {
            return $this->response->setJSON($data);
        } else {
            return $this->response->setJSON(['status' => false, 'message' => 'Record not found']);
        }
    }


    // public function updateDetails()
    // {
    //     $request = service('request');
    //     $data = $request->getPost();
    //    // print_r($data);

    //     // Handle file uploads if any
    //     if ($file = $this->request->getFile('progPdf')) {
    //         if ($file->isValid() && !$file->hasMoved()) {
    //             $newName = $file->getRandomName();
    //             $file->move(WRITEPATH . 'uploads/programs_pdf', $newName);
    //             $data['progPdf'] = 'uploads/programs_pdf/' . $newName;
    //         }
    //     }
    //     die;

    //     $programmeModel = new ProgrammeModel();
    //     try {
    //         $result = $programmeModel->updateDetail($data);

    //         return $this->response->setJSON([
    //             'status' => $result['status'],
    //             'message' => $result['message'] ?? 'Details updated successfully!',
    //         ]);
    //     } catch (\Exception $e) {
    //         return $this->response->setJSON([
    //             'status' => false,
    //             'message' => $e->getMessage(),
    //         ]);
    //     }
    // }




    // Admin logout function
    public function logout()
    {
        $session = session();
        $session->destroy(); // Destroy session
        return redirect()->to(base_url('/')); // Redirect to login page
    }

}
