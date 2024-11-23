import axios from "axios";


export const SetCsrf = () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    
     if (csrfToken) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    } else {
        console.warn('CSRF token not found.');
    }
}