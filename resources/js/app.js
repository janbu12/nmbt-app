import './bootstrap';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Swal = Swal;

window.Alpine = Alpine;

Alpine.start();

function formatDate(dateString) {
    const date = new Date(dateString); // Konversi string ke objek Date
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Tambahkan leading zero
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

window.formatDate = formatDate;
