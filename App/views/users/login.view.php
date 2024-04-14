<?php loadPartial('head'); ?>
<?php loadPartial('navbar'); ?>
<!-- Login Form Box -->
<div class="container mx-auto">
  <div class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-1/2 mx-6">
      <h2 class="text-4xl text-center font-bold mb-4">Είσοδο</h2>
      <?php loadPartial('errors', [
        'errors' => $errors ?? []
      ]) ?>
      <form method="POST" action="/auth/login">
        <div class="mb-4">
          <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 border rounded focus:outline-none" />
        </div>
        <div class="mb-4">
          <input type="password" name="password" placeholder="Κωδικός " class="w-full px-4 py-2 border rounded focus:outline-none" />
        </div>
        <button type="submit" class="w-full bg-brightRedLight hover:bg-brightRed text-white px-4 py-2 rounded focus:outline-none">
          Είσοδο
        </button>

        <p class="mt-4 text-gray-500">
          Δεν έχετε ακόμη λογαριασμό;
          <a class="text-brightRed" href="/auth/register">Εγγραφή</a>
        </p>
      </form>
    </div>
  </div>
</div>

<?php loadPartial('footer') ?>