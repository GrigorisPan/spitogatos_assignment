<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;

class HomeController
{
  protected $db;

  public function __construct()
  {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }

  /*
   * Show the homepage
   *
   * @return void
   */
  public function index()
  {

    $listings = [];
    $id =  Session::has('user') ? Session::get('user')['id'] : '';

    $queryParams = [
      'id' => $id
    ];

    $listings = $this->db->query('SELECT * FROM listings WHERE user_id = :id ORDER BY created_at DESC', $queryParams)->fetchAll();

    loadView('home', [
      'listings' => $listings
    ]);
  }
}
