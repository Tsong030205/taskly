document.addEventListener("DOMContentLoaded", function () {
  // Auto-dismiss flash messages
  initFlashMessages();

  // Delete confirmations
  initDeleteConfirmations();

  // Mobile menu
  initMobileMenu();

  // Form validation
  initFormValidation();

  // Password strength
  initPasswordStrength();

  // Due date validation
  initDueDateValidation();

  // Task completion toggle
  initTaskToggle();
});

// Fonctions d'initialisation
function initFlashMessages() {
  const flashMessages = document.querySelectorAll(".alert");
  flashMessages.forEach((message) => {
    setTimeout(() => {
      message.style.opacity = "0";
      setTimeout(() => message.remove(), 300);
    }, 5000);
  });
}

function initDeleteConfirmations() {
  const deleteButtons = document.querySelectorAll(
    'a[href*="delete"], .btn-delete'
  );
  deleteButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      if (!confirm("Êtes-vous sûr de vouloir supprimer cet élément ?")) {
        e.preventDefault();
      }
    });
  });
}

function initMobileMenu() {
  const mobileMenuButton = document.getElementById("mobileMenuButton");
  const navMenu = document.getElementById("navMenu");

  if (mobileMenuButton && navMenu) {
    mobileMenuButton.addEventListener("click", () =>
      toggleMobileMenu(navMenu, mobileMenuButton)
    );
    initMobileMenuLinks(navMenu, mobileMenuButton);
    initOutsideClickHandler(navMenu, mobileMenuButton);
    initEscapeKeyHandler(navMenu, mobileMenuButton);
  }
}

function initFormValidation() {
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.addEventListener("submit", handleFormSubmit);
  });

  // Real-time validation
  const inputs = document.querySelectorAll("input, textarea, select");
  inputs.forEach((input) => {
    input.addEventListener("blur", handleInputValidation);
  });
}

function initTaskToggle() {
  document.querySelectorAll(".btn-toggle").forEach((button) => {
    button.addEventListener("click", handleTaskToggle);
  });
}

// Gardez les fonctions existantes calculatePasswordStrength et updatePasswordStrengthIndicator
function calculatePasswordStrength(password) {
  let strength = 0;

  if (password.length >= 8) strength++;
  if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
  if (password.match(/\d/)) strength++;
  if (password.match(/[^a-zA-Z\d]/)) strength++;

  return strength;
}

function updatePasswordStrengthIndicator(field, strength) {
  let existingIndicator = field.parentNode.querySelector(".password-strength");

  if (!existingIndicator) {
    existingIndicator = document.createElement("div");
    existingIndicator.className = "password-strength";
    field.parentNode.appendChild(existingIndicator);
  }

  const strengthLabels = [
    "Très faible",
    "Faible",
    "Moyen",
    "Fort",
    "Très fort",
  ];
  const strengthColors = [
    "#ef4444",
    "#f97316",
    "#eab308",
    "#84cc16",
    "#22c55e",
  ];

  existingIndicator.innerHTML = `
        <div class="strength-bar">
            <div class="strength-fill" style="width: ${
              strength * 25
            }%; background-color: ${strengthColors[strength]}"></div>
        </div>
        <span class="strength-text">Force: ${strengthLabels[strength]}</span>
    `;
}

// Ajoutez les nouvelles fonctions d'aide
function toggleMobileMenu(navMenu, button) {
  navMenu.classList.toggle("active");
  button.classList.toggle("active");
  document.body.style.overflow = navMenu.classList.contains("active")
    ? "hidden"
    : "";
}

function handleFormSubmit(e) {
  let isValid = true;
  const requiredFields = this.querySelectorAll("[required]");

  requiredFields.forEach((field) => {
    if (!field.value.trim()) {
      isValid = false;
      field.classList.add("error");

      if (!field.nextElementSibling?.classList.contains("error-message")) {
        const errorMessage = document.createElement("span");
        errorMessage.className = "error-message";
        errorMessage.textContent = "Ce champ est obligatoire";
        field.parentNode.appendChild(errorMessage);
      }
    } else {
      field.classList.remove("error");
      const existingError = field.parentNode.querySelector(".error-message");
      existingError?.remove();
    }
  });

  if (!isValid) {
    e.preventDefault();
    const firstError = this.querySelector(".error");
    firstError?.scrollIntoView({ behavior: "smooth", block: "center" });
  }
}

function handleTaskToggle() {
  const taskId = this.getAttribute("data-task-id");
  const taskCard = this.closest(".task-card");
  const originalText = this.textContent;

  this.innerHTML = "⏳";
  this.disabled = true;

  fetch(`/taskly/tasks/toggle/${taskId}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => handleTaskToggleSuccess(data, taskCard, this))
    .catch((error) => handleTaskToggleError(error, this, originalText))
    .finally(() => {
      this.disabled = false;
    });
}
