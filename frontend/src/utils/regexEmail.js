const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

export const regexEmail = (email) => {
  if (!email) {
    return false;
  }
  if (!emailRegex.test(email)) {
    return false;
  }
  return true;
};
