import instance from "../../utils/customizeAxios";

const loginAPI = (email, password) => {
  const data = {
    email,
    password,
  };

  return instance.post("auth/login", data);
};

const registerAPI = (email, password, name) => {
  const data = {
    email,
    password,
    name,
  };

  return instance.post("auth/register", data);
};

const refreshTokenAPI = () => {
  return instance.post("auth/refresh");
};

const logoutAPI = () => {
  return instance.post("auth/logout");
};

const meAPI = () => {
  return instance.post("auth/me");
};

export { loginAPI, registerAPI, refreshTokenAPI, logoutAPI, meAPI };
