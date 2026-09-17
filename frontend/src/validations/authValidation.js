import { regexEmail } from "../utils/regexEmail";

const registerValidation = (name, email, password, confPassword) => {
  let nameMessage = "";
  let emailMessage = "";
  let passwordMessage = "";
  let confPasswordMessage = "";
  if (!email || !password || !confPassword || !name) {
    if (!email) emailMessage = "Email is required";
    if (!password) passwordMessage = "Password is required";
    if (!confPassword) confPasswordMessage = "Confirm Password is required";
    if (!name) nameMessage = "Name is required";
    return {
      status: false,
      nameMessage,
      emailMessage,
      passwordMessage,
      confPasswordMessage,
    };
  }
  if (name.length < 3) {
    nameMessage = "Name must be at least 3 characters";
    return {
      status: false,
      nameMessage,
      emailMessage,
      passwordMessage,
      confPasswordMessage,
    };
  }
  if (!regexEmail(email)) {
    emailMessage = "Email is invalid";
    return {
      status: false,
      nameMessage,
      emailMessage,
      passwordMessage,
      confPasswordMessage,
    };
  }
  if (password.length < 8) {
    passwordMessage = "Password must be at least 8 characters";
    return {
      status: false,
      nameMessage,
      emailMessage,
      passwordMessage,
      confPasswordMessage,
    };
  }
  if (password !== confPassword) {
    confPasswordMessage = "Passwords do not match";
    return {
      status: false,
      nameMessage,
      emailMessage,
      passwordMessage,
      confPasswordMessage,
    };
  }
  return {
    status: true,
    nameMessage,
    emailMessage,
    passwordMessage,
    confPasswordMessage,
  };
};

const loginValidation = (email, password) => {
  let emailMessage = "";
  let passwordMessage = "";
  if (!email || !password) {
    if (!email) emailMessage = "Email is required";
    if (!password) passwordMessage = "Password is required";
    return {
      status: false,
      emailMessage,
      passwordMessage,
    };
  }
  if (!regexEmail(email)) {
    emailMessage = "Email is invalid";
    return {
      status: false,
      emailMessage,
      passwordMessage,
    };
  }
  if (password.length < 8) {
    passwordMessage = "Password must be at least 8 characters";
    return {
      status: false,
      emailMessage,
      passwordMessage,
    };
  }
  return {
    status: true,
    emailMessage,
    passwordMessage,
  };
};


export { registerValidation, loginValidation };
