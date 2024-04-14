const btn_create = document.getElementById('createData');

btn_create.addEventListener('click', (e) => {
  e.preventDefault();

  let price = document.getElementById('price').value;
  let location = document.getElementById('location').value;
  let availability = document.getElementById('availability').value;
  let area = document.getElementById('area').value;
  const collection = document.getElementById('collection');
  const createForm = document.getElementById('createForm');
  var formData = new FormData();
  formData.append('price', price);
  formData.append('location', location);
  formData.append('availability', availability);
  formData.append('area', area);
  fetch('/listings', { method: 'POST', body: formData })
    .then((response) => response.text())
    .then((response) => {
      array_response = response.split('#');
      if (array_response[0] === 'success') {
        collection.insertAdjacentHTML('afterbegin', array_response[1]);
        document.getElementById('form-message').innerHTML = `
        ${array_response[2]}`;
        createForm.reset();
      } else {
        document.getElementById('form-message').innerHTML = `
        ${response}`;
      }
      formTimeout = setTimeout(() => {
        document.getElementById('form-message').innerHTML = '';
        clearTimeout(formTimeout);
      }, 2000);
    });
});

const collection = document.getElementById('collection');
collection.addEventListener('click', removeListing);

function removeListing(e) {
  if (e.target.id === 'deleteData') {
    id = e.target.parentElement.parentElement.id;
    var formData = new FormData();
    formData.append('id', id);
    fetch('/listings/delete', { method: 'POST', body: formData })
      .then((response) => response.text())
      .then((response) => {
        if (response === 'success') {
          document.getElementById('delete-message').innerHTML =
            '<div class="message bg-green-100 p-3 my-3">Επιτυχής διαγραφής</div>';
          deletedListiing = document.getElementById(id);
          deletedListiing.remove();
        } else {
          document.getElementById('delete-message').innerHTML = response;
        }
        deleteTimeout = setTimeout(() => {
          document.getElementById('delete-message').innerHTML = '';
          clearTimeout(deleteTimeout);
        }, 2000);
      });
  }
}
