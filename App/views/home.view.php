<?php

use Framework\Session; ?>
<?php loadPartial('head'); ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('top-banner', [
  'bannerContent' => 'ΑΓΓΕΛΙΕΣ ΣΠΙΤΙΩΝ'
]); ?>


<section>
  <div class="container-xl p-4 mt-4" style="min-height:50vh; max-height:auto;">
    <div class="grid grid-cols-12 	">

      <div class="col-span-12 md:col-span-5 mx-4">
        <h2 class="text-xl font-bold mb-2 text-gray-500">
          Καταχώρισε την αγγελίας σου
        </h2>
        <?php if (!Session::has('user')) : ?>
          <p class="text-gray-700 text-xl font-bold m-2 ">Συνδέσου για να κταχωρίσεις την αγγελλία σου.
          <?php endif; ?>
          <!-- Insert form -->
          <?php if (Session::has('user')) : ?>
          <form id='createForm' method="POST" action="/">

            <div class="text-md font-bold mb-2 text-gray-500 " id='form-message'>
            </div>
            <?php loadPartial('errors', [
              'errors' => $errors ?? []
            ]) ?>
            <div class="mb-4">
              <div class="flex items-center ">
                <label class="mr-2 text-gray-700 text-xl font-bold mb-2" for="price">
                  Τιμή:
                </label>
                <input type="text" id="price" name="price" placeholder="50 - 5000000" class="px-3 py-1 border rounded focus:outline-none" />
              </div>
              <p class="text-gray-600 text-xs italic">Βάλε μια τιμή από 50 έως 5000000 ευρώ</p>
            </div>
            <div class="mb-4">
              <div class="flex items-center ">
                <label class="mr-2 text-gray-700 text-xl font-bold mb-2" for="location">
                  Περιοχή:
                </label>
                <select id="location" class="px-3 py-1 border rounded focus:outline-none">
                  <option selected value="">Επίλεξε περιοχή:</option>
                  <option value="Αθήνα">Αθήνα</option>
                  <option value="Θεσσαλονίκη">Θεσσαλονίκη</option>
                  <option value="Πάτρα">Πάτρα</option>
                  <option value="Ηράκλειο">Ηράκλειο</option>
                </select>
              </div>
            </div>
            <div class="mb-4">
              <div class="flex items-center ">
                <label class="mr-2 text-gray-700 text-xl font-bold mb-2" for="availability">
                  Διαθεσιμότητα:
                </label>
                <select id="availability" class="px-3 py-1 border rounded focus:outline-none">
                  <option selected value="">Επίλεξε διαθεσιμότητα:</option>
                  <option value="ενοικίαση">ενοικίαση</option>
                  <option value="πώληση">πώληση</option>
                </select>
              </div>
            </div>
            <div class="mb-4">
              <div class="flex items-center ">
                <label class="mr-2 text-gray-700 text-xl font-bold mb-2" for="area">
                  Τετραγωνικά:
                </label>
                <input type="text" id="area" name="price" placeholder="20 - 1000" class="px-3 py-1 border rounded focus:outline-none" value="" />
              </div>
              <p class="text-gray-600 text-xs italic">Βάλε μια τιμή από 20 τ.μ. έως 1000 τ.μ</p>
            </div>
            <button type='submit' id='createData' class="w-6/12 border-2 border-darkBlue hover:bg-darkBlue text-darkBlue hover:text-white rounded px-4 py-2 my-3 focus:outline-none">
              Kαταχώριση
            </button>
          </form>
        <?php endif; ?>
      </div>
      <div class="col-span-12 md:col-span-7  mx-4">
        <h2 class="underline text-xl font-bold mb-6r text-gray-500">
          Λίστα αγγελιών
        </h2>
        <div class="text-md font-bold mb-6 text-gray-500 " id='delete-message'>
        </div>
        <?php loadPartial('message') ?>
        <?php if (Session::has('user')) : ?>
          <div id='collection'>
            <?php foreach ($listings as $listing) : ?>
              <!-- House Listings -->
              <div id='<?= $listing->id ?>' class="my-2 lg:w-7/12 rounded-lg shadow-md bg-white ">
                <div class=" flex p-3 ">
                  <ul class="flex bg-gray-100 p-4 rounded ">
                    <li> <?= $listing->location . ',' ?></li>
                    <li> <?= $listing->availability . ',' ?></li>
                    <li> <?= $listing->price . ' ευρώ' . ',' ?></li>
                    <li>
                      <?= $listing->area . 'τμ' ?>
                    </li>

                  </ul>
                  <button id='deleteData' class="px-2 py-0 border-2 border-brightRed hover:bg-brightRed text-brightRed hover:text-white rounded">
                    Delete
                  </button>
                </div>
              </div>
              </form>
            <?php endforeach; ?>
          </div>

        <?php endif; ?>
        <?php if (!Session::has('user')) : ?>
          <p class="text-gray-700 text-xl font-bold m-2">Συνδέσου για να δεις τις αγγελλίες σου.</br> Αν δεν διαθέτεις λογαριασμό κάνε εγγραφή.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php loadPartial('footer') ?>