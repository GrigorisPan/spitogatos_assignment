<?php

namespace App\Controllers;

use Framework\Authorization;
use Framework\Database;
use Framework\Session;
use Framework\Validation;



class ListingsController
{

  protected $db;

  public function __construct()
  {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }

  /**
   * Store in database
   *
   * @return void
   */
  public function store()
  {

    $allowedFields = ['price', 'location', 'availability', 'area'];

    $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

    if (Session::has('user')) {
      $newListingData['user_id'] = Session::get('user')['id'];

      $newListingData = array_map('sanitize', $newListingData);

      $requiredFields = ['price', 'location', 'availability', 'area'];

      foreach ($requiredFields as $field) {

        if (empty($newListingData[$field])) {
          $errors['empty'] = '<div class="message bg-red-100 p-3 my-3">Συμπλήρωσε όλα τα πεδία</div>';
        } else {
          if ($field === 'price' && !Validation::price($newListingData[$field], 50, 500000)) {
            $errors[$field] = '<div class="message bg-red-100 p-3 my-1">Βάλε μια αποδεκτή τίμη</div>';
          }
          if ($field === 'location' && !Validation::location($newListingData[$field])) {
            $errors[$field] = '<div class="message bg-red-100 p-3 my-1">Επίλεξε μια πόλη από τις διαθέσιμες</div>';
          }
          if ($field === 'availability' && !Validation::availability($newListingData[$field], 50, 500000)) {
            $errors[$field] = '<div class="message bg-red-100 p-3 my-1">Επίλεξε διαθεσιμότητα από τις επιλογές</div>';
          }
          if ($field === 'area' && !Validation::area($newListingData[$field], 20, 1000)) {
            $errors[$field] = '<div class="message bg-red-100 p-3 my-1">Βάλε αποδεκτά τ.μ.</div>';
          }
        }
      }
    } else {
      $errors['user'] = '<div class="message bg-red-100 p-3 my-1">Προέκυψε σφάλμα</div>';
    }

    if (!empty($errors)) {
      //Reload view with errors
      foreach ($errors as $error) {
        echo $error;
      }
    } else {
      //Submit data
      $fields = [];

      foreach ($newListingData as $field => $value) {
        $fields[] = $field;
      }

      $fields = implode(', ', $fields);

      $values = [];

      foreach ($newListingData as $field => $value) {
        // Convert empty strings to null
        if ($value === '') {
          $newListingData[$field] = null;
        }
        $values[] = ':' . $field;
      }

      $values = implode(', ', $values);

      $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";

      $this->db->query($query, $newListingData);

      $lastId =  $this->db->lastInsertId();

      $params = [
        'id' => $lastId,
      ];

      $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

      echo 'success' . '#' . '<div id=' . "'" . $listing->id . "'" . 'class="my-2 lg:w-7/12 rounded-lg shadow-md bg-white ">
      <div class=" flex p-3 ">
        <ul class="flex bg-gray-100 p-4 rounded ">
          <li>' . $listing->location . ',' . '</li>
          <li>' . $listing->availability . ',' . '</li>
          <li>' . $listing->price .  ' ευρώ' . ',' . '</li>
          <li>' . $listing->area . 'τμ' . '</li>
        </ul>
        <button id="deleteData" class="px-2 py-0 border-2 border-brightRed hover:bg-brightRed text-brightRed hover:text-white rounded">
          Delete
        </button>
      </div>
    </div>' . '#' . '<div class="message bg-green-100 p-3 my-3">Επιτυχής δημιουργία</div>';
    }
  }

  /**
   * Delete a listing
   * 
   * @return void
   */

  public function destroy()
  {
    $id = $_POST['id'] ?? '';

    $params = [
      'id' => $id,
    ];

    $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

    // Check if listing exists 
    //Authorization
    if (empty($listing) || !Authorization::isOwner($listing->user_id)) {
      echo  $response = '<div class="message bg-red-100 p-3 my-3">Αδυναμία διαγραφής</div>';
      return;
    }

    $this->db->query('DELETE FROM listings WHERE id = :id', $params);

    //Set flash message
    $response = 'success';
    echo $response;
  }
}
