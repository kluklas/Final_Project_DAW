"use strict";
import { addSpinner, cleanErrors, deleteSpinner, processErrorResponse } from "../config/global.js";
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

const KTSigninGeneral = function () {
    let form;
    let submitButton;

    let handleSubmitAjax = function () {
        form.querySelector('#password').addEventListener('keyup', function (e) {
            if (e.keyCode === 13) {
                submitButton.click();
            }
        });

        form.addEventListener('input', function () {
            cleanErrors(form);
        });

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            addSpinner(submitButton);
            cleanErrors(form);

            axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form))
                .then(function (response) {
                    if (!response.data.status) {
                        processErrorResponse(response, form, submitButton);
                    }
                    form.reset();
                    toastr.success(response.data.message, "Correcto");
                    if (response.data.route) {
                        location.href = response.data.route;
                    }
                }).catch(function (error) {
                    processErrorResponse(error.response, form, submitButton);
                }).finally(() => {
                    deleteSpinner(submitButton);
                });
        });
    }

    return {
        init: function () {
            form = document.querySelector('#login_form');
            submitButton = document.querySelector('#login_submit');
            handleSubmitAjax();
        }
    };
}();

document.addEventListener('DOMContentLoaded', function () {
    KTSigninGeneral.init();
});