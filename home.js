
"use strict";

/* =================================
   1. التحقق من نموذج تسجيل الدخول
================================= */

const loginForm = document.querySelector("#loginForm");

if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
        const email = document.querySelector("#email");
        const password = document.querySelector("#password");

        if (!email.value.trim() || !password.value.trim()) {
            event.preventDefault();
            alert("يرجى إدخال البريد الإلكتروني وكلمة المرور");
            return;
        }

        if (!email.checkValidity()) {
            event.preventDefault();
            alert("يرجى إدخال بريد إلكتروني صحيح");
        }
    });
}


/* =================================
   2. التحقق من نموذج تقديم البلاغ
================================= */

const reportForm = document.querySelector("#reportForm");

if (reportForm) {
    reportForm.addEventListener("submit", function (event) {
        const area = document.querySelector("#area");
        const type = document.querySelector("#type");
        const details = document.querySelector("#details");

        if (
            !area.value.trim() ||
            !type.value ||
            !details.value.trim()
        ) {
            event.preventDefault();
            alert("يرجى تعبئة جميع بيانات البلاغ");
            return;
        }

        if (details.value.trim().length < 10) {
            event.preventDefault();
            alert("يرجى كتابة تفاصيل أوضح عن العطل");
        }
    });
}


/* =================================
   3. التحقق من نموذج التواصل معنا
================================= */

const contactForm = document.querySelector("#contactForm");

if (contactForm) {
    contactForm.addEventListener("submit", function (event) {
        const name = document.querySelector("#name");
        const email = document.querySelector("#email");
        const comment = document.querySelector("#comment");

        if (
            !name.value.trim() ||
            !email.value.trim() ||
            !comment.value.trim()
        ) {
            event.preventDefault();
            alert("يرجى تعبئة جميع الحقول");
            return;
        }

        if (!email.checkValidity()) {
            event.preventDefault();
            alert("البريد الإلكتروني غير صحيح");
            return;
        }

        if (comment.value.trim().length < 5) {
            event.preventDefault();
            alert("يرجى كتابة رسالة واضحة");
        }
    });
}


/* =================================
   4. زر الرجوع للصفحة السابقة
================================= */

const backButtons = document.querySelectorAll(".back-button");

backButtons.forEach(function (button) {
    button.addEventListener("click", function () {
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = "index.html";
        }
    });
});


/* =================================
   5. تأكيد تسجيل الخروج
================================= */

const logoutButtons = document.querySelectorAll(".logout-button");

logoutButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        const confirmLogout = confirm(
            "هل أنت متأكد أنك تريد الخروج من حسابك؟"
        );

        if (!confirmLogout) {
            event.preventDefault();
        }
    });
});


/* =================================
   6. إظهار وإخفاء كلمة المرور
================================= */

const passwordField = document.querySelector("#password");
const showPassword = document.querySelector("#showPassword");

if (passwordField && showPassword) {
    showPassword.addEventListener("click", function () {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            showPassword.textContent = "إخفاء كلمة المرور";
        } else {
            passwordField.type = "password";
            showPassword.textContent = "إظهار كلمة المرور";
        }
    });
}


/* =================================
   7. رسالة ترحيب في صفحة الخدمات
================================= */

const welcomeMessage = document.querySelector("#welcomeMessage");

if (welcomeMessage) {
    welcomeMessage.textContent =
        "مرحباً بك في نظام بلاغات أعطال الكهرباء ⚡";
}


/* =================================
   8. تأكيد إرسال النماذج
================================= */

document.querySelectorAll("form").forEach(function (form) {
    form.addEventListener("submit", function () {
        if (!form.checkValidity()) {
            form.reportValidity();
        }
    });
});