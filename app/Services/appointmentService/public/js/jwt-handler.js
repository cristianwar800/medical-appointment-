// Manejador de JWT
const JWTHandler = {
    // Obtener token del localStorage o cookie
    getToken: function() {
        const token = localStorage.getItem('jwt_token') || this.getCookie('jwt_token');
        console.log('Token obtenido:', token ? 'Existe' : 'No existe');
        return token;
    },

    // Guardar token
    setToken: function(token) {
        console.log('Guardando token...');
        localStorage.setItem('jwt_token', token);
        this.setCookie('jwt_token', token, 1); // 1 día
    },

    // Eliminar token
    removeToken: function() {
        console.log('Eliminando token...');
        localStorage.removeItem('jwt_token');
        this.deleteCookie('jwt_token');
    },

    // Verificar si está autenticado
    isAuthenticated: function() {
        const token = this.getToken();
        if (!token) {
            console.log('No hay token - Usuario no autenticado');
            return false;
        }

        try {
            const payload = this.decodeToken(token);
            const isValid = payload && payload.exp > Date.now() / 1000;
            console.log('Token válido:', isValid);
            return isValid;
        } catch (e) {
            console.log('Error al verificar token:', e.message);
            return false;
        }
    },

    // Decodificar token
    decodeToken: function(token) {
        try {
            const base64Url = token.split('.')[1];
            const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            return JSON.parse(window.atob(base64));
        } catch (e) {
            console.error('Error decodificando token:', e.message);
            return null;
        }
    },

    // Obtener información del usuario
    getUser: function() {
        const token = this.getToken();
        return token ? this.decodeToken(token) : null;
    },

    // Manejo de cookies
    setCookie: function(name, value, days) {
        let expires = '';
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toUTCString();
        }
        document.cookie = name + '=' + value + expires + '; path=/';
    },

    getCookie: function(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    },

    deleteCookie: function(name) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    },

    // Configurar interceptores para Ajax
    setupInterceptors: function() {
        console.log('Configurando interceptores...');
        
        // Para jQuery Ajax
        $.ajaxSetup({
            beforeSend: function(xhr) {
                const token = JWTHandler.getToken();
                if (token) {
                    xhr.setRequestHeader('Authorization', `Bearer ${token}`);
                }
            }
        });

        // Manejar errores de autenticación
        $(document).ajaxError(function(event, jqXHR) {
            if (jqXHR.status === 401) {
                console.log('Error de autenticación detectado');
                JWTHandler.removeToken();
                window.location.href = 'http://localhost:8082/login';
            }
        });
    },

    // Verificar token periódicamente
    startTokenVerification: function() {
        console.log('Iniciando verificación periódica del token...');
        setInterval(() => {
            if (this.isAuthenticated()) {
                const user = this.getUser();
                if (!user || user.exp < Date.now() / 1000) {
                    console.log('Token expirado durante verificación');
                    this.removeToken();
                    window.location.href = 'http://localhost:8082/login';
                }
            }
        }, 60000); // Verificar cada minuto
    }
};

// Inicializar cuando el documento esté listo
$(document).ready(function() {
    console.log('Inicializando JWTHandler...');
    JWTHandler.setupInterceptors();
    JWTHandler.startTokenVerification();
});