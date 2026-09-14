import axios from "axios";
import Cookies from 'js-cookie';

const instance = axios.create({
  baseURL: import.meta.env.VITE_BASE_API || "",
  timeout: 10000,
  headers: {
    "Content-Type": "application/json",
  },
});

instance.interceptors.request.use(function (config) {
  // Do something before request is sent
  const token = Cookies.get('access_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, function (error) {
  // Do something with request error
  return Promise.reject(error);
});

export default instance;