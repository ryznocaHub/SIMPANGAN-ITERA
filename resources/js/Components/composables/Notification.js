// import { inject } from 'vue'
// const swal = inject('$swal')
import Swal from 'sweetalert2'

export default function () {
    function Notification(icon, title) {
        const color = {
            'success'   : '#89B77D',
            'error'     : '#F87272',
            'warning'   : '#EEE8A9',
            'info'      : '#8CAFCE'
        }

        Swal.fire({
            icon: icon,
            title: title,
            customClass: {
                popup: 'colored-toast'
            },
            iconColor: color[icon],
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }

    return  Notification 
}
