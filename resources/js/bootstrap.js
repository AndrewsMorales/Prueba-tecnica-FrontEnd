import axios from 'axios';
window.axios = axios;
console.log('andres');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
