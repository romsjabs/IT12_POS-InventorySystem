// user modal
document.addEventListener('DOMContentLoaded', function () {
    var userInfoModal = document.getElementById('userInfoModal');
    userInfoModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('modal-user-id').textContent = button.getAttribute('data-id') || '';
        document.getElementById('modal-username').textContent = button.getAttribute('data-username') || '';
        document.getElementById('modal-email').textContent = button.getAttribute('data-email') || '';
        document.getElementById('modal-role').textContent = button.getAttribute('data-role') || '';
        document.getElementById('modal-created').textContent = button.getAttribute('data-created') || '';
        document.getElementById('modal-lastname').textContent = button.getAttribute('data-lastname') || '';
        document.getElementById('modal-firstname').textContent = button.getAttribute('data-firstname') || '';
        document.getElementById('modal-middlename').textContent = button.getAttribute('data-middlename') || '';
        document.getElementById('modal-extension').textContent = button.getAttribute('data-extension') || '';
        document.getElementById('modal-gender').textContent = button.getAttribute('data-gender') || '';
        document.getElementById('modal-birthdate').textContent = button.getAttribute('data-birthdate') || '';
    });
});