import axios from "axios";

const HTTP = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL
});

// Alter defaults after instance has been created
let AUTH_TOKEN = localStorage.getItem('token');
HTTP.defaults.headers.common['Authorization'] = `Bearer ${AUTH_TOKEN}`;

export default HTTP;
