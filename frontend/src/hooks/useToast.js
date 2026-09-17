const { ref } = require("vue");

const show = ref(false);
const title = ref("");
const type = ref("");
const message = ref("");

export function useToast() {
  function showToast(options) {
    title.value = options.title || "";
    type.value = options.type || "success";
    message.value = options.message || "";
    show.value = true;

    setTimeout(() => {
      show.value = false;
    }, 3000);
  }

  return {
    show,
    title,
    type,
    message,
    showToast,
  };
}
