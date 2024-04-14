<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Framework\Validation;

class UserController
{

  protected $db;

  public function __construct()
  {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }

  /**
   * Show the login page
   * 
   * @return void
   */
  public function login()
  {
    loadView('users/login');
  }

  /**
   * Show the register page
   * 
   * @return void
   */
  public function create()
  {
    loadView('users/create');
  }

  /**
   * Store user in database
   * 
   * @return void
   */
  public function store()
  {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];

    $errors = [];

    //Validation
    if (!Validation::email($email)) {
      $errors['email'] = 'Παρακαλώ βάλε ένα έγκυρο email';
    };

    if (!Validation::string($name, 2, 50)) {
      $errors['name'] = 'To όνομα πρέπει να περιέχει 2 εώς 50 χαρακτήρες';
    }

    if (!Validation::string($password, 6, 50)) {
      $errors['password'] = 'Ο κωδικός πρέπει να περίεχει τουλάχιστον έξι χαρακτήρες';
    }

    if (!Validation::match($password, $password_confirmation)) {
      $errors['password_confirmation'] = 'Οι κωδικοί δεν ταιρίαζουν';
    }

    if (!empty($errors)) {
      loadView('users/create', [
        'errors' => $errors,
        'user' => [
          'name' => $name,
          'email' => $email,
        ]
      ]);
      exit;
    }

    //Check if email exists
    $params = [
      'email' => $email
    ];

    $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

    if ($user) {
      $errors['email'] = 'Το email αυτό χρησιμοποιείται ήδη';
      loadView('users/create', [
        'errors' => $errors,
        'user' => [
          'name' => $name,
          'email' => $email,
        ]
      ]);
      exit;
    }

    //Create user account
    $params = [
      'name' => $name,
      'email' => $email,
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ];

    $this->db->query("INSERT INTO users ( name, email, password ) VALUES ( :name, :email, :password )", $params);

    //Get new user ID 
    $userId = $this->db->conn->lastInsertId();

    Session::set('user', [
      'id' => $userId,
      'name' => $name,
      'email' => $email,
    ]);

    redirect('/');
  }

  /**
   * Logout a user and kill session
   * 
   *@return void
   */
  public static function logout()
  {
    Session::clearAll();

    $params = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

    redirect('/');
  }

  /**
   * Authenticate a user with email and password
   * 
   * @return void
   */
  public function authenticate()
  {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [];

    //Validation
    if (!Validation::email($email)) {
      $errors['email'] = 'Παρακαλώ βάλε ένα έγκυρο email';
    }

    if (!Validation::string($password, 6, 50)) {
      $errors['password'] = 'Ο κωδικός πρέπει να περίεχει τουλάχιστον έξι χαρακτήρες';
    }

    if (!empty($errors)) {
      loadView('users/login', [
        'errors' => $errors
      ]);
      exit;
    }

    //Check for email
    $params = [
      'email' => $email
    ];

    $user = $this->db->query('SELECT * FROM users WHERE email=:email', $params)->fetch();

    if (!$user) {
      $errors['email'] = 'Στοιχεία μη έγκυρα';
      loadView('users/login', [
        'errors' => $errors
      ]);
      exit;
    }

    //Check if password is correct
    if (!password_verify($password, $user->password)) {
      $errors['password'] = 'Στοιχεία μη έγκυρα';
      loadView('users/login', [
        'errors' => $errors
      ]);
      exit;
    }

    //Set user session
    Session::set('user', [
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
    ]);

    redirect('/');
  }
}
