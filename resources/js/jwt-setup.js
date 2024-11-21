const setupJWT = {
    init() {
        // Función para obtener el token
        const getToken = () => {
            return localStorage.getItem('jwt_token') || 
                   document.cookie.split('; ').find(row => row.startsWith('jwt_token='))?.split('=')[1];
        };

        // Configurar Axios
        if (window.axios) {
            window.axios.interceptors.request.use(
                config => {
                    const token = getToken();
                    if (token) {
                        config.headers['Authorization'] = `Bearer ${token}`;
                    }
                    console.log('Axios Request:', config);
                    return config;
                },
                error => {
                    console.error('Axios Request Error:', error);
                    return Promise.reject(error);
                }
            );

            window.axios.interceptors.response.use(
                response => {
                    console.log('Axios Response:', response);
                    return response;
                },
                error => {
                    console.error('Axios Response Error:', error);
                    if (error.response && error.response.status === 401) {
                        localStorage.removeItem('jwt_token');
                        window.location.href = '/login';
                    }
                    return Promise.reject(error);
                }
            );
        }

        // Configurar Fetch
        const originalFetch = window.fetch;
        window.fetch = function() {
            let [resource, config] = arguments;
            const token = getToken();
            
            if (token) {
                if (!config) {
                    config = {};
                }
                if (!config.headers) {
                    config.headers = {};
                }
                config.headers['Authorization'] = `Bearer ${token}`;
            }
            
            return originalFetch(resource, config)
                .then(response => {
                    if (!response.ok && response.status === 401) {
                        localStorage.removeItem('jwt_token');
                        window.location.href = '/login';
                    }
                    return response;
                });
        };

        // Manejar el formulario de login
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                try {
                    const response = await fetch('/api/auth/login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            email: document.getElementById('email').value,
                            password: document.getElementById('password').value
                        })
                    });

                    const data = await response.json();
                    
                    if (data.access_token) {
                        localStorage.setItem('jwt_token', data.access_token);
                        window.location.href = '/dashboard';
                    } else {
                        alert('Error en las credenciales');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error al iniciar sesión');
                }
            });
        }
    }
};

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => setupJWT.init());