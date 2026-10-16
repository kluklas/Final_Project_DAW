import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

export function cleanErrors(form) {
    form.querySelectorAll('.is-invalid').forEach(element => element.classList.remove('is-invalid', 'border-pink-500', 'text-pink-600', 'focus:border-pink-500', 'focus:ring-pink-500', 'hover:border-pink-700'));
    form.querySelectorAll('p.invalid-feedback').forEach(element => element.remove());
}

let buttonText = '';

export function addSpinner(button, withText = true) {
    button.disabled = true
    buttonText = button.innerHTML;
    //Eliminamos contenido del boton
    button.innerHTML = '';

    let text = `<span class="flex justify-center align-middle">
                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="#E5E7EB"/>
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentColor"/>
                        </svg>`;
    if (withText) {
        text += `<span class="ml-3">Cargando...</span>`
    }
    text += `</span>`;
    //Agregamos el spinner
    button.insertAdjacentHTML('beforeend', text);
}

export function deleteSpinner(button) {
    button.disabled = false
    button.innerHTML = '';
    button.innerHTML = buttonText;
}

export function processErrorResponse(response, form, sendBtn = null) {
    if (response.code === 419) {
        //mandar al login
        window.location.href = route('login');
    }
    if (response.data && response.data.message) {
        toastr.error(response.data.message, 'Error');
    } else if (response.message) {
        toastr.error(response.message, 'Error');
    }

    if (sendBtn) {
        sendBtn.removeAttribute('data-kt-indicator');
        sendBtn.disabled = false;
    }

    let data = response;
    if (response.data) {
        data = response.data;
    }
    if (data.hasOwnProperty('errors')) {
        Object.keys(data.errors).forEach(function (key) {
            let input = form.querySelector('[name="' + key + '"]');
            if (input) {
                if (input.tagName === 'INPUT') {
                    input.classList.add('is-invalid', 'border-pink-500', 'text-pink-600', 'focus:border-pink-500', 'focus:ring-pink-500', 'hover:border-pink-700');
                    input.insertAdjacentHTML('afterend', '<p class="mt-2 text-pink-600 text-sm invalid-feedback">' + data.errors[key] + '</p>');
                } else if (input.tagName === 'SELECT') {
                    input.parentElement.querySelector('.select2 .select2-selection').classList.add('is-invalid', 'border-pink-500', 'text-pink-600', 'focus:border-pink-500', 'focus:ring-pink-500', 'hover:border-pink-700');
                    input.parentElement.querySelector('.select2.select2-container .dropdown-wrapper').insertAdjacentHTML('afterend', '<p class="mt-2 ml-2 text-pink-600 text-sm invalid-feedback">' + data.errors[key] + '</p>');
                }
            }
        });
    }
}

/**
 *
 * @param {String} id
 * @param {String} view
 * @returns {Element}
 */
export function instanceModal(id, view) {
    id = id.toString();
    view = view.toString();
    let body = document.querySelector('body');
    let modalForm = body.querySelector(id);
    if (modalForm) modalForm.remove();
    body.insertAdjacentHTML('beforeend', view);

    modalForm = body.querySelector(id);

    return modalForm;

}

document.addEventListener('click', function (e) {
    // Verifica si el elemento clicado tiene la clase 'button-ajax'
    if (e.target.closest('.button-ajax')) {
        e.preventDefault();

        let button = e.target.closest('.button-ajax');
        let action = button.getAttribute('data-action');
        let method = button.getAttribute('data-method');
        let csrf = button.getAttribute('data-csrf');

        axios.request({
            url: action,
            method: method,
            data: {
                _token: csrf
            },
        })
            .then(function (response) {
                if (response.data.route) {
                    location.href = response.data.route;
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }
});