<?php loadPartial('head'); ?>
<?php loadPartial('navbar'); ?>

<!-- Registration Form Box -->
<div class="container mx-auto">
  <div class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-1/2 mx-6">
      <h2 class="text-4xl text-center font-bold mb-4">Εγγραφή</h2>

      <form method="POST" action="/auth/register">
        <?php loadPartial('errors', [
          'errors' => $errors ?? []
        ]) ?>
        <div class="mb-4">
          <input type="text" name="name" placeholder="Όνομα χρήστη" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $user['name'] ?? '' ?>" />
        </div>
        <div class="mb-4">
          <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= $user['email'] ?? '' ?>" />
        </div>
        <div class="mb-4">
          <input type="password" name="password" placeholder="Κωδικός" class="w-full px-4 py-2 border rounded focus:outline-none" />
        </div>
        <div class="mb-4">
          <input type="password" name="password_confirmation" placeholder="Επιβεβαίωση κωδικού" class="w-full px-4 py-2 border rounded focus:outline-none" />
        </div>
        <button type="submit" class="w-full bg-brightRedLight hover:bg-brightRed text-white px-4 py-2 rounded focus:outline-none">
          Εγγραφή
        </button>

        <p class="mt-4 text-gray-500">
          'Εχετε λογαριασμό;
          <a class="text-brightRed" href="/auth/login">Είσοδο</a>
        </p>
      </form>
    </div>
  </div>
</div>

<?php loadPartial('footer') ?>