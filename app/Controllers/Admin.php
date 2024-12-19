<?php
namespace App\Controllers;
use App\Models\AdminModel;
use App\Models\ProgramModel;
class Admin extends BaseController
{
    protected $programModel;
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
    public function register()
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
            return redirect()->to('admin/register')->withInput()->with('error', $this->validator->getErrors());
        }

        // Create a new UserModel instance
        $adminModel = new AdminModel();

        // Check if the email or username is already taken
        if ($adminModel->isEmailTaken($email)) {
            return redirect()->to('admin/register')->withInput()->with('error', '<i class="fa fa-warning"></i> Email is already taken.');
        }

        if ($adminModel->isUsernameTaken($name)) {
            return redirect()->to('admin/register')->withInput()->with('error', '<i class="fa fa-warning"></i> Username is already taken.');
        }

        // Insert the user into the database
        $adminModel->save([
            'name' => $name,
            'email' => $email,
            'password' => $password // No password hashing in this example
        ]);

        // Redirect to the login page after successful registration
        return redirect()->to('admin/register')->with('success', 'Registration successful. Please login.');
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
        // Helper functions for form and filesystem
        helper(['form', 'filesystem']);

        // Initialize the ProgramModel and fetch data
        $model = new ProgramModel();
        $programmeInfo = $model->orderBy('created_at', 'DESC')->findAll(); // Fetch all room records

        // Format the created_at date to dd/mm/yyyy
        foreach ($programmeInfo as &$programme) {
            // Check if the date is empty or null
            if (empty($programme['date'])) {
                $programme['date'] = '00/00/0000'; // Default date if not set
            } else {
                $programme['date'] = date('d/m/Y', strtotime($programme['date'])); // Format date if available
            }
        }

        // Store the session expiration timestamp
        $session_expiry_time = time() + config('App')->session['expiration']; // Session expiration time (15 minutes from now)

        // You can also set the 'last_activity' timestamp in the session to track user activity
        session()->set('last_activity', time());

        // Pass the data and session expiration time to the view
        $data['prog_data'] = $programmeInfo;
        $data['session_expiry_time'] = $session_expiry_time;

        // Return the view with the data
        return view('admin/dashboard', $data);
    }
    // save details function
    public function saveDetails()
    {
        $session = session();  // Get the session object
        $userName = $session->get('name');  // Assuming 'name' is stored in the session during login

        // If no user is logged in, set an error message and redirect
        if (!$userName) {
            $session->setFlashdata('error', 'User is not logged in.');
            return redirect()->to('admin/dashboard');  // Redirect to the login page or any other page
        }
        // Get data from the request
        $data = [
            'progTitle' => $this->request->getPost('progTitle'),
            'targetGroup' => $this->request->getPost('targetGroup'),
            'date' => $this->request->getPost('date'),  // This should be in 'DD/MM/YYYY' format
            'progDirector' => $this->request->getPost('progDirector'),
            'dealingAsstt' => $this->request->getPost('dealingAsstt'),
            'progPdf' => $this->request->getPost('progPdf'),
            'attendancePdf' => $this->request->getPost('attendancePdf'),
            'materialLink' => $this->request->getPost('materialLink'),
            'paymentdone' => $this->request->getPost('paymentdone'),
        ];
        // Get the files (no validation on whether they are valid)
        $progFile = $this->request->getFile('progPdf');                     // for programs pdf 
        $attendanceFile = $this->request->getFile('attendancePdf');         // for attendance pdf

        // Handle program PDF upload if it exists
        if ($progFile && $progFile->isValid()) {
            $originalProgFileName = $progFile->getName();
            $progFileExtension = $progFile->getExtension();
            $newProgFileName = pathinfo($originalProgFileName, PATHINFO_FILENAME) . '.' . $progFileExtension . ' by ' . $userName;       //(. ' by ' . $userName)
            $progFile->move('public/uploads/programsPdf', $newProgFileName);
            $data['progPdf'] = $newProgFileName;  // Save the new file name in the database
        }
        // Handle attendance PDF upload if it exists
        if ($attendanceFile && $attendanceFile->isValid()) {
            $originalAttendanceFileName = $attendanceFile->getName();
            $attendanceFileExtension = $attendanceFile->getExtension();
            $newAttendanceFileName = pathinfo($originalAttendanceFileName, PATHINFO_FILENAME) . '.' . $attendanceFileExtension . ' by ' . $userName;     //(. ' by ' . $userName)
            $attendanceFile->move('public/uploads/attendancePdf', $newAttendanceFileName);
            $data['attendancePdf'] = $newAttendanceFileName;  // Save the new file name in the database
        }
        // Save data into the database
        $programModel = new ProgramModel();
        $programModel->save($data);

        // Set a success message and redirect to another page
        $session->setFlashdata('success', 'Details added successfully.');
        return redirect()->to('admin/dashboard');  // Redirect to the dashboard or another page
    }

    // delete all details function
    public function delete($prog_id = null)
    {
        // Check if the prog_id is valid
        if ($prog_id === null) {
            // Redirect with an error message if prog_id is not provided
            session()->setFlashdata('error', 'No program ID provided.');
            return redirect()->to(base_url('admin/dashboard'));
        }
        // Initialize the model
        $model = new ProgramModel();
        // Attempt to delete the record via the model
        if ($model->deleteDetails($prog_id)) {
            // Set success message
            session()->setFlashdata('success', 'Deleted details successfully.');
        } else {
            // Set error message
            session()->setFlashdata('error', 'Error deleting program. It may not exist.');
        }
        // Redirect back to the dashboard
        return redirect()->to(base_url('admin/dashboard'));
    }

    // get user details function
    public function getRecord()
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
    // update details function
    public function updateDetails()
    {
        $request = service('request');
        $id = $this->request->getPost('progid');

        // print_r($id);
        // die;
        // Collect form data
        $data = [
            'progTitle' => $request->getPost('progTitle'),
            'targetGroup' => $request->getPost('targetGroup'),
            'date' => $request->getPost('date'),
            'progDirector' => $request->getPost('progDirector'),
            'dealingAsstt' => $request->getPost('dealingAsstt'),
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
        // print_r($data);
        // die;

        $programModel = new ProgramModel();
        try {
            // Attempt to save the details in the database
            $result = $programModel->updateDetailsModel($data, $id);
            session()->setFlashdata('success', 'Update details successfully!');
        } catch (\Exception $e) {
            // Handle exceptions
            session()->setFlashdata('error', $e->getMessage());
        }

        // Redirect to the dashboard after saving
        return redirect()->to('admin/dashboard');
    }

    //  get program pdf record 
    public function getProgramRecord()
    {
        // print_r("hh");
        // die;
        $id = $this->request->getGet('prog_id');
        // echo $id;
        // die;

        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Programme ID is missing hai bhai :( ']);
        } else {
            $result = $this->programModel->getuserProgramRecord($id);
            // print_r($result);
            // die;
            echo json_encode($result);
        }
    }

    // update program files record
    public function updateProgramRecord()
    {
        $request = service('request');
        $id = $request->getPost('progid');
        $prog_pdf = $request->getFile('progPdf');

        // Get the username from the session
        $userName = session()->get('name');
        if (!$userName) {
            session()->setFlashdata('error', 'User not logged in');
            return redirect()->to('/dashboard');
        }
        // print_r($userName);
        // die;

        if ($prog_pdf && $prog_pdf->isValid()) {
            $originalProgFileName = $prog_pdf->getName();
            $progFileExtension = $prog_pdf->getExtension();
            $newProgFileName = pathinfo($originalProgFileName, PATHINFO_FILENAME) . '.' . $progFileExtension . ' by ' . $userName;       //(. ' by ' . $userName)
            $prog_pdf->move('public/uploads/programsPdf', $newProgFileName);
            $data['progPdf'] = $newProgFileName;  // Save the new file name in the database
        }
        // Ensure at least one file was successfully uploaded
        if (!isset($data['progPdf']) && !isset($data['attendancePdf'])) {
            session()->setFlashdata('error', 'Please upload valid PDF files for both Program and Attendance. sameer');
            return redirect()->to('admin/dashboard');
        }

        // Update the record in the database
        $programModel = new ProgramModel();
        try {
            $result = $programModel->updateDetailsModel($data, $id); // Ensure this method is defined in ProgramModel
            if ($result) {
                session()->setFlashdata('success', 'Details updated successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to update details. Please try again.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
        }

        // Redirect to the dashboard
        return redirect()->to('admin/dashboard');
    }

    // get attendance pdf record 
    public function getAttendanceRecord()
    {
        print_r("Sameer");
        // die;
        $id = $this->request->getGet('prog_id');
        // echo $id;
        // die;

        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Programme ID is missing hai bhai :( ']);
        } else {
            $result = $this->programModel->getuserProgramRecord($id);
            // print_r($result);
            // die;
            echo json_encode($result);
        }
    }

    public function updateAttendanceRecord()
    {
        $request = service('request');
        $id = $request->getPost('progid');
        // $prog_pdf = $request->getFile('progPdf');
        $attendancePdf = $request->getFile('attendancePdf');

        // Get the username from the session
        $userName = session()->get('name');
        if (!$userName) {
            session()->setFlashdata('error', 'User not logged in');
            return redirect()->to('/dashboard');
        }
        // print_r($userName);
        // die;


        if ($attendancePdf && $attendancePdf->isValid()) {
            $originalProgFileName = $attendancePdf->getName();
            $progFileExtension = $attendancePdf->getExtension();
            $newProgFileName = pathinfo($originalProgFileName, PATHINFO_FILENAME) . '.' . $progFileExtension . ' by ' . $userName;       //(. ' by ' . $userName)
            $attendancePdf->move('public/uploads/attendancePdf', $newProgFileName);
            $data['attendancePdf'] = $newProgFileName;
        }
        // Ensure at least one file was successfully uploaded
        if (!isset($data['progPdf']) && !isset($data['attendancePdf'])) {
            session()->setFlashdata('error', 'Please upload valid PDF files for both Program and Attendance. sameer');
            return redirect()->to('admin/dashboard');
        }

        // Update the record in the database
        $programModel = new ProgramModel();
        try {
            $result = $programModel->updateDetailsModel($data, $id); // Ensure this method is defined in ProgramModel
            if ($result) {
                session()->setFlashdata('success', 'Details updated successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to update details. Please try again.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
        }

        // Redirect to the dashboard
        return redirect()->to('admin/dashboard');
    }

    // Admin logout function
    public function logout()
    {
        $session = session();
        $session->destroy(); // Destroy session
        return redirect()->to(base_url('/')); // Redirect to login page
    }
}
