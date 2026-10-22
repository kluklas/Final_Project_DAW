"use strict";
import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginImageCrop from 'filepond-plugin-image-crop';
import FilePondPluginImageResize from 'filepond-plugin-image-resize';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';
import 'filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import {addSpinner, cleanErrors, deleteSpinner, processErrorResponse} from "../../config/global.js";
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

FilePond.registerPlugin(
    FilePondPluginFileValidateType,
    FilePondPluginImageExifOrientation,
    FilePondPluginImagePreview,
    FilePondPluginImageCrop,
    FilePondPluginImageResize,
    FilePondPluginImageTransform,
    FilePondPluginImageEdit
);

const Profile = function () {
    const Avatar = FilePond.create(
        document.querySelector('#avatar'),
        {
            labelIdle: `Suelta tu imagen aquí o <span class="filepond--label-action">Buscar</span>`,
            imagePreviewHeight: 170,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,
            stylePanelLayout: 'compact circle',
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'center bottom',
            styleButtonRemoveItemPosition: 'center bottom',
            styleButtonProcessItemPosition: 'right bottom',
        }
    );
    function saveProfile() {
        let that = this;
        let form = that.closest('form');
        let formData = new FormData(form);
        formData.append('avatar', Avatar.getFile().file);
        addSpinner(that);
        cleanErrors(form);
        axios.post(route('profile.update'), formData, {headers: {'Content-Type': 'multipart/form-data'}})
            .then(response => {
                if (!response.data.status) {
                    processErrorResponse(response, form, that);
                    return false;
                }
                toastr.success(response.data.message);
                window.location.reload();
            })
            .catch(error => {
                console.log(error.response);
                processErrorResponse(error.response, form, that);
            }).finally(() => {
            deleteSpinner(that);
        });
    }

    function initEventListeners() {
        let btnSaveProfile = document.getElementById('btnSaveProfile');
        if (btnSaveProfile) {
            btnSaveProfile.addEventListener('click', saveProfile);
        }
        Avatar.addFile(route('profile.avatar'));
    }

    function init() {
        initEventListeners();
    }

    return {
        init
    }
}();

document.addEventListener('DOMContentLoaded', function () {
    Profile.init();
});

