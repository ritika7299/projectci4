<?php
namespace App\Controllers;
use App\Models\AdminModel;
use App\Models\ProgramModel;
class Admin extends BaseController
{
    protected $programModel;
    // controller construct
    public function __construct()
    {
        $this->programModel = new ProgramModel();
    }
    // login view page 
    public function index()
    {
        return view('admin/login');
    }
    // registeration view page 
    public function register_view()
    {
        return view('admin/register');
    }
    //registration details store function 
    public function registerSubmit()
    {

        // Get the form data
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validate the input data
        if (
            !$this->validate([
                'name' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]'
            ])
        ) {
            return redirect()->to('admin/register_view')->withInput()->with('error', $this->validator->getErrors());
        }

        // Create a new UserModel instance
        $adminModel = new AdminModel();

        // Check if the email or username is already taken
        if ($adminModel->isEmailTaken($email)) {
            return redirect()->to('admin/register_view')->withInput()->with('error', '<i class="fa fa-warning"></i> Email is already taken.');
        }

        if ($adminModel->isUsernameTaken($name)) {
            return redirect()->to('admin/register_view')->withInput()->with('error', '<i class="fa fa-warning"></i> Username is already taken.');
        }

        // Insert the user into the database
        $adminModel->save([
            'name' => $name,
            'email' => $email,
            'password' => $password // No password hashing in this example
        ]);

        // Redirect to the login page after successful registration
        return redirect()->to('/')->with('success', 'Registration successful. Please login.');
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
        helper(['form', 'filesystem']);
        $model = new ProgramModel();
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
    /*public function saveDetails()
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
        // Get the username from the session or request
        $userName = session()->get('name'); // Assuming username is stored in the session
        if (!$userName) {
            // Handle the case if the username is not available
            session()->setFlashdata('error', 'User not logged in');
            return redirect()->to('/dashboard');
        }

        // File Upload Configuration
        $fileFields = ['progPdf', 'attandancePdf'];
        $uploadPathProgramsPdf = ROOTPATH . 'uploads/programs_pdf/';
        $uploadPathAttendance = ROOTPATH . 'uploads/attendance_pdf/';
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
                    $data[$field] = 'uploads/programs_pdfs/' . $newFileName; // Save relative file path
                } elseif ($field == 'attandancePdf') {
                    // Move the attendance PDF file to the specified directory and save the relative path
                    $file->move($uploadPathAttendance, $newFileName);
                    $data[$field] = 'uploads/attendance_pdfs/' . $newFileName; // Save relative file path
                }
            }
        }
        // Save data to the database using the model
        $programModel = new ProgramModel();
        try {
            // Attempt to save the details in the database
            $result = $programModel->saveDetail($data);
            session()->setFlashdata('success', 'Details Added successfully!');
        } catch (\Exception $e) {
            // Handle exceptions
            session()->setFlashdata('error', $e->getMessage());
        }

        // Redirect to the dashboard after saving
        return redirect()->to('admin/dashboard');
    }*/





    public function saveDetails()
    {
        $session = session();  // Get the session object
        $userName = $session->get('name');  // Assuming 'name' is stored in the session during login

        // If no user is logged in, set an error message in the session and redirect
        if (!$userName) {
            $session->setFlashdata('status', 'error');
            $session->setFlashdata('message', 'User is not logged in.');
            return redirect()->to('admin/login');  // Redirect to login or an appropriate page
        }
        $request = service('request');
        // Get data from the request
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

        // Validate the required fields
        if (empty($data['progTitle']) || empty($data['targetGroup']) || empty($data['date']) || empty($data['progDirector']) || empty($data['dealingAsstt'])) {
            $session->setFlashdata('status', 'error');
            $session->setFlashdata('message', 'Please fill all required fields.');
            return redirect()->to('admin/dashboard');  // Redirect back to the form page
        }

        // Handle file uploads (progPdf and attandancePdf) independently of paymentdone field
        // Handle programme schedule PDF upload
        $programfile = $this->request->getFile('progPdf');
        // print_r($file); //run here
        // die;
        if ($programfile && $programfile->isValid()) {
            $originalFileName = $programfile->getName();
            $fileExtension = $programfile->getExtension();

            // Concatenate the original file name with " by " and the username
            $newFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '.' . $fileExtension . ' by ' . $userName;

            // Move the file to the 'uploads/program_pdfs' directory with the new name
            $programfile->move('uploads/programPdf', $newFileName);
            $data['progPdf'] = $newFileName;  // Save the new file name in the database
        } else {
            $session->setFlashdata('error', 'Please upload a valid program schedule PDF.');
            return redirect()->to('admin/dashboard');  // Redirect back to the form page
        }

        // Handle attendance PDF upload
        $attendanceFile = $this->request->getFile('attandancePdf');
        if ($attendanceFile && $attendanceFile->isValid()) {
            $originalAttendanceFileName = $attendanceFile->getName();
            $attendanceFileExtension = $attendanceFile->getExtension();

            // Concatenate the original file name with " by " and the username
            $newAttendanceFileName = pathinfo($originalAttendanceFileName, PATHINFO_FILENAME) . '.' . $attendanceFileExtension . ' by ' . $userName;

            // Move the file to the 'uploads/attendance' directory with the new name
            $attendanceFile->move('uploads/attendancePdf', $newAttendanceFileName);
            $data['attandancePdf'] = $newAttendanceFileName;  // Save the new file name in the database
        } else {
            $session->setFlashdata('error', 'Please upload a valid attendance PDF.');
            return redirect()->to('admin/dashboard');  // Redirect back to the form page
        }

        // Save data into the database
        $programModel = new ProgramModel();
        $programModel->save($data);

        // Set success message in the session and redirect back
        $session->setFlashdata('success', 'Details added successfully');
        return redirect()->to('admin/dashboard');  // Redirect back to the form page with success message
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
        $model = new ProgramModel();

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

    // public function getDetails($prog_id)
    // {
    //     $programModel = new ProgramModel();
    //     $data = $programModel->find($prog_id);

    //     if ($data) {
    //         return $this->response->setJSON($data);
    //     } else {
    //         return $this->response->setJSON(['status' => false, 'message' => 'Record not found']);
    //     }
    // }

    // public function getRecordDetails()
    // {
    //     print_r("sameer");
    //     die;
    //     $prog_id = $this->request->getPost('prog_id');

    //     if (!$prog_id) {
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'Invalid request. Programme ID is missing.',
    //         ]);
    //     }

    //     $record = $this->programModel->find($prog_id);

    //     if ($record) {
    //         return $this->response->setJSON([
    //             'status' => 'success',
    //             'data' => $record,
    //         ]);
    //     } else {
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'Record not found.',
    //         ]);
    //     }
    // }
    public function updateRecord()
    {
        // print_r("hh");
        // die;
        $id = $this->request->getGet('prog_id');
        // echo $id;
        // die;
        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Programme ID is missing hai bhai :( ']);
        } else {
            $result = $this->programModel->get_user_details($id);
            // print_r($result);
            // die;
            echo json_encode($result);
        }
    }
    // Admin logout function
    public function logout()
    {
        $session = session();
        $session->destroy(); // Destroy session
        return redirect()->to(base_url('/')); // Redirect to login page
    }
}
