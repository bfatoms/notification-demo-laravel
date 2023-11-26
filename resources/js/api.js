import axios from 'axios';

const api = axios.create({
  baseURL: '/api', // Adjust the base URL based on your Laravel API endpoint
});

export default api;
