"use strict";
import {addSpinner, cleanErrors, deleteSpinner, processErrorResponse} from "../config/global.js";
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

const ResetPassword = function () {
    let submitButton;

    function sendEmail(e) {
        e.preventDefault();
        let form = submitButton.closest('form');
        let formData = new FormData(form);
        addSpinner(submitButton);
        cleanErrors(form);

        axios.post(submitButton.closest('form').getAttribute('action'), formData)
            .then(response => {
                if (!response.data.status) {
                    processErrorResponse(response, form, submitButton);
                    return false;
                }
                form.reset();
                toastr.success(response.data.message);
            }).catch(error => {
                console.log(error.response);
                processErrorResponse(error.response, form, submitButton);
            }).finally(() => {
                deleteSpinner(submitButton);
            });
    }

    function init() {
        submitButton = document.getElementById('passwrod_reset_submit');
        submitButton.addEventListener('click', sendEmail);
    }

    return {
        init
    }
}();

document.addEventListener('DOMContentLoaded', function () {
    ResetPassword.init();
})