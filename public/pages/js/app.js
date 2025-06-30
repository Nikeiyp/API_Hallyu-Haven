// =================== KODE FINAL UNTUK app.js ===================

console.log('App JS loaded and ready.');

// --- Pengaturan Global ---
const baseUrl = window.location.origin + '/';

// --- Instance Axios untuk request yang butuh otentikasi (token) ---
const apiClient = axios.create({
    baseURL: baseUrl,
    headers: {
        'Content-Type': 'application/json',
    }
});

apiClient.interceptors.request.use(config => {
    const token = getToken();
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

// --- Fungsi untuk mengelola Cookie & Token ---
function getToken() {
    return getCookie('ut') || localStorage.getItem('token');
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

function setAuthData(token, email) {
    const cookieOptions = `path=/; SameSite=Lax`;
    document.cookie = `ut=${token}; ${cookieOptions}`;
    if (email) {
        document.cookie = `ue=${email}; ${cookieOptions}`;
    }
    localStorage.setItem('token', token);
}

function clearAuthData() {
    const pastDate = 'Thu, 01 Jan 1970 00:00:01 GMT';
    document.cookie = `ut=; path=/; SameSite=Lax; expires=${pastDate};`;
    document.cookie = `ue=; path=/; SameSite=Lax; expires=${pastDate};`;
    localStorage.removeItem('token');
}

// --- Fungsi Notifikasi & Redirect ---
function showNotification(icon, title, timer = 1500) {
    Swal.fire({
        position: "top-end",
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: timer
    });
}

function redirectToHome(delay = 1500) {
    setTimeout(() => {
        window.location.href = baseUrl;
    }, delay);
}

// --- Fungsi untuk menangani Error dari API ---
function handleApiError(error, formType) {
    console.error(`[${formType.toUpperCase()} ERROR]`, error.response || error);
    const errorContainer = `#form-${formType}-error`;
    const loadingContainer = `#form-${formType}-loading`;
    const formContainer = `#form-${formType}`;

    let message = 'Terjadi kesalahan. Silakan coba lagi.';
    if (error.response?.data?.errors) {
        message = Object.values(error.response.data.errors)[0][0];
    } else if (error.response?.data?.message) {
        message = error.response.data.message;
    }

    $(errorContainer).html(message);
    $(loadingContainer).hide();
    $(formContainer).show();
}

// =================== EVENT LISTENERS ===================

// --- Tombol Logout ---
$("#logout-btn").on('click', function(e) {
    e.preventDefault();
    if (!getToken()) {
        showNotification('error', 'Anda belum login', 3000);
        return;
    }
    apiClient.post('api/user/logout')
        .then(response => {
            console.log('[LOGOUT] Success:', response.data);
            clearAuthData();
            showNotification('info', 'Berhasil logout...');
            redirectToHome();
        })
        .catch(error => {
            console.error('[LOGOUT] Error:', error.response || error);
            if (error.response && error.response.status === 401) {
                clearAuthData();
                showNotification('warning', 'Sesi Anda telah berakhir.', 3000);
                redirectToHome(3000);
            } else {
                showNotification('error', error.response?.data?.message || 'Gagal untuk logout', 3000);
            }
        });
});

// --- Tombol Login ---
$("#form-login-btn").on('click', function(e) {
    e.preventDefault();
    const form = document.getElementById('form-login');
    if (!form.reportValidity()) return;

    $('#form-login-loading').show();
    $('#form-login-error').html('');
    $('#form-login').hide();

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    const url = baseUrl + 'api/user/login';

    axios.post(url, data)
        .then(response => {
            console.log('[LOGIN] Success:', response.data);
            setAuthData(response.data.token, data.email);
            showNotification('success', 'Berhasil login');
            redirectToHome();
        })
        .catch(error => handleApiError(error, 'login'));
});

// --- Tombol Register ---
$("#form-register-btn").on('click', function(e) {
    e.preventDefault();
    const form = document.getElementById('form-register');
    if (!form.reportValidity()) return;

    $('#form-register-loading').show();
    $('#form-register-error').html('');
    $('#form-register').hide();

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    const url = baseUrl + 'api/user/register';

    axios.post(url, data)
        .then(response => {
            console.log('[REGISTER] Success:', response.data);
            setAuthData(response.data.token, data.email);
            showNotification('success', 'Berhasil mendaftar');
            redirectToHome();
        })
        .catch(error => handleApiError(error, 'register'));
});