

/* =================================
   نظام بلاغات أعطال الكهرباء
   تسجيل الدخول وإنشاء الحساب
================================= */

// قراءة الحسابات المحفوظة
function getUsers() {
    return JSON.parse(localStorage.getItem("users")) || [];
}

// حفظ الحسابات
function saveUsers(users) {
    localStorage.setItem("users", JSON.stringify(users));
}

// عرض الرسائل للمستخدم
function showMessage(message, color) {
    let messageBox = document.getElementById("message");

    if (messageBox) {
        messageBox.textContent = message;
        messageBox.style.color = color;
    } else {
        alert(message);
    }
}

// =================================
// أولاً: إنشاء حساب جديد
// =================================

const registerForm = document.getElementById("registerForm");

if (registerForm) {

    registerForm.addEventListener("submit", function(event) {

        event.preventDefault();

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim().toLowerCase();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        // التحقق من الحقول
        if (!name || !email || !password || !confirmPassword) {
            showMessage("يرجى ملء جميع الحقول", "red");
            return;
        }

        // التحقق من طول كلمة المرور
        if (password.length < 6) {
            showMessage("كلمة المرور يجب ألا تقل عن 6 أحرف", "red");
            return;
        }

        // التأكد من تطابق كلمتي المرور
        if (password !== confirmPassword) {
            showMessage("كلمتا المرور غير متطابقتين", "red");
            return;
        }

        // قراءة الحسابات السابقة
        let users = getUsers();

        // منع تكرار البريد الإلكتروني
        const existingUser = users.find(user => user.email === email);

        if (existingUser) {
            showMessage("هذا البريد الإلكتروني مسجل مسبقاً", "red");
            return;
        }

        // إنشاء الحساب
        const newUser = {
            name: name,
            email: email,
            password: password
        };

        users.push(newUser);

        // حفظ الحساب
        saveUsers(users);

        showMessage("تم إنشاء الحساب بنجاح، سيتم تحويلك لتسجيل الدخول", "green");

        registerForm.reset();

        // الانتقال إلى تسجيل الدخول
        setTimeout(function() {
            window.location.href = "index.html";
        }, 1800);

    });
}


// =================================
// ثانياً: تسجيل الدخول
// =================================

const loginForm = document.getElementById("loginForm");

if (loginForm) {

    loginForm.addEventListener("submit", function(event) {

        event.preventDefault();

        const email = document.getElementById("email").value.trim().toLowerCase();
        const password = document.getElementById("password").value;

        // التحقق من إدخال البيانات
        if (!email || !password) {
            showMessage("يرجى إدخال البريد الإلكتروني وكلمة المرور", "red");
            return;
        }

        // البحث عن الحساب
        const users = getUsers();

        const foundUser = users.find(function(user) {
            return user.email === email && user.password === password;
        });

        if (foundUser) {

            // حفظ بيانات المستخدم الحالي
            localStorage.setItem("currentUser", JSON.stringify({
                name: foundUser.name,
                email: foundUser.email
            }));

            showMessage("تم تسجيل الدخول بنجاح", "green");

            // الانتقال إلى لوحة المستخدم
            setTimeout(function() {
                window.location.href = "dashboard.html";
            }, 1000);

        } else {

            showMessage("البريد الإلكتروني أو كلمة المرور غير صحيحة", "red");

        }

    });
}


// =================================
// ثالثاً: تسجيل الخروج
// =================================

const logoutButtons = document.querySelectorAll(".logout-button");

logoutButtons.forEach(function(button) {

    button.addEventListener("click", function() {

        const confirmLogout = confirm("هل تريد تسجيل الخروج؟");

        if (confirmLogout) {
            localStorage.removeItem("currentUser");
            window.location.href = "index.html";
        }

    });

});


// =================================
// رابعاً: إظهار وإخفاء كلمة المرور
// =================================

const showPassword = document.getElementById("showPassword");
const passwordField = document.getElementById("password");

if (showPassword && passwordField) {

    showPassword.addEventListener("change", function() {
        passwordField.type = this.checked ? "text" : "password";
    });

}
