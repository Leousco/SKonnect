// Age auto-calculate
const birthInput = document.getElementById("birth_date");
const ageValue = document.getElementById("ageValue");
const ageUnit = document.getElementById("ageUnit");
const ageHidden = document.getElementById("age");

birthInput.addEventListener("change", function () {
  const today = new Date();
  const birth = new Date(this.value);

  if (isNaN(birth)) {
    ageValue.textContent = "—";
    ageUnit.textContent = "";
    ageHidden.value = ""; 
    return;
  }

  let age = today.getFullYear() - birth.getFullYear();
  const m = today.getMonth() - birth.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;

  if (age >= 0) {
    ageValue.textContent = age;
    ageUnit.textContent = age === 1 ? "yr old" : "yrs old";
    ageHidden.value = age; 
  } else {
    ageValue.textContent = "—";
    ageUnit.textContent = "";
    ageHidden.value = "";
  }
});

// Password toggle
document.querySelectorAll(".toggle-pw").forEach((btn) => {
  btn.addEventListener("click", function () {
      const target = document.getElementById(this.dataset.target);
      const icon = this.querySelector("i");
      target.type = target.type === "password" ? "text" : "password";
      icon.classList.toggle("fa-eye");
      icon.classList.toggle("fa-eye-slash");
  });
});

// Password match indicator
const pw = document.getElementById("password");
const cpw = document.getElementById("confirm_password");
const msg = document.getElementById("pwMatchMsg");

function checkMatch() {
  if (!cpw.value) {
    msg.textContent = "";
    msg.className = "pw-match-msg";
    return;
  }
  if (pw.value === cpw.value) {
    msg.textContent = "✓ Passwords match";
    msg.className = "pw-match-msg match";
  } else {
    msg.textContent = "✗ Passwords do not match";
    msg.className = "pw-match-msg no-match";
  }
}

pw.addEventListener("input", checkMatch);
cpw.addEventListener("input", checkMatch);
