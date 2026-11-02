"use strict";
import { addSpinner, cleanErrors, deleteSpinner, processErrorResponse } from "../config/global.js";
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

const NewPassword = function () {
    function changePassword() {
        let that = this;
        let form = that.closest('form');
        let formData = new FormData(form);
        addSpinner(that);
        cleanErrors(form);

        axios.post(that.closest('form').getAttribute('action'), formData)
            .then(response => {
                if (response.status !== 200) {
                    processErrorResponse(response, form, that);
                    return false;
                }
                toastr.success("Contraseña actualizada correctamente");
                const redirectUrl = form.getAttribute('data-redirect-url');
                if (redirectUrl) {
                    window.location = redirectUrl;
                }
            }).catch (error => {
                console.log(error.response);
                processErrorResponse(error.response, form, that);
            }).finally(() => {
                deleteSpinner(that);
            });
    }

    function initEventListeners() {
        document.getElementById('new_password_submit').addEventListener('click', changePassword);
    }

    function init() {
        initEventListeners();
    }

    return {
        init
    }
}();

document.addEventListener('DOMContentLoaded', function () {
    NewPassword.init();
})