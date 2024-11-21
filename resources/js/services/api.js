<script>
// Función para obtener el token
function getToken() {
    return localStorage.getItem('jwt_token') || 
           document.cookie.split('; ').find(row => row.startsWith('jwt_token='))?.split('=')[1];
}

// Configurar headers para todas las peticiones AJAX
$.ajaxSetup({
    beforeSend: function(xhr) {
        const token = getToken();
        if (token) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
        console.log('Token enviado:', token);
    }
});

// Interceptar respuestas para debug
$(document).ajaxComplete(function(event, xhr, settings) {
    console.log('Respuesta Ajax:', {
        url: settings.url,
        status: xhr.status,
        response: xhr.responseText
    });
});

// Si estás usando fetch, también puedes interceptarlo
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
    
    console.log('Fetch request:', {
        url: resource,
        config: config
    });
    
    return originalFetch(resource, config);
};
</script>